<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['label' => 'Morocco'],
            ['label' => 'Spain'],
            ['label' => 'French'],
            ['label' => 'United State'],
            ['label' => 'Algeria'],
            ['label' => 'Egypte'],
        ]);
    }
}
