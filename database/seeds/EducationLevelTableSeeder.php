<?php

use Illuminate\Database\Seeder;

class EducationLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EducationLevel::create([
           'name'=>'primary school student'
        ]);

        \App\Models\EducationLevel::create([
           'name'=>'middle school student'
        ]);

        \App\Models\EducationLevel::create([
           'name'=>'high school student'
        ]);
    }
}
