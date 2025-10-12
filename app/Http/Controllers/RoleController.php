<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->paginate(20);
        return \Inertia\Inertia::render('Access/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return \Inertia\Inertia::render('Access/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'status' => 'required|in:active,inactive',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $role = Role::create([
            'name' => $validated['name'],
            'status' => $validated['status'],
            'guard_name' => 'web',
        ]);
        $role->syncPermissions($validated['permissions'] ?? []);
        return redirect()->route('roles.index')->with('success', 'Grupo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return \Inertia\Inertia::render('Access/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'status' => 'required|in:active,inactive',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        $role->name = $validated['name'];
        $role->status = $validated['status'];
        $role->save();
        $role->syncPermissions($validated['permissions'] ?? []);
        return redirect()->route('roles.index')->with('success', 'Grupo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Grupo removido com sucesso!');
    }
}
