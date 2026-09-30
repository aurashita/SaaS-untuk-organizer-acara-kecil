<?php

use App\Models\EventRegistration;
use App\Models\Organizer;
use App\Models\Participant;

function buatTiketUntukScan(Organizer $organizer): EventRegistration
{
    $event = $organizer->events()->create([
        'name' => 'Event Test',
        'date' => now()->addDay(),
        'location' => 'Lokasi Test',
        'quota' => 10,
        'price' => 0,
    ]);

    $participant = Participant::create([
        'name' => 'Peserta Test',
        'email' => 'peserta@example.com',
        'phone' => '081234567890',
    ]);

    return EventRegistration::create([
        'event_id' => $event->id,
        'participant_id' => $participant->id,
        'qr_code_hash' => 'hash-test-123',
        'registration_date' => now(),
        'attendance_status' => 'belum_hadir',
    ]);
}

test('scan tiket valid mengubah status menjadi hadir', function () {
    $organizer = Organizer::factory()->create();
    $registration = buatTiketUntukScan($organizer);

    $this->actingAs($organizer)
        ->postJson(route('attendance.scan'), ['qr_code_hash' => 'hash-test-123'])
        ->assertOk()
        ->assertJson(['success' => true]);

    expect($registration->fresh()->attendance_status)->toBe('hadir');
});

test('scan tiket yang sama dua kali ditolak', function () {
    $organizer = Organizer::factory()->create();
    buatTiketUntukScan($organizer);

    $this->actingAs($organizer)->postJson(route('attendance.scan'), ['qr_code_hash' => 'hash-test-123']);

    $this->actingAs($organizer)
        ->postJson(route('attendance.scan'), ['qr_code_hash' => 'hash-test-123'])
        ->assertStatus(409)
        ->assertJson(['success' => false]);
});

test('scan qr yang tidak dikenal ditolak', function () {
    $organizer = Organizer::factory()->create();

    $this->actingAs($organizer)
        ->postJson(route('attendance.scan'), ['qr_code_hash' => 'tidak-ada'])
        ->assertStatus(404);
});

test('organizer tidak bisa scan tiket milik organizer lain', function () {
    $pemilik = Organizer::factory()->create();
    $registration = buatTiketUntukScan($pemilik);
    $orangLain = Organizer::factory()->create();

    $this->actingAs($orangLain)
        ->postJson(route('attendance.scan'), ['qr_code_hash' => 'hash-test-123'])
        ->assertStatus(404);

    expect($registration->fresh()->attendance_status)->toBe('belum_hadir');
});