<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $item) {
            $employee = Employee::create();

            $this->createUser($employee);
        }

        foreach (range(1, 3) as $item) {
            $admin = Admin::create();

            $this->createUser($admin);
        }
    }

    /**
     * Create a new user based on the given userable model.
     *
     * @param Admin|Employee $userable
     * @return User
     */
    private function createUser($userable)
    {
        $name     = fake('id_ID')->name();
        $username = fake('id_ID')->username();
        $email    = fake('id_ID')->unique()->email();
        $password = 123456;

        $user = new User(compact('name', 'username', 'email', 'password'));
        $user->userable()->associate($userable);
        $user->save();

        return $user;
    }
}
