<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'code' => 'RUB',
                'symbol' => '₽',
                'is_main' => 1,
                'rate' => 1,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'code' => 'USD',
                'symbol' => '$',
                'is_main' => 0,
                'rate' => 65,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'code' => 'EUR',
                'symbol' => '€',
                'is_main' => 0,
                'rate' => 70,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
