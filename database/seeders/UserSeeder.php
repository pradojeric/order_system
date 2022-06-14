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
    }
}
