<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CompaniesSeeder extends Seeder
{
    private const COMPANIES_LIMIT = 10;
    private const COMPANIES_TABLE = 'companies';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $companies = [];
        for ($i = 0; $i < self::COMPANIES_LIMIT; $i++) {
            $companies[] = [
                'id' => Uuid::uuid4()->toString(),
                'name' => $faker->company(),
                'created_at' => Carbon::now()->subDays(rand(0, 120)),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table(self::COMPANIES_TABLE)->truncate();
        DB::table(self::COMPANIES_TABLE)->insert($companies);
    }
}
