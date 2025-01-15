<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DivisionType;
use App\Models\EmployeeRole;
use App\Models\Payscale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Payscale::create([
            'name' => 'Intern Developer',

            'min_salary' => 380000,

        ]);

        EmployeeRole::create([
            'name' => 'Junior Developer',
            'sort_no' => '10',
            'payscale_id' => 1,

        ]);

        DivisionType::create([
            'name' => 'Department',

        ]);

        Department::create([
            'name' => 'IT',
            'nick_name' => 'IT',
            'division_type_id' => 1,

        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'employee_role_id' => 1,
            'department_id' => 1,
            'department_id' => 1,
            'gender_id' => 1,
        ]);
    }
}
