<?php

use App\Models\Organizer;

function dataEventValid(array $override = []): array
{
    return array_merge([
        'name' => 'Workshop Test',
        'date' => '2026-12-01T09:00',
        'location' => 'Aula Utama',
        'description' => 'Deskripsi test',
        'quota' => 20,
        'price' => 0,
    ], $override);
}

test('organizer dapat membuat event', function () {
    $organizer = Organizer::factory()->create();

    $this->actingAs($organizer)
        ->post(route('events.store'), dataEventValid())
        ->assertRedirect(route('events.index'));

    $this->assertDatabaseHas('events', [
        'name' => 'Workshop Test',
        'organizer_id' => $organizer->id,
    ]);
});

test('pembuatan event gagal jika nama kosong', function () {
    $organizer = Organizer::factory()->create();

    $this->actingAs($organizer)
        ->post(route('events.store'), dataEventValid(['name' => '']))
        ->assertSessionHasErrors('name');
});

test('organizer dapat mengubah event', function () {
    $organizer = Organizer::factory()->create();
    $event = $organizer->events()->create(dataEventValid());

    $this->actingAs($organizer)
        ->put(route('events.update', $event), dataEventValid(['name' => 'Nama Baru']))
        ->assertRedirect(route('events.show', $event));

    $this->assertDatabaseHas('events', ['id' => $event->id, 'name' => 'Nama Baru']);
});

test('organizer dapat menghapus event', function () {
    $organizer = Organizer::factory()->create();
    $event = $organizer->events()->create(dataEventValid());

    $this->actingAs($organizer)
        ->delete(route('events.destroy', $event))
        ->assertRedirect(route('events.index'));

    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});

test('organizer tidak bisa mengedit event milik organizer lain', function () {
    $pemilik = Organizer::factory()->create();
    $event = $pemilik->events()->create(dataEventValid());
    $orangLain = Organizer::factory()->create();

    $this->actingAs($orangLain)
        ->get(route('events.edit', $event))
        ->assertNotFound();
});