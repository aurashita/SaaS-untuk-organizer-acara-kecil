<?php

namespace App\Http\Controllers;

use App\Models\EventInvitation;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = auth()->user()->events()->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $emails = $this->parseEmails($request->input('invited_emails'));

        $event = auth()->user()->events()->create($data);
        $this->simpanUndangan($event, $emails);

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function show(string $id)
    {
        $event = auth()->user()->events()->with('registrations.participant', 'invitations')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = auth()->user()->events()->with('invitations')->findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $id)
    {
        $event = auth()->user()->events()->findOrFail($id);
        $data = $this->validatedData($request);

        $jumlahPendaftar = $event->registrations()->count();
        if ($data['quota'] < $jumlahPendaftar) {
            return back()->withInput()->withErrors([
                'quota' => "Kuota tidak boleh kurang dari jumlah pendaftar saat ini ($jumlahPendaftar).",
            ]);
        }

        $emails = $this->parseEmails($request->input('invited_emails'));

        $event->update($data);
        $this->simpanUndangan($event, $emails);

        return redirect()->route('events.show', $event)->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $event = auth()->user()->events()->findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quota' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_private' => 'nullable|boolean',
        ]);

        $data['is_private'] = $request->boolean('is_private');

        return $data;
    }

    private function parseEmails(?string $teks): array
    {
        if (!$teks) {
            return [];
        }

        return collect(preg_split('/[\r\n,]+/', $teks))
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    private function simpanUndangan($event, array $emails): void
    {
        $event->invitations()->delete();

        foreach ($emails as $email) {
            EventInvitation::create([
                'event_id' => $event->id,
                'email' => $email,
            ]);
        }
    }
}