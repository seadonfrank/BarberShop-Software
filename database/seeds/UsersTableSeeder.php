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
        //
        DB::table('users')->insert([
            'name' => 'admim',
            'email' => 'admin@barbershop',
            'password' => bcrypt('admin@123'),
            'isadmin' => 1,
        ]);
    }
}
