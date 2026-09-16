<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationController extends Controller
{
    public function show(Event $event)
    {
        return view('registration.form', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $participant = Participant::create($validated);

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'qr_code_hash' => Str::uuid(),
            'registration_date' => now(),
            'attendance_status' => 'belum_hadir',
        ]);

        $qrCode = QrCode::size(250)->generate($registration->qr_code_hash);

        return view('registration.success', compact('registration', 'qrCode'));
    }
}