<?php

namespace Database\Seeders;

use App\Models\EventRegistration;
use App\Models\Organizer;
use App\Models\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun demo: demo@example.com / password
        $organizer = Organizer::factory()->create([
            'name' => 'Organizer Demo',
            'email' => 'demo@example.com',
        ]);

        $workshop = $organizer->events()->create([
            'name' => 'Workshop Laravel untuk Pemula',
            'date' => now()->addDays(7)->setTime(9, 0),
            'location' => 'Aula Kampus A',
            'description' => 'Workshop dasar membuat aplikasi web dengan Laravel.',
            'quota' => 30,
            'price' => 0,
        ]);

        $seminar = $organizer->events()->create([
            'name' => 'Seminar Teknologi 2026',
            'date' => now()->addDays(14)->setTime(13, 0),
            'location' => 'Gedung Serbaguna',
            'description' => 'Seminar tentang tren teknologi terbaru.',
            'quota' => 100,
            'price' => 50000,
        ]);

        $daftarPeserta = [
            ['Andi Pratama', 'hadir'],
            ['Budi Santoso', 'hadir'],
            ['Citra Lestari', 'belum_hadir'],
            ['Dewi Anggraini', 'belum_hadir'],
            ['Eko Wijaya', 'belum_hadir'],
            ['Fitri Handayani', 'belum_hadir'],
        ];

        foreach ($daftarPeserta as $index => [$nama, $status]) {
            $participant = Participant::create([
                'name' => $nama,
                'email' => Str::slug($nama, '.') . '@example.com',
                'phone' => '0812345600' . $index,
            ]);

            EventRegistration::create([
                'event_id' => $workshop->id,
                'participant_id' => $participant->id,
                'qr_code_hash' => (string) Str::uuid(),
                'registration_date' => now(),
                'attendance_status' => $status,
            ]);

            // 3 peserta pertama juga mendaftar ke seminar
            if ($index < 3) {
                EventRegistration::create([
                    'event_id' => $seminar->id,
                    'participant_id' => $participant->id,
                    'qr_code_hash' => (string) Str::uuid(),
                    'registration_date' => now(),
                    'attendance_status' => 'belum_hadir',
                ]);
            }
        }
    }
}