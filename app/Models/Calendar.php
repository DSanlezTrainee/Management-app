<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'date',
        'time',
        'duration',
        'share',
        'awareness',
        'entity_id',
        'type_id',
        'action_id',
        'description',
        'status',
        'user_id'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function type()
    {
        return $this->belongsTo(CalendarType::class, 'type_id');
    }
    public function action()
    {
        return $this->belongsTo(CalendarAction::class, 'action_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
