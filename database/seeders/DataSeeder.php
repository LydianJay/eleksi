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

            ElectricityData::create([
                'voltage' => 'admin',
                'current' => 'admin123',
                'power' => 'admin123',
                'energy' => 'admin123',
            ]);
        
        }
        
        
    }
}
