<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = [
        'type',
        'number',
        'nif',
        'name',
        'address',
        'postal_code',
        'city',
        'country_id',
        'phone',
        'mobile',
        'website',
        'email',
        'rgpd_consent',
        'notes',
        'status'
    ];

    protected $casts = [
        'nif' => 'encrypted',
        'name' => 'encrypted',
        'address' => 'encrypted',
        'postal_code' => 'encrypted',
        'city' => 'encrypted',
        'phone' => 'encrypted',
        'mobile' => 'encrypted',
        'website' => 'encrypted',
        'email' => 'encrypted',
        'notes' => 'encrypted',
        'rgpd_consent' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Check if a NIF already exists in the database
     * 
     * @param string $nif
     * @param int|null $excludeId ID to exclude from check (useful for updates)
     * @return bool
     */
    public static function nifExists($nif, $excludeId = null)
    {

        $entities = self::all();

        foreach ($entities as $entity) {
            if ($excludeId && $entity->id == $excludeId) {
                continue; 
            }

            if ($entity->nif == $nif) {
                return true; 
            }
        }

        return false; 
    }
}
