<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MasterAdmin;
use App\Models\Staff;
use App\Models\SystemUser;
use App\Models\User;
use Database\Factories\CompanyFactory;
use Database\Factories\MasterAdminFactory;
use Database\Factories\StaffFactory;
use Database\Factories\SystemUserFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        MasterAdmin::factory(1)->create();
        Company::factory(10)->create();
        SystemUser::factory(50)->create();
        Staff::factory(100)->create();
    }
}
