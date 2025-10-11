<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'article_id',
        'supplier_id',
        'quantity',
        'price',
        'cost_price',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Entity::class, 'supplier_id');
    }
}
