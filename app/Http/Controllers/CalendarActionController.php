<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarAction;
use Inertia\Inertia;

class CalendarActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions = CalendarAction::all();
        if (request()->wantsJson()) {
            return response()->json($actions);
        }
        return Inertia::render('Settings/CalendarActions', [
            'actions' => $actions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/CalendarActions');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $action = CalendarAction::create($data);
        if ($request->wantsJson()) {
            return response()->json($action, 201);
        }
        return redirect()->route('calendar-actions.index');
    }

    /**
     * Display the specified resource.
     */
    // Não usado

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $action = CalendarAction::findOrFail($id);
        return Inertia::render('Settings/CalendarActions', [
            'editAction' => $action,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $action = CalendarAction::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $action->update($data);
        if ($request->wantsJson()) {
            return response()->json($action);
        }
        return redirect()->route('calendar-actions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $action = CalendarAction::findOrFail($id);
        $action->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('calendar-actions.index');
    }
}
