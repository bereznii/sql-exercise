<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CompaniesSeeder::class);
         $this->call(DepartmentsSeeder::class);
         $this->call(EmployeesSeeder::class);
    }
}
