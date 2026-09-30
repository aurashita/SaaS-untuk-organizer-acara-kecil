<?php

namespace App\Http\Controllers;

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
        auth()->user()->events()->create($this->validatedData($request));

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function show(string $id)
    {
        $event = auth()->user()->events()->with('registrations.participant')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = auth()->user()->events()->findOrFail($id);
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

        $event->update($data);

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
        return $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quota' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);
    }
}