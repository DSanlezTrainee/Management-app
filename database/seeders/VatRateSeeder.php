<?php

namespace Database\Seeders;

use App\Models\VatRate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            ['name' => 'Standard Rate', 'rate' => 23.00, 'active' => true],
            ['name' => 'Zero Intermediary', 'rate' => 13.00, 'active' => true],
            ['name' => 'Reduced Rate', 'rate' => 6.00, 'active' => true],
            ['name' => 'Exempt', 'rate' => 0.00, 'active' => true],
        ];

        foreach ($rates as $rate) {
            VatRate::create($rate);
        }
    }
}
