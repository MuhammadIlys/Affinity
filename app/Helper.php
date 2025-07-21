<?php

use App\Models\EmployeesModel;
use App\Models\SettingsModel;
use App\Models\User;
use App\Models\WorkHoursModel;

if (!function_exists('calculate_referrer_bonus')) {
function calculate_referrer_bonus(User $referrer): float
    {
        $referrer_percent = SettingsModel::value('referrer_percent');
        // $referredEmployees = EmployeesModel::where('refered_by', $referrer->id)->get();
        $referredEmployees = WorkHoursModel::where('referrer_id', $referrer->id)->get();
        $totalEarnings = 0;
        foreach ($referredEmployees as $employee) {
            $totalEarnings += ($employee->total_hours * $referrer_percent);
        }

        return round($totalEarnings, 2);
    }
}

?>