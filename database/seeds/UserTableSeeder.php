<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'sahib@gmail.com')->first();

        if (!$user) {
          User::create([
            'role' => 'admin',
            'name' => 'Sahib Singh',
            'email' => 'sahib@gmail.com',
            'password' => Hash::make('12345678')
          ]);
        }
    }
}
