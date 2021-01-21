<?php

use App\PassengerCategory;
use Illuminate\Database\Seeder;

class PassengerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PassengerCategory::create([
        	'passenger_category' => 'Regular',
        	'cost_in_percentage'=> 100,
        	'is_active' => true
        ]);

        PassengerCategory::create([
        	'passenger_category' => 'Student',
        	'cost_in_percentage' => 50,
        	'is_active' => true
        ]);

        PassengerCategory::create([
        	'passenger_category' => 'Staff',
        	'cost_in_percentage'=> 60,
        	'is_active' => true
        ]);

        PassengerCategory::create([
        	'passenger_category' => 'Physically Disabled',
        	'cost_in_percentage' => 30,
        	'is_active' => true
        ]);

    }
}
