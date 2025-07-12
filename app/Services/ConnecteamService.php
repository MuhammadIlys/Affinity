<?php

namespace App\Services;

use App\Models\EmployeesModel;
use App\Models\WorkHoursModel;
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
        try{
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
            }
            else{
                return ['success' => false, 'message' => 'Failed to fetch time clocks data.'];
            }

            // 2. Loop through every clock
            if(!empty($clocks)){
                foreach($clocks as $clock){
                    // Check if the timeclock is deleted then don't check for it's time activities
                    if($clock['isArchived']){
                        continue;
                    }
                    $timeClockId = $clock['id'] ?? '11541275';
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
                    }
                    else{
                        return ['success' => false, 'message' => 'Failed to fetch time activities for time clock # '. $timeClockId];
                    }

                    // 4. Now group and sum durations
                    $hoursByUser = [];
                    foreach ($activities as $act) {
                        $uid = $act['userId'];
                        if (!$uid || !isset($act['shifts']) || empty($act['shifts'])) {
                            continue;
                        }

                        $totalSeconds = 0;

                        if(EmployeesModel::where('connecteam_user_id', $uid)->exists()){
                            foreach ($act['shifts'] as $shift) {
                                $start = $shift['start']['timestamp'] ?? null;
                                $end = $shift['end']['timestamp'] ?? null;

                                if ($start && $end && $end > $start) {
                                    $totalSeconds += $end - $start;
                                }
                            }

                            $hoursByUser[$uid] = ($hoursByUser[$uid] ?? 0) + $totalSeconds;
                        }
                        else{
                            continue;
                        }
                    }

                    if(!empty($hoursByUser)){
                        foreach ($hoursByUser as $connecteamUserId => $secondsWorked) {
                            $map = $employeeMap[$connecteamUserId];
                            $fromDate = $startDate;
                            $toDate = $endDate;
                            $totalHours = round($secondsWorked / 3600, 2);
                            // Save data only if employee did some work
                            if($totalHours > 0){
                                // Check if a user entry exists for this week or not
                                $entryExistsForWeek = WorkHoursModel::where('from_date', $fromDate)
                                ->where('to_date', $toDate)
                                ->where('timeclock_id', $timeClockId)
                                ->where('employee_id', $map['employee_id'])
                                ->first();

                                if(!$entryExistsForWeek){
                                    WorkHoursModel::create([
                                        'employee_id' => $map['employee_id'],
                                        'referrer_id' => $map['referrer_id'],
                                        'connecteam_user_id' => $connecteamUserId,
                                        'timeclock_id' => $timeClockId,
                                        'timeclock_name' => $timeClockName,
                                        'from_date' => $fromDate,
                                        'to_date' => $toDate,
                                        'total_hours' => $totalHours,
                                    ]);
                                }
                            }
                        }
                    }
                }
                return ['success' => true, 'message' => 'Done.'];
            }
            else{
                return ['success' => true, 'message' => 'There is no time clocks present.'];
            }
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e];
        }
    }
}
