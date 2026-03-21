<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\SettingsModel;
use App\Models\User;
use App\Models\WorkHoursModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConnecteamService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.connecteam.url');
        $this->apiKey = config('services.connecteam.api_key');
    }

    public function createUser(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post($this->apiUrl . '?sendActivation=false', [$data]);

            if ($response->successful()) {
                return ['success' => true, 'response' => $response->json()];
            } else {
                Log::error('Connecteam API error:', $response->json());
                return ['success' => false, 'error' => $response->json()];
            }
        } catch (\Exception $e) {
            Log::error('Connecteam Exception: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getUser($userId): array
    {
        //  $requestUrl = $this->apiUrl . '/' . $userId;
        // dd($requestUrl);

        try {
            // Only fetch active users
            $response = Http::withHeaders([
                'X-API-KEY' => $this->apiKey,
                'Accept'    => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL in dev
            ])->get($this->apiUrl . '?userStatus=active');

            if ($response->successful()) {
                $body = $response->json();
                $users = $body['data']['users'] ?? [];

                // Find the user by ID
                $foundUser = collect($users)->firstWhere('userId', (int) $userId);

                if ($foundUser) {
                    return [
                        'success' => true,
                        'response' => $foundUser
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => "User ID {$userId} not found in the active user list."
                    ];
                }
            } else {
                Log::error('Connecteam API list users error:', $response->json());
                return ['success' => false, 'error' => $response->json()];
            }
        } catch (\Exception $e) {
            Log::error('Connecteam Fetch Exception: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getTotalHoursWorked(array $connecteamUserIds, $startDate, $endDate, $employeeMap)
    {
        try {
            $client = Http::timeout(300)->withHeaders([
                'X-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ]);

            $clocks = [];
            // 1. First we will get all time clocks that are in our account
            $response = $client->get('https://api.connecteam.com/time-clock/v1/time-clocks');
            if ($response->successful()) {
                $clocks = $response->json('data.timeClocks', []);
            } else {
                $statusCode = $response->status();
                $errorMessage = "Failed to fetch time clocks data. ";

                if ($statusCode === 429) {
                    $errorMessage .= "Error: Too Many Requests (HTTP 429). ";
                    $errorMessage .= $this->getRateLimitDetails($response); // Correctly called here
                } else {
                    $errorMessage .= "HTTP Status: {$statusCode}. ";
                    $errorMessage .= "Response: " . $response->body();
                }
                // Log the error for debugging
                Log::error('Connecteam API Error - Failed to fetch time clocks:', ['message' => $errorMessage]);
                return ['success' => false, 'message' => $errorMessage];
            }

            // 2. Loop through every clock
            if (!empty($clocks)) {
                foreach ($clocks as $clock) {
                    // Check if the timeclock is deleted then don't check for it's time activities
                    if ($clock['isArchived']) {
                        continue;
                    }
                    // Added a check for null id and default to prevent potential issues
                    $timeClockId = $clock['id'] ?? null;
                    if (is_null($timeClockId)) {
                        Log::warning("Skipping time clock without an ID: " . json_encode($clock));
                        continue;
                    }
                    $timeClockName = $clock['name'] ?? 'Time Clock';

                    //3. Now we will get time activities for each time clock
                    $res = $client->get("https://api.connecteam.com/time-clock/v1/time-clocks/{$timeClockId}/time-activities", [
                        'startDate' => $startDate, // YYYY-MM-DD
                        'endDate'   => $endDate, // YYYY-MM-DD
                        'userIds'   => $connecteamUserIds,
                        'limit'     => 1000,
                    ]);
                    if ($res->successful()) {
                        $activities = $res->json('data.timeActivitiesByUsers', []);
                    } else {
                        // --- Apply rate limit check here as well ---
                        $statusCode = $res->status();
                        $errorMessage = "Failed to fetch time activities for time clock #{$timeClockId}. ";

                        if ($statusCode === 429) {
                            $errorMessage .= "Error: Too Many Requests (HTTP 429). ";
                            $errorMessage .= $this->getRateLimitDetails($res); // Correctly called here
                        } else {
                            $errorMessage .= "HTTP Status: {$statusCode}. ";
                            $errorMessage .= "Response: " . $res->body();
                        }
                        // Log the error for debugging
                        Log::error('Connecteam API Error - Failed to fetch time activities:', ['message' => $errorMessage, 'timeClockId' => $timeClockId]);
                        // It's crucial to decide: do you want to stop the entire process
                        // if one time clock's activities fail, or log and continue to the next?
                        // For now, it returns, stopping the process.
                        return ['success' => false, 'message' => $errorMessage];
                    }

                    // 4. Now group and sum durations
                    $hoursByUser = [];
                    foreach ($activities as $act) {
                        $uid = $act['userId'];
                        if (!$uid || !isset($act['shifts']) || empty($act['shifts'])) {
                            continue;
                        }

                        $totalSeconds = 0;

                        if (EmployeesModel::where('connecteam_user_id', $uid)->exists()) {
                            foreach ($act['shifts'] as $shift) {
                                $start = $shift['start']['timestamp'] ?? null;
                                $end = $shift['end']['timestamp'] ?? null;

                                if ($start && $end && $end > $start) {
                                    $totalSeconds += $end - $start;
                                }
                            }

                            $hoursByUser[$uid] = ($hoursByUser[$uid] ?? 0) + $totalSeconds;
                        } else {
                            continue;
                        }
                    }

                    if (!empty($hoursByUser)) {
                        foreach ($hoursByUser as $connecteamUserId => $secondsWorked) {
                            // Ensure the connecteamUserId actually exists in the employeeMap
                            if (!isset($employeeMap[$connecteamUserId])) {
                                Log::warning("Employee mapping missing for Connecteam user ID: {$connecteamUserId}");
                                continue;
                            }

                            $map = $employeeMap[$connecteamUserId];
                            $fromDate = $startDate;
                            $toDate = $endDate;
                            $totalHours = round($secondsWorked / 3600, 2);
                            // Save data only if employee did some work
                            if ($totalHours > 0) {
                                // Check if a user entry exists for this week or not
                                $entryExistsForWeek = WorkHoursModel::where('from_date', $fromDate)
                                    ->where('to_date', $toDate)
                                    ->where('timeclock_id', $timeClockId) // Crucial to filter by timeclock_id
                                    ->where('employee_id', $map['employee_id'])
                                    ->first();

                                $tokensPerHour = SettingsModel::value('points');

                                if (!$entryExistsForWeek) {
                                    WorkHoursModel::create([
                                        'employee_id' => $map['employee_id'],
                                        'referrer_id' => $map['referrer_id'],
                                        'connecteam_user_id' => $connecteamUserId,
                                        'timeclock_id' => $timeClockId,
                                        'timeclock_name' => $timeClockName,
                                        'from_date' => $fromDate,
                                        'to_date' => $toDate,
                                        'total_hours' => $totalHours,
                                        'tokens' => $totalHours * $tokensPerHour
                                    ]);

                                    EmployeesModel::where('id', $map['employee_id'])->update([
                                        'hours' => DB::raw('hours + ' . $totalHours),
                                        'total_amount' => DB::raw('total_amount + ' . $totalHours),
                                    ]);
                                    // Update the User model
                                    User::where('id', $map['referrer_id'])->increment('total_amount', $totalHours);
                                
                                } else if ($entryExistsForWeek && $entryExistsForWeek->total_hours != $totalHours) {
                                    // Calculate the additional hours
                                    $extraHours = $totalHours - $entryExistsForWeek->total_hours;

                                    $entryExistsForWeek->update([
                                        'total_hours' => $totalHours,
                                        'tokens' => $totalHours * $tokensPerHour
                                    ]);

                                    // Add only the extra hours (not the entire total) to the employee and referrer
                                    EmployeesModel::where('id', $map['employee_id'])
                                        ->increment('hours', $extraHours)
                                        ->increment('total_amount', $extraHours);

                                    User::where('id', $map['referrer_id'])->increment('total_amount', $extraHours);
                                }
                            }
                        }
                    }
                }
                return ['success' => true, 'message' => 'Done.'];
            } else {
                return ['success' => true, 'message' => 'There is no time clocks present.'];
            }
        } catch (\Exception $e) {
            // General catch-all for unexpected errors (e.g., network issues not resulting in HTTP response)
            Log::error('Connecteam getTotalHoursWorked Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return ['success' => false, 'message' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }

    // ... (Your getRateLimitDetails method should be here, within the class) ...
    protected function getRateLimitDetails(\Illuminate\Http\Client\Response $response): string
    {
        $details = [];
        $limit = $response->header('x-ratelimit-minute-limit');
        $remaining = $response->header('x-ratelimit-minute-remaining');
        $reset = $response->header('x-ratelimit-minute-reset');
        $retryAfter = $response->header('Retry-After');

        if ($limit) {
            $details[] = "Limit: {$limit} req/min";
        }
        if ($remaining !== null) {
            $details[] = "Remaining: {$remaining} req";
        }
        if ($reset) {
            try {
                $resetDateTime = new \DateTimeImmutable('@' . $reset);
                $details[] = "Reset: " . $resetDateTime->format('Y-m-d H:i:s T');
            } catch (\Exception $e) {
                $details[] = "Reset (raw): {$reset}";
            }
        }
        if ($retryAfter) {
            $details[] = "Retry-After: {$retryAfter} seconds";
        }

        $body = $response->body();
        if (!empty($body) && $body !== '[]' && $body !== '{}') {
            $details[] = "Response Body: " . $body;
        }

        return !empty($details) ? implode('. ', $details) : "No specific rate limit headers or body found.";
    }
}
