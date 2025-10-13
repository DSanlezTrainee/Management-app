<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarType;
use Inertia\Inertia;

class CalendarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = CalendarType::all();
        if (request()->wantsJson()) {
            return response()->json($types);
        }
        return Inertia::render('Settings/CalendarTypes', [
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/CalendarTypes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);
        $type = CalendarType::create($data);
        if ($request->wantsJson()) {
            return response()->json($type, 201);
        }
        return redirect()->route('calendar-types.index');
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
        $type = CalendarType::findOrFail($id);
        return Inertia::render('Settings/CalendarTypes', [
            'editType' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $type = CalendarType::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);
        $type->update($data);
        if ($request->wantsJson()) {
            return response()->json($type);
        }
        return redirect()->route('calendar-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = CalendarType::findOrFail($id);
        $type->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('calendar-types.index');
    }
}
