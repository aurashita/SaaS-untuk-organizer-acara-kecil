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

        $registration = EventRegistration::with('participant')
            ->where('qr_code_hash', $request->qr_code_hash)
            ->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak ditemukan / tidak valid.',
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