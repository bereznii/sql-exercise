<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DepartmentsSeeder extends Seeder
{
    private const COMPANY_DEPARTMENTS_LIMIT = [5, 10];
    private const DEPARTMENTS_TABLE = 'departments';

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $companies = DB::table('companies')->pluck('id');

        $departments = [];
        foreach ($companies as $company) {
            for ($i = 0; $i < random_int(...self::COMPANY_DEPARTMENTS_LIMIT); $i++) {
                $departments[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'company_id' => $company,
                    'name' => $faker->jobTitle(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table(self::DEPARTMENTS_TABLE)->truncate();
        DB::table(self::DEPARTMENTS_TABLE)->insert($departments);
    }
}
