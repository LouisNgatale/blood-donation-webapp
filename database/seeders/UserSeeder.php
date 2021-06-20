<?php

namespace Database\Seeders;

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
            ['name' => "Donor",'email' => 'donor@donor.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('donor')],
            ['name' => "Admin",'email' => 'admin@admin.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('admin')],
            ['name' => "Doctor",'email' => 'doctor@doctor.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('doctor')],
            ['name' => "Customer",'email' => 'customer@customer.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('customer')]
        ]);
    }
}
