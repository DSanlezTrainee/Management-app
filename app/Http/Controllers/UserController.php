<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')
            ->select('id', 'name', 'email', 'mobile', 'status')
            ->paginate(20)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'role' => $user->roles->pluck('name')->first(),
                    'status' => $user->status,
                ];
            });
        $roles = \Spatie\Permission\Models\Role::select('id', 'name')->get();
        return \Inertia\Inertia::render('Access/Users/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \Spatie\Permission\Models\Role::select('id', 'name')->get();
        return \Inertia\Inertia::render('Access/Users/Create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:30',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'status' => $validated['status'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'Utilizador criado com sucesso!');
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
        $users = User::with('roles')
            ->select('id', 'name', 'email', 'mobile', 'status')
            ->paginate(20) // <--- Usa paginação
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'role' => $user->roles->pluck('name')->first(),
                    'status' => $user->status,
                ];
            });
        $roles = \Spatie\Permission\Models\Role::select('id', 'name')->get();
        return \Inertia\Inertia::render('Access/Users/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:30',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->mobile = $validated['mobile'];
        $user->status = $validated['status'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'Utilizador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
