<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balances')->insert([
            'user_uuid' => '879620ac-2efe-4b09-91a5-d4a949af09d4',
            'balance' => 100.00,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        DB::table('balances')->insert([
            'user_uuid' => '27ac5a4e-afb7-4da1-8ba8-9e17ef38d2f4',
            'balance' => 0,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
