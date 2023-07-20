<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Instruction::factory(50)->create();
        \App\Models\Vendor::factory(20)->create();
        \App\Models\Customer::factory(25)->create();
        \App\Models\Transaction::factory(25)->create();

        // \App\Models\User::create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('admin123'),
        //     'first_name' => 'Test First Name',
        //     'last_name' => 'Test Last Name'
        // ]);
    }
}
