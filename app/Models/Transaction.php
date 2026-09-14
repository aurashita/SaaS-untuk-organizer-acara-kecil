<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'event_registration_id',
        'transaction_id',
        'gross_amount',
        'payment_status',
    ];

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }
}