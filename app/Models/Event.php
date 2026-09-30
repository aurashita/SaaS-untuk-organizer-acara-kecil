<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id',
        'name',
        'date',
        'location',
        'description',
        'quota',
        'price',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}