<?php

namespace Database\Seeders;

use Database\Seeders\Orders\CustomersSeeder;
use Database\Seeders\Orders\OrdersSeeder;
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

         $this->call(CustomersSeeder::class);
         $this->call(OrdersSeeder::class);
    }
}
