<?php

namespace Database\Seeders\Orders;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    public const ORDERS_ORDERS_ORIGIN_ENUM = ['store', 'website', 'app'];

    private const ORDERS_ORDERS_RANGE = [1, 10];
    private const ORDERS_ORDERS_TABLE = 'orders.orders';

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
        DB::table(self::ORDERS_ORDERS_TABLE)->truncate();

        $customers = DB::table(CustomersSeeder::ORDERS_CUSTOMERS_TABLE)->pluck('id');

        foreach ($customers as $customer) {
            $orders = [];
            for ($i = 0; $i < mt_rand(...self::ORDERS_ORDERS_RANGE); $i++) {
                $isConfirmed = $this->isConfirmed();

                $orders[] = [
                    'customer_id' => $customer,
                    'sum' => $isConfirmed ? $this->generateSum() : null,
                    'loyalty' => $this->hasLoyalty(),
                    'origin' => self::ORDERS_ORDERS_ORIGIN_ENUM[array_rand(self::ORDERS_ORDERS_ORIGIN_ENUM)],
                    'country' => $this->faker->country(),
                    'city' => $this->faker->city(),
                    'street' => $this->faker->streetName(),
                    'building' => $this->faker->buildingNumber(),
                    'postcode' => $this->faker->postcode(),
                    'delivered_at' => $isConfirmed
                        ? ($this->isDelivered() ? Carbon::now() : null)
                        : null,
                    'confirmed_at' => $isConfirmed ? Carbon::now() : null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            DB::table(self::ORDERS_ORDERS_TABLE)->insert($orders);
        }
    }

    /**
     * @return int
     */
    private function generateSum(): int
    {
        return mt_rand(100, 3000) * 100; //cents
    }

    /**
     * @return bool
     */
    private function isConfirmed(): bool
    {
        return (bool) mt_rand(0,3);
    }

    /**
     * @return bool
     */
    private function hasLoyalty(): bool
    {
        return (bool) mt_rand(0,3);
    }

    /**
     * @return bool
     */
    private function isDelivered(): bool
    {
        return (bool) mt_rand(0,1);
    }
}
