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
        \App\Models\User::factory(2)->create();
        \App\Models\Instruction::factory(44)->create();

        // \App\Models\User::create([
        //     'username' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('admin123'),
        //     'first_name' => 'Test First Name',
        //     'last_name' => 'Test Last Name'
        // ]);
    }
}
