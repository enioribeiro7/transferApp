<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_type')->insert([
            'name' => 'Lojista',
            'status' => 1,
            'uuid' => '0ebd676f-bc00-4171-b2cd-8868e1fe567e',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),            
        ]);

        DB::table('users_type')->insert([
            'name' => 'Usuário',
            'status' => 1,
            'uuid' => '0ebd676f-bc00-4171-b2cd-8868e1fe567e',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),            
        ]);        
    }
}
