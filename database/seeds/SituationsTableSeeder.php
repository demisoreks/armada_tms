<?php

use Illuminate\Database\Seeder;

use App\AmdSituation;

class SituationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situations = [
            ['description' => 'Traffic'],
            ['description' => 'Road Construction'],
            ['description' => 'Blockage'],
            ['description' => 'Armed Robbery'],
            ['description' => 'Insecure Environs'],
            ['description' => 'Political Rally'],
            ['description' => 'Riot'],
            ['description' => 'Others']
        ];
        
        AmdSituation::insert($situations);
    }
}
