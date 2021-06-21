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
        /*ID 1*/   ['name' => "Donor",'email' => 'donor@donor.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'AB', 'password' => Hash::make('donor'),'zone_id'=> 1],
        /*ID 2*/   ['name' => "Admin",'email' => 'admin@mwananyamala.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('admin'),'zone_id'=>1],
        /*ID 3*/   ['name' => "Admin",'email' => 'admin@kariakoo.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'AB', 'password' => Hash::make('admin'),'zone_id'=>2],
        /*ID 4*/   ['name' => "Admin",'email' => 'admin@ubungo.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'B', 'password' => Hash::make('admin'),'zone_id'=>3],
        /*ID 5*/   ['name' => "Admin",'email' => 'admin@ilala.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'A', 'password' => Hash::make('admin'),'zone_id'=>4],
        /*ID 6*/   ['name' => "Doctor",'email' => 'doctor@mwananyamala.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'B', 'password' => Hash::make('doctor'),'zone_id'=>1],
        /*ID 7*/   ['name' => "Doctor",'email' => 'doctor@kariakoo.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'A', 'password' => Hash::make('doctor'),'zone_id'=>2],
        /*ID 8*/   ['name' => "Doctor",'email' => 'doctor@ubungo.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'O', 'password' => Hash::make('doctor'),'zone_id'=>3],
        /*ID 9*/   ['name' => "Doctor",'email' => 'doctor@ilala.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'AB', 'password' => Hash::make('doctor'),'zone_id'=>4],
        /*ID 10*/  ['name' => "Customer",'email' => 'customer@customer.com', 'age' => '29', 'gender' => 'Male', 'blood_group' => 'A', 'password' => Hash::make('customer'),'zone_id'=> 2]
        ]);
    }
}
