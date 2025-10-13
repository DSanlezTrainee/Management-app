<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Calendar;
use App\Models\Entity;
use App\Models\User;
use App\Models\CalendarType;
use App\Models\CalendarAction;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Calendar::with(['type', 'action', 'entity', 'user'])->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'date' => $event->date,
                'time' => $event->time,
                'duration' => $event->duration,
                'share' => $event->share,
                'awareness' => $event->awareness,
                'entity_id' => $event->entity_id,
                'entity' => $event->entity ? $event->entity->name : null,
                'type_id' => $event->type_id,
                'type' => $event->type ? $event->type->name : null,
                'type_color' => $event->type ? $event->type->color : null,
                'action_id' => $event->action_id,
                'action' => $event->action ? $event->action->name : null,
                'description' => $event->description,
                'status' => $event->status,
                'user_id' => $event->user_id,
                'user' => $event->user ? $event->user->name : null,

                'title' => $event->description ?? ($event->type->name ?? 'Event'),
                'start' => $event->date . 'T' . $event->time,
                'end' => $event->date . 'T' . ($event->time ? date('H:i:s', strtotime($event->time) + ($event->duration ?? 0) * 60) : null),
                'color' => $event->type->color ?? null,
            ];
        });
        return Inertia::render('Calendar/Index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Calendar/Create', [
            'entities' => Entity::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'types' => CalendarType::select('id', 'name', 'color')->orderBy('name')->get(),
            'actions' => CalendarAction::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'nullable|integer',
            'share' => 'nullable|string',
            'awareness' => 'nullable|string',
            'entity_id' => 'nullable|exists:entities,id',
            'type_id' => 'nullable|exists:calendar_types,id',
            'action_id' => 'nullable|exists:calendar_actions,id',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
        $event = Calendar::create($data);
        return redirect()->route('calendar.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Calendar::with(['type', 'action', 'entity', 'user'])->findOrFail($id);
        return Inertia::render('Calendar/Show', [
            'event' => [
                'id' => $event->id,
                'date' => $event->date,
                'time' => $event->time,
                'duration' => $event->duration,
                'share' => $event->share,
                'awareness' => $event->awareness,
                'entity' => $event->entity ? $event->entity->name : null,
                'type' => $event->type ? $event->type->name : null,
                'action' => $event->action ? $event->action->name : null,
                'user' => $event->user ? $event->user->name : null,
                'description' => $event->description,
                'status' => $event->status,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Calendar::findOrFail($id);
        return Inertia::render('Calendar/Edit', [
            'event' => $event,
            'entities' => Entity::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'types' => CalendarType::select('id', 'name', 'color')->orderBy('name')->get(),
            'actions' => CalendarAction::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Calendar::findOrFail($id);
        $data = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'nullable|integer',
            'share' => 'nullable|string',
            'awareness' => 'nullable|string',
            'entity_id' => 'nullable|exists:entities,id',
            'type_id' => 'nullable|exists:calendar_types,id',
            'action_id' => 'nullable|exists:calendar_actions,id',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
        $event->update($data);
        return redirect()->route('calendar.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Calendar::findOrFail($id);
        $event->delete();
        return redirect()->route('calendar.index')->with('success', 'Event deleted successfully!');
    }
}
