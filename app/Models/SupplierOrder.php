<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    protected $fillable = [
        'number',
        'date',
        'supplier_id',
        'order_id',
        'valid_until',
        'total',
        'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Entity::class, 'supplier_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function lines()
    {
        return $this->hasMany(SupplierOrderLine::class);
    }
}
