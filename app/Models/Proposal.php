<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'client_id',
        'valid_until',
        'total',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Entity::class, 'client_id');
    }

    public function lines()
    {
        return $this->hasMany(ProposalLine::class);
    }
}
