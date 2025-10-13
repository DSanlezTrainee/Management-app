<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default company record if none exists
        if (Company::count() === 0) {
            Company::create([
                'name' => 'My Company',
                'address' => '',
                'postal_code' => '',
                'city' => '',
                'nif' => '',
            ]);
        }
    }
}
