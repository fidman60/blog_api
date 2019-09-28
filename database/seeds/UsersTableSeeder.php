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
                'email' => 'benghazimofid@gmail.com',
                'gender' => true,
                'birth_date' => "1998-03-02",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
            [
                'fname' => 'Amine',
                'lname' => 'Fatiss',
                'email' => 'amine_fatiss32@gmail.com',
                'gender' => true,
                'birth_date' => "1993-12-22",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 2,
            ],
            [
                'fname' => 'Alexia',
                'lname' => 'Ferrir',
                'email' => 'alexia_ferrir@gmail.com',
                'gender' => false,
                'birth_date' => "2000-12-03",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 3,
            ],
            [
                'fname' => 'Amal',
                'lname' => 'Omi',
                'email' => 'amal_omi@gmail.com',
                'gender' => false,
                'birth_date' => "2001-05-03",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
            [
                'fname' => 'Wiam',
                'lname' => 'Rachidi',
                'email' => 'wiamita43@gmail.com',
                'gender' => false,
                'birth_date' => "2005-11-03",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
            [
                'fname' => 'Saad',
                'lname' => 'Habs',
                'email' => 'saad_saad22@gmail.com',
                'gender' => false,
                'birth_date' => "2001-11-03",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
            [
                'fname' => 'Nourding',
                'lname' => 'Ktama',
                'email' => 'nourdine_ktama21@gmail.com',
                'gender' => false,
                'birth_date' => "1998-11-03",
                'password' => bcrypt('fiDMan1235'),
                'country_id' => 1,
            ],
        ]);
    }
}
