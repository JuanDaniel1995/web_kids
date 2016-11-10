<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => 'Juan',
          'email' => 'juandanielvc19@gmail.com',
          'password' => bcrypt('123456'),
          'role' => 'C'
        ]);
    }
}
