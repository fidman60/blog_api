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
                'evaluation' => 4,
                'user_id' => 1,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => 'I love such your article',
                'evaluation' => 5,
                'user_id' => 2,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => 'I love such your article love such your article love such your article love such your article',
                'evaluation' => 5,
                'user_id' => 3,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => 'Yeah, that\'s a wonderful place, next year i\'will visit it, i\'m so exciting ! haha',
                'evaluation' => 4,
                'user_id' => 4,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => "I feel a strange feeling when i see this places, brief, i don't like it",
                'evaluation' => 2,
                'user_id' => 5,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => "I feel a strange feeling when i see this places, brief, i don't like it",
                'evaluation' => 2,
                'user_id' => 6,
                'post_id' => 1,
            ],
        ]);

        DB::table('comments')->insert([
            [
                'comment' => "I feel a strange feeling when i see this places, brief, i don't like it",
                'evaluation' => 3,
                'user_id' => 7,
                'post_id' => 1,
            ],
        ]);
    }
}
