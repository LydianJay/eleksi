<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ElectricityData;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) {

            $voltage    = $this->randomFloat(230, 250);
            $amps       = $this->randomFloat(0.1, 10);
            $power      = $voltage * $amps;
            $energy     = $power * 0.5;


            ElectricityData::create([
                'voltage'   => $voltage,
                'current'   => $amps,
                'power'     => $power,
                'energy'    => $energy,
            ]);
        
        }
        
        
    }


    private function randomFloat($min, $max)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
