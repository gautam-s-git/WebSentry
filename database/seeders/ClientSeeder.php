<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $clients=self::getClientList();

        DB::table('users')->insert($clients);


    }

    private static function getClientList(){

      $clients = [
            ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'active' => 1,'password'=>Hash::make('1234567'),'email_verified_at'=>now()],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'active' => 1,'password'=>Hash::make('1234567'),'email_verified_at'=>now()],
            ['name' => 'Bob Johnson', 'email' => 'bob.johnson@example.com', 'active' => 1,'password'=>Hash::make('1234567'),'email_verified_at'=>null],
        ];

        return $clients;
    }
}
