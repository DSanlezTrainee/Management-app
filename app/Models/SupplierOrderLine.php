<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierOrderLine extends Model
{
    protected $fillable = [
        'supplier_order_id',
        'article_id',
        'supplier_id',
        'order_line_id',
        'quantity',
        'price',
        'cost_price'
    ];

    public function supplierOrder()
    {
        return $this->belongsTo(SupplierOrder::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Entity::class, 'supplier_id');
    }

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class, 'order_line_id');
    }
}
