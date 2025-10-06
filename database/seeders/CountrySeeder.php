<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $countries = [
            ['name' => 'Portugal', 'code' => 'PT'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Argentina', 'code' => 'AR'],
            ['name' => 'Mexico', 'code' => 'MX'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'China', 'code' => 'CN'],
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'South Africa', 'code' => 'ZA'],
            ['name' => 'Russia', 'code' => 'RU'],
            ['name' => 'Switzerland', 'code' => 'CH'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Netherlands', 'code' => 'NL'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(['code' => $country['code']], $country);
        }
    }
}
