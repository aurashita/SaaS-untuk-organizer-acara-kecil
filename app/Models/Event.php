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
        'is_private',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function invitations()
    {
        return $this->hasMany(EventInvitation::class);
    }

    public function isEmailInvited(string $email): bool
    {
        return $this->invitations()
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->exists();
    }

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'is_private' => 'boolean',
        ];
    }
}