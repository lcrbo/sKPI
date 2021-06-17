<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Admin',
            'email' => 'admin@smu.cl',
            'password' => bcrypt('12345678')
        ])->assignRole('Admin');

        User::create([
            'name' => 'Leonardo Cruz',
            'email' => 'leo.crbo@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('PorFormatos');
    }
}
