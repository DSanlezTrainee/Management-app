<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'number',
        'date',
        'client_id',
        'valid_until',
        'total',
        'status'
    ];

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function client()
    {
        return $this->belongsTo(Entity::class, 'client_id');
    }
}
