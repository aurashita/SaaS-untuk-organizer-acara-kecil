<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'participant_id',
        'qr_code_hash',
        'registration_date',
        'attendance_status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}