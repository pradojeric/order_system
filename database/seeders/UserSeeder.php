<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        //
        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'operation',
            ],
            [
                'name' => 'waiter',
            ],
        ];

        Role::insert($roles);

        User::create([
            'employee_no' => '0000-0001',
            'first_name' => 'John',
            'middle_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 1,
        ]);

        User::create([
            'employee_no' => '0000-0002',
            'first_name' => 'Jay',
            'middle_name' => '',
            'last_name' => 'Sicat',
            'email' => 'jaysicat@gmail.com',
            'password' => Hash::make('password'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 2,
        ]);

        $waiter = User::create([
            'employee_no' => '0000-0003',
            'first_name' => 'Carmela',
            'middle_name' => '',
            'last_name' => 'Sinoro',
            'email' => 'carmelasinoro@gmail.com',
            'password' => Hash::make('password'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 3,
        ]);

        $waiter2 = User::create([
            'employee_no' => '0000-0004',
            'first_name' => 'Rhica',
            'middle_name' => '',
            'last_name' => 'Mackay',
            'email' => 'rhicamackay@gmail.com',
            'password' => Hash::make('password'),
            'passcode' => mt_rand(100000, 999999),
            'role_id' => 3,
        ]);

        $waiter->assignTables()->sync([1,2,3]);
        $waiter2->assignTables()->sync([3,4,5]);
    }
}
