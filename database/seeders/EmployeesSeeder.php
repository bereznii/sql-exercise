<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    private const DEPARTMENT_EMPLOYEES_LIMIT = [30, 70];
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

        $emails = [];
        $phones = [];
        foreach ($departments as $department) {
            $employees = [];
            for ($i = 0; $i < random_int(...self::DEPARTMENT_EMPLOYEES_LIMIT); $i++) {
                $gender = self::GENDERS[array_rand(self::GENDERS)];
                $phones[] = $this->generateUniquePhone($phones);
                $emails[] = $this->generateUniqueEmail($emails);
                $employees[] = [
                    'department_id' => $department,
                    'gender' => $gender,
                    'first_name' => $this->faker->firstName($gender),
                    'last_name' => $this->faker->lastName(),
                    'phone' => last($phones),
                    'email' => last($emails),
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
     * @param array $existingPhones
     * @return string
     */
    private function generateUniquePhone(array $existingPhones): string
    {
        $possiblePhone = (int) ('380' . mt_rand(100000000, 999999999));

        if (!in_array($possiblePhone, $existingPhones)) {
            return $possiblePhone;
        } else {
            return $this->generateUniqueEmail($existingPhones);
        }
    }

    /**
     * @param array $existingEmails
     * @return string
     */
    private function generateUniqueEmail(array $existingEmails): string
    {
        $possibleEmail = $this->faker->email();

        if (!in_array($possibleEmail, $existingEmails)) {
            return $possibleEmail;
        } else {
            return $this->generateUniqueEmail($existingEmails);
        }
    }

    /**
     * @return int
     */
    private function generateSalary(): int
    {
        $possibleSalaries = [1000, 1200, 1400, 1600, 1800, 2000, 2500, 3000, 3500, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 15000, 20000];
        return $possibleSalaries[mt_rand(0, count($possibleSalaries)-1)];
    }
}
