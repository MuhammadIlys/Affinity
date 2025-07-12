<?php

namespace App\Console\Commands;

use App\Models\EmployeesModel;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\ConnecteamService;
use Illuminate\Support\Facades\Log;

class CalculateWeeklyConnecteamHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-weekly-connecteam-hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ConnecteamService $connecteam)
    {
        $maxRetries = 5;
        $attempt = 0;

        while ($attempt < $maxRetries) {
        try {
        $attempt++;
        // Set week range (previous Monday to Sunday)
        $startDate = Carbon::now()->startOfWeek()->toDateString();         // Monday 12:00 AM
        $endDate = Carbon::now()->endOfWeek()->toDateString();  // Sunday 11:59:59 PM

        // Get employees who have Connecteam ID
        $employees = EmployeesModel::where('status', 'active')->whereNotNull('connecteam_user_id')->get();
        $employeeMap = $employees->mapWithKeys(function ($employee) {
            return [
                $employee->connecteam_user_id => [
                    'employee_id' => $employee->id,
                    'referrer_id' => $employee->refered_by,
                ]
            ];
        });

        $connecteamUserIds = $employees->pluck('connecteam_user_id')->toArray();

        $result = $connecteam->getTotalHoursWorked($connecteamUserIds, $startDate, $endDate, $employeeMap);

        if(!empty($result['success']) && $result['success'] === true){
            $this->info("Weekly hours successfully completed on attempt #$attempt");
            return 0;
        }
        else{
             $this->warn("Attempt #$attempt failed: API returned unsuccessful result.");
            // Check if this was the last attempt
            if ($attempt >= $maxRetries) {
                $this->error("Max retries reached with unsuccessful API response.");
                Log::error("Weekly hours sync failed after $maxRetries attempts (API returned false).", ['error' => $result['error'] ?? '']);
                return 1;
            }

            sleep(5); // Wait a few seconds before retry
        }
        } catch (\Exception $e) {
            $this->error("Attempt $attempt failed: " . $e->getMessage());
            if ($attempt >= $maxRetries) {
                Log::error("Getting employees weekly hours Cron Job failed after $maxRetries attempts", [
                    'exception' => $e
                ]);
                return 1;
            }

            sleep(5); // Wait a few seconds before retry
        }
    }
    }
}
