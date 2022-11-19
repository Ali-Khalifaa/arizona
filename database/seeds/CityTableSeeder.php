<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\City::create([
            'name'=>'Akhmim'
        ]);

        \App\Models\City::create([
            'name'=>'jerja'
        ]);

        \App\Models\City::create([
            'name'=>'Sohag'
        ]);

        \App\Models\City::create([
            'name'=>'thyme'
        ]);
    }
}
