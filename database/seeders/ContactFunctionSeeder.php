<?php

namespace Database\Seeders;

use App\Models\ContactFunction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functions = [
            'General Director',
            'Commercial Director',
            'Technician',
            'Administrative',
            'Financial',
            'Purchasing',
            'Human Resources',
        ];

        foreach ($functions as $function) {
            ContactFunction::firstOrCreate(['name' => $function]);
        }
    }
}
