<?php

use Illuminate\Database\Seeder;

class ReactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reactions')->insert([
            [
                'reaction' => 1,
                'user_id' => 1,
                'comment_id' => 1,
            ],
        ]);
    }
}
