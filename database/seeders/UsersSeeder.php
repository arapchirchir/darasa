<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Teacher',
                'email' => 'teacher@darasa.com',
                'password' => Hash::make('teacherpassword'),
                'user_type' => 'teacher',
            ],
            [
                'name' => 'Student',
                'email' => 'student@darasa.com',
                'password' => Hash::make('studentpassword'),
                'user_type' => 'student',
            ]
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'user_type' => $user['user_type'],
            ]);
        }
    }
}
