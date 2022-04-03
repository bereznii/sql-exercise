<?php

namespace Database\Seeders\Orders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    private const ORDERS_CUSTOMERS_LIMIT = 1000;
    public const ORDERS_CUSTOMERS_TABLE = 'orders.customers';

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
        DB::table(self::ORDERS_CUSTOMERS_TABLE)->truncate();

        $emails = [];
        $phones = [];
        $employees = [];
        for ($i = 0; $i < self::ORDERS_CUSTOMERS_LIMIT; $i++) {
            $gender = self::GENDERS[array_rand(self::GENDERS)];
            $phones[] = $this->generateUniquePhone($phones);
            $emails[] = $this->generateUniqueEmail($emails);

            $employees[] = [
                'first_name' => $this->faker->firstName($gender),
                'last_name' => $this->hasLastName() ? $this->faker->lastName() : null,
                'phone' => last($phones),
                'email' => $this->hasEmail() ? last($emails) : null,
                'gender' => $gender,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($employees) > 100) {
                DB::table(self::ORDERS_CUSTOMERS_TABLE)->insert($employees);
                $employees = [];
            }
        }

        DB::table(self::ORDERS_CUSTOMERS_TABLE)->insert($employees);
    }

    /**
     * @return bool
     */
    private function hasLastName(): bool
    {
        return (bool) mt_rand(0,1);
    }

    /**
     * @return bool
     */
    private function hasEmail(): bool
    {
        return ! (bool) mt_rand(0,3);
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
}
