<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationController extends Controller
{
    public function show(Event $event)
    {
        $sisaKuota = max($event->quota - $event->registrations()->count(), 0);

        return view('registration.form', compact('event', 'sisaKuota'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        // 1. Cek kuota
        if ($event->registrations()->count() >= $event->quota) {
            return back()->withInput()->withErrors([
                'quota' => 'Maaf, kuota pendaftaran untuk acara ini sudah penuh.',
            ]);
        }

// Cek apakah acara privat, dan apakah email termasuk yang diundang
if ($event->is_private && !$event->isEmailInvited($validated['email'])) {
    return back()->withInput()->withErrors([
        'email' => 'Maaf, acara ini bersifat privat dan email kamu tidak terdaftar dalam daftar undangan.',
    ]);
}

        // 2. Pakai peserta lama kalau emailnya sudah ada (tidak bikin data ganda)
        $participant = Participant::firstOrCreate(
            ['email' => Str::lower($validated['email'])],
            ['name' => $validated['name'], 'phone' => $validated['phone']]
        );

        // 3. Cek apakah email ini sudah terdaftar di acara yang sama
        $sudahTerdaftar = EventRegistration::where('event_id', $event->id)
            ->where('participant_id', $participant->id)
            ->exists();

        if ($sudahTerdaftar) {
            return back()->withInput()->withErrors([
                'email' => 'Email ini sudah terdaftar pada acara ini.',
            ]);
        }

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'qr_code_hash' => (string) Str::uuid(),
            'registration_date' => now(),
            'attendance_status' => 'belum_hadir',
        ]);

        return redirect()->route('registration.success', $registration->qr_code_hash);
    }

    public function success(EventRegistration $registration)
    {
        $registration->load('event', 'participant');
        $qrCode = QrCode::size(250)->generate($registration->qr_code_hash);

        return view('registration.success', compact('registration', 'qrCode'));
    }
}