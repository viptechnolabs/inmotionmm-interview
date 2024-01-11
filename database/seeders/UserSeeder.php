<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $data) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->save();
        }
    }

    private function data(): array
    {
        return [
            [
                'name' => 'Test User 1',
                'email' => 'testuser1@test.com',
                'password' => 'password',
            ],
            [
                'name' => 'Test User 2',
                'email' => 'testuser2@test.com',
                'password' => 'password',
            ],
        ];
    }
}
