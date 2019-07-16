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
            [
                'fname' => 'Mohammed Ayman',
                'lname' => 'Moufid',
                'city' => 'Kelaa Sraghna',
                'age' => 21,
                'email' => 'benghazimofid@gmail.com',
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
            [
                'fname' => 'Amine',
                'lname' => 'Fatiss',
                'city' => 'Marrakech',
                'age' => 30,
                'email' => 'fidman@gmail.com',
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 2,
            ],
        ]);
    }
}
