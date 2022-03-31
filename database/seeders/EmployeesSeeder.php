<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EmployeesSeeder extends Seeder
{
    private const DEPARTMENT_EMPLOYEES_LIMIT = [20, 50];
    private const EMPLOYEES_TABLE = 'employees';

    private const GENDERS = ['male', 'female'];

    /** @var Generator $faker */
    private Generator $faker;

    /**
     *
     */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::table(self::EMPLOYEES_TABLE)->truncate();

        $departments = DB::table('departments')->pluck('id');

        $employees = [];
        foreach ($departments as $department) {
            for ($i = 0; $i < random_int(...self::DEPARTMENT_EMPLOYEES_LIMIT); $i++) {
                $gender = self::GENDERS[array_rand(self::GENDERS)];
                $employees[] = [
                    'department_id' => $department,
                    'gender' => $gender,
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName(),
                    'phone' => $this->generatePhone(),
                    'email' => $this->faker->email(),
                    'salary' => $this->generateSalary(),
                    'hired_at' => Carbon::now()->subDays(rand(0, 365)),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            DB::table(self::EMPLOYEES_TABLE)->insert($employees);
        }
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function generatePhone(): int
    {
        return (int) ('380' . random_int(100000000, 999999999));
    }

    /**
     * @return int
     */
    private function generateSalary(): int
    {
        $possibleSalaries = [1000, 1200, 1400, 1600, 1800, 2000, 2500, 3000, 3500, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 15000, 20000];
        return $possibleSalaries[array_rand($possibleSalaries)];
    }
}
