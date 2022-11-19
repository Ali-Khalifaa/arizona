<?php

use Illuminate\Database\Seeder;

class SpecialtyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Specialty::create([
            'name' => 'medical',
        ]);
    }
}
