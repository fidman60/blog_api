<?php

use Illuminate\Database\Seeder;

class ResponsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('responses')->insert([
            [
                'response' => 'Yeah that\'s true !',
                'user_id' => 1,
                'comment_id' => 1,
            ],
        ]);
    }
}
