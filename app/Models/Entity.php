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
}
