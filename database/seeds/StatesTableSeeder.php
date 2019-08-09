<?php

use Illuminate\Database\Seeder;

use App\AmdState;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['name' => 'Abia', 'region_id' => 1],
            ['name' => 'Adamawa', 'region_id' => 1],
            ['name' => 'Akwa Ibom', 'region_id' => 1],
            ['name' => 'Anambra', 'region_id' => 1],
            ['name' => 'Bauchi', 'region_id' => 1],
            ['name' => 'Bayelsa', 'region_id' => 1],
            ['name' => 'Benue', 'region_id' => 1],
            ['name' => 'Borno', 'region_id' => 1],
            ['name' => 'Cross River', 'region_id' => 1],
            ['name' => 'Delta', 'region_id' => 1],
            ['name' => 'Ebonyi', 'region_id' => 1],
            ['name' => 'Enugu', 'region_id' => 1],
            ['name' => 'Edo', 'region_id' => 1],
            ['name' => 'Ekiti', 'region_id' => 1],
            ['name' => 'Gombe', 'region_id' => 1],
            ['name' => 'Imo', 'region_id' => 1],
            ['name' => 'Jigawa', 'region_id' => 1],
            ['name' => 'Kaduna', 'region_id' => 1],
            ['name' => 'Kano', 'region_id' => 1],
            ['name' => 'Katsina', 'region_id' => 1],
            ['name' => 'Kebbi', 'region_id' => 1],
            ['name' => 'Kogi', 'region_id' => 1],
            ['name' => 'Kwara', 'region_id' => 1],
            ['name' => 'Lagos', 'region_id' => 1],
            ['name' => 'Nasarawa', 'region_id' => 1],
            ['name' => 'Niger', 'region_id' => 1],
            ['name' => 'Ogun', 'region_id' => 1],
            ['name' => 'Ondo', 'region_id' => 1],
            ['name' => 'Osun', 'region_id' => 1],
            ['name' => 'Oyo', 'region_id' => 1],
            ['name' => 'Plateau', 'region_id' => 1],
            ['name' => 'Rivers', 'region_id' => 1],
            ['name' => 'Sokoto', 'region_id' => 1],
            ['name' => 'Taraba', 'region_id' => 1],
            ['name' => 'Yobe', 'region_id' => 1],
            ['name' => 'Zamfara', 'region_id' => 1],
            ['name' => 'FCT', 'region_id' => 1]
        ];
        
        AmdState::insert($states);
    }
}
