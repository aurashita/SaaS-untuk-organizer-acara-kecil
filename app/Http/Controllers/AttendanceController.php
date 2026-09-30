<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code_hash' => 'required|string',
        ]);

        // Hanya tiket dari acara milik organizer yang sedang login
        $registration = EventRegistration::with('participant')
            ->where('qr_code_hash', $request->qr_code_hash)
            ->whereHas('event', fn ($q) => $q->where('organizer_id', auth()->id()))
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak ditemukan atau bukan tiket untuk acara Anda.',
            ], 404);
        }

        if ($registration->attendance_status === 'hadir') {
            return response()->json([
                'success' => false,
                'message' => 'Peserta ini sudah check-in sebelumnya (' . $registration->participant->name . ').',
            ], 409);
        }

        $registration->update(['attendance_status' => 'hadir']);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'participant_name' => $registration->participant->name,
        ]);
    }
}