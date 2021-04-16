<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Jose Queiroz',
            'email' => 'josequeiroz@gmail.com',
            'password' => Hash::make('password'),
            'cpf_cnpj' => '10702387401',
            'type' => '10702387401',
        ]);
    }
}