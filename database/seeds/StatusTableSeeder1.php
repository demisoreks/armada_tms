<?php

use Illuminate\Database\Seeder;

use App\AmdStatus;

class StatusTableSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['description' => 'Acknowledged']
        ];
        
        AmdStatus::insert($status);
    }
}
