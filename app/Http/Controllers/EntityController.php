<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display only clients.
     */
    public function clients()
    {
        $entities = Entity::where('type', 'client')->with('country')->paginate(20);
        return Inertia::render('Entities/Index', [
            'entities' => $entities,
            'type' => 'client'
        ]);
    }

    /**
     * Display only suppliers.
     */
    public function suppliers()
    {
        $entities = Entity::where('type', 'supplier')->with('country')->paginate(20);
        return Inertia::render('Entities/Index', [
            'entities' => $entities,
            'type' => 'supplier'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Entities/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:client,supplier',
            'number' => 'required|integer|unique:entities,number',
            'nif' => ['required', 'string', 'unique:entities,nif', function ($attribute, $value, $fail) {
                if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                    $fail('NIF must have 9 digits and start with 1,2,3,5,6,8 or 9.');
                }
            }],
            'name' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'email' => 'nullable|email',
            'postal_code' => 'nullable|regex:/^\d{4}-\d{3}$/',
            'status' => 'required|in:active,inactive',
        ]);

        $entity = Entity::create($validated);
        return redirect()->route('entities.index')->with('success', 'Entity created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entity $entity)
    {
        return Inertia::render('Entities/Show', [
            'entity' => $entity->load('country')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entity $entity)
    {
        return Inertia::render('Entities/Edit', [
            'entity' => $entity->load('country')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entity $entity)
    {
        $validated = $request->validate([
            'type' => 'required|in:client,supplier',
            'number' => 'required|integer|unique:entities,number,' . $entity->id,
            'nif' => ['required', 'string', 'unique:entities,nif,' . $entity->id, function ($attribute, $value, $fail) {
                if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                    $fail('NIF must have 9 digits and start with 1,2,3,5,6,8 or 9.');
                }
            }],
            'name' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'email' => 'nullable|email',
            'postal_code' => 'nullable|regex:/^\d{4}-\d{3}$/',
            'status' => 'required|in:active,inactive',
        ]);

        $entity->update($validated);
        return redirect()->route('entities.index')->with('success', 'Entity updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entity $entity)
    {
        $entity->delete();
        return redirect()->route('entities.index')->with('success', 'Entity deleted successfully!');
    }
}
