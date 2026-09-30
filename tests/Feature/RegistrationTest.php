<?php

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Organizer;

function buatEventUntukRegistrasi(int $quota = 5): Event
{
    $organizer = Organizer::factory()->create();

    return $organizer->events()->create([
        'name' => 'Event Registrasi Test',
        'date' => now()->addDays(3),
        'location' => 'Lokasi Test',
        'quota' => $quota,
        'price' => 0,
    ]);
}

function dataPeserta(array $override = []): array
{
    return array_merge([
        'name' => 'Andi Pratama',
        'email' => 'andi@example.com',
        'phone' => '081234567890',
    ], $override);
}

test('halaman pendaftaran publik menampilkan nama event', function () {
    $event = buatEventUntukRegistrasi();

    $this->get(route('registration.show', $event))
        ->assertOk()
        ->assertSee('Event Registrasi Test');
});

test('peserta dapat mendaftar dan mendapat tiket', function () {
    $event = buatEventUntukRegistrasi();

    $this->post(route('registration.store', $event), dataPeserta());

    $registration = EventRegistration::first();

    expect($registration)->not->toBeNull();
    expect($registration->attendance_status)->toBe('belum_hadir');
    $this->assertDatabaseHas('participants', ['email' => 'andi@example.com']);
});

test('email yang sama tidak bisa mendaftar dua kali di acara yang sama', function () {
    $event = buatEventUntukRegistrasi();

    $this->post(route('registration.store', $event), dataPeserta());

    $this->post(route('registration.store', $event), dataPeserta())
        ->assertSessionHasErrors('email');

    expect(EventRegistration::count())->toBe(1);
});

test('pendaftaran ditolak jika kuota sudah penuh', function () {
    $event = buatEventUntukRegistrasi(quota: 1);

    $this->post(route('registration.store', $event), dataPeserta());

    $this->post(route('registration.store', $event), dataPeserta([
        'name' => 'Budi',
        'email' => 'budi@example.com',
    ]))->assertSessionHasErrors('quota');

    expect(EventRegistration::count())->toBe(1);
});