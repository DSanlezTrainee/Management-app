<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\VatRate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $vat = VatRate::first();

        $articles = [
            [
                'reference' => 'ART001',
                'name' => 'Laptop Dell XPS 13',
                'description' => 'High-performance laptop with a stunning display.',
                'price' => 999.99,
                'vat_rate_id' => $vat ? $vat->id : 1,
                'photo' => 'laptop_dell_xps_13.jpg',
                'notes' => 'Top seller in the electronics category.',
                'status' => 'inactive',
            ],
            [
                'reference' => 'ART002',
                'name' => 'Apple iPhone 14',
                'description' => 'Latest model of the iPhone with advanced features.',
                'price' => 799.99,
                'vat_rate_id' => $vat ? $vat->id : 1,
                'photo' => 'apple_iphone_14.jpg',
                'notes' => 'Available in multiple colors.',
                'status' => 'active',
            ],
            [
                'reference' => 'ART003',
                'name' => 'Samsung Galaxy S22',
                'description' => 'Flagship smartphone with cutting-edge technology.',
                'price' => 749.99,
                'vat_rate_id' => $vat ? $vat->id : 1,
                'photo' => 'samsung_galaxy_s22.jpg',
                'notes' => '',
                'status' => 'inactive',
            ],
            [
                'reference' => 'ART004',
                'name' => 'Sony WH-1000XM4 Headphones',
                'description' => 'Industry-leading noise-canceling headphones.',
                'price' => 349.99,
                'vat_rate_id' => $vat ? $vat->id : 1,
                'photo' => 'sony_wh_1000xm4.jpg',
                'notes' => '',
                'status' => 'active',
            ],
            [
                'reference' => 'ART005',
                'name' => 'Apple MacBook Pro 16"',
                'description' => "Powerful laptop designed for professionals.",
                'price' => 2399.99,
                'vat_rate_id' => $vat ? $vat->id : 1,
                'photo' => 'apple_macbook_pro_16.jpg',
                'notes' => '',
                'status' => 'active',
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}
