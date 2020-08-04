<?php

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
        \App\User::create([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt('password')
        ]);
    }
}
