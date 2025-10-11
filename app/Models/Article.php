<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'description',
        'price',
        'vat_rate_id',
        'photo',
        'notes',
        'status',
        'price_with_vat',
    ];


    public function vatRate()
    {
        return $this->belongsTo(VatRate::class);
    }
}
