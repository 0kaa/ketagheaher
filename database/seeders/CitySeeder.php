<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name_ar' => 'الرياض',
            'name_en' => 'Riyadh',
            
        ]);
    }
}
