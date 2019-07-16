<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            [
                'title' => 'Marrakech: The most beautiful touristic city',
                'content' => 'Easily one of the most beautiful and fascinating cities in Morocco, no trip to Northern Africa is complete without checking out Marrakech. This 1000-year-old city is home to a thriving medina, amazing shopping, and some of the most gorgeous architecture you’ll find anywhere in the world. Marrakech is also famous for its beautiful riads (guesthouses often converted from family homes) and you’ll find amazing little boutique riads dotting winding streets all over the city. Ready to fall in love with Morocco? Here’s the ultimate Marrakech travel guide.',
                'user_id' => 1,
            ],
        ]);
    }
}
