<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'comment' => 'Woow ! i wish i visit this wonderful city as soon as possible',
                'evaluation' => 4.5,
                'user_id' => 1,
                'post_id' => 1,
            ],
        ]);
    }
}
