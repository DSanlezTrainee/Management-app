<?php

namespace App\Http\Controllers;

use PSpell\Config;
use Inertia\Inertia;
use App\Models\Entity;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\ContactFunction;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with(['entity', 'contactFunction'])->simplePaginate(20);

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entities = Entity::orderBy('name')->get(['id', 'name']);
        $functions = ContactFunction::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Contacts/Create', [
            'entities' => $entities,
            'functions' => $functions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'entity_id' => 'required|exists:entities,id',
            'contact_function_id' => 'required|exists:contact_functions,id',
            'email' => 'required|email',
            'phone' => ['nullable', 'regex:/^\\d+$/'],
            'mobile' => ['required', 'regex:/^\\d+$/'],
            'rgpd_consent' => 'required|boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'phone.regex' => 'phone number must contain only numbers.',
            'mobile.regex' => 'mobile number must contain only numbers.',
        ]);

        $nextNumber = (Contact::max('number') ?? 0) + 1;
        $validated['number'] = $nextNumber;

        Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact->load(['entity', 'contactFunction'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $entities = Entity::orderBy('name')->get(['id', 'name']);
        $functions = ContactFunction::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Contacts/Edit', [
            'contact' => $contact->load(['entity', 'contactFunction']),
            'entities' => $entities,
            'functions' => $functions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'entity_id' => 'required|exists:entities,id',
            'contact_function_id' => 'required|exists:contact_functions,id',
            'email' => 'required|email',
            'phone' => ['nullable', 'regex:/^\\d+$/'],
            'mobile' => ['required', 'regex:/^\\d+$/'],
            'rgpd_consent' => 'required|boolean',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'phone.regex' => 'O número de telefone apenas pode conter números.',
            'mobile.regex' => 'O número de telemóvel apenas pode conter números.',
        ]);

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}
