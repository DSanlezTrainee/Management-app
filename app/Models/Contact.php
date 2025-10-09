<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'number',
        'entity_id',
        'first_name',
        'last_name',
        'contact_function_id',
        'email',
        'phone',
        'mobile',
        'rgpd_consent',
        'notes',
        'status'
    ];

    protected $casts = [
        'first_name' => 'encrypted',
        'last_name' => 'encrypted',
        'email' => 'encrypted',
        'phone' => 'encrypted',
        'mobile' => 'encrypted',
        'notes' => 'encrypted',
        'rgpd_consent' => 'boolean',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function contactFunction()
    {
        return $this->belongsTo(ContactFunction::class, 'contact_function_id');
    }
}
