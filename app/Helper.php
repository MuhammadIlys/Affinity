<?php

use App\Models\EmployeesModel;
use App\Models\SettingsModel;
use App\Models\User;
use App\Models\WorkHoursModel;

function calculate_referrer_bonus(User $referrer): float
    {
        $referrer_percent = SettingsModel::value('referrer_percent');
        // $referredEmployees = EmployeesModel::where('refered_by', $referrer->id)->get();
        $referredEmployees = WorkHoursModel::where('referrer_id', $referrer->id)->get();
        // dd($referredEmployees);
        $totalEarnings = 0;
        foreach ($referredEmployees as $employee) {
            $totalEarnings += ($employee->total_hours * $referrer_percent) / 100;
        }

        return round($totalEarnings, 2);
    }

?>