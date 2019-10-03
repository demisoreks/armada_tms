<?php

use Illuminate\Database\Seeder;

use App\AmdStatus;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['description' => 'Initiated'],
            ['description' => 'Submitted'],
            ['description' => 'Returned'],
            ['description' => 'Assigned'],
            ['description' => 'Started'],
            ['description' => 'Completed'],
            ['description' => 'Cancelled']
        ];
        
        AmdStatus::insert($status);
    }
}
