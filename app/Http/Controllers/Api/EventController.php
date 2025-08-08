<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();

        if ($request->wantsJson()) {
            return response()->json($events);
        }

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/Create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'is_paid' => 'boolean',
            'eo' => 'required|string|max:255',
            'ticket_link' => 'nullable|url',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('uploads', 'public');
            $validatedData['poster'] = '/storage/' . $path;
        }

        Event::create($validatedData);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'is_paid' => 'boolean',
            'eo' => 'required|string|max:255',
            'ticket_link' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($event->poster && Storage::disk('public')->exists(str_replace('/storage/', '', $event->poster))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $event->poster));
            }
            $path = $request->file('poster')->store('uploads', 'public');
            $validatedData['poster'] = '/storage/' . $path;
        } else {
            // Jika tidak ada poster baru diupload, pertahankan poster yang sudah ada
            $validatedData['poster'] = $event->poster; 
        }

        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Hapus poster saat event dihapus
        if ($event->poster && Storage::disk('public')->exists(str_replace('/storage/', '', $event->poster))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $event->poster));
        }
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
