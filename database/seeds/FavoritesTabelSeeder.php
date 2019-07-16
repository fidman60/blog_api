<?php

use Illuminate\Database\Seeder;

class FavoritesTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->insert([
            [
                'user_id' => 1,
                'post_id' => 1,
            ],
        ]);
    }
}
