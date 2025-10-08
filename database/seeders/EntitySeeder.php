<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            [
                'type' => 'client',
                'number' => 1,
                'nif' => '123456789',
                'name' => 'Empresa Alpha',
                'country_id' => 1,
                'email' => 'alpha@example.com',
                'address' => 'Rua Principal 1',
                'city' => 'Lisboa',
                'phone' => '211234567',
                'mobile' => '911234567',
                'website' => 'https://empresa-alpha.pt',
                'rgpd_consent' => true,
                'notes' => 'Cliente importante.',
                'postal_code' => '1000-001',
                'status' => 'active',
            ],
            [
                'type' => 'supplier',
                'number' => 2,
                'nif' => '234567891',
                'name' => 'Fornecedor Beta',
                'country_id' => 2,
                'email' => 'beta@fornecedor.com',
                'address' => 'Avenida Central 99',
                'city' => 'Madrid',
                'phone' => '341234567',
                'mobile' => '921234567',
                'website' => 'https://fornecedor-beta.es',
                'rgpd_consent' => false,
                'notes' => 'Fornecedor internacional.',
                'postal_code' => '2800-002',
                'status' => 'inactive',
            ],
        ];
        foreach ($entities as $entity) {
            Entity::firstOrCreate([
                'number' => $entity['number'],
                'nif' => $entity['nif']
            ], $entity);
        }
    }
}
