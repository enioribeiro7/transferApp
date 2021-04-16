<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'Jose Queiroz Lojista',
            'email' => 'josequeiroz@gmail.com',
            'password' => Hash::make('password'),
            'cpf_cnpj' => '10702387401',
            'uuid' => Str::uuid(),
            'type' => '0ebd676f-bc00-4171-b2cd-8868e1fe567e',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),            
        ]);

        DB::table('users')->insert([
            'name' => 'Joao Pedro Usuario',
            'email' => 'joaopedro@gmail.com',
            'password' => Hash::make('password'),
            'cpf_cnpj' => '33922288819',
            'uuid' => Str::uuid(),
            'type' => '4abc3646-9f97-49b1-ad30-eaff9b1e0eb3',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),            
        ]);        
    }
}