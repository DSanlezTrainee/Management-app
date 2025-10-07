<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Inertia\Inertia;
use App\Models\Entity;
use App\Models\Country;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display only clients.
     */
    public function clients()
    {
        $entities = Entity::where(function ($query) {
            $query->where('type', 'client')
                ->orWhere('type', 'both');
        })->with('country')->paginate(20);

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
        $entities = Entity::where(function ($query) {
            $query->where('type', 'supplier')
                ->orWhere('type', 'both');
        })->with('country')->paginate(20);

        return Inertia::render('Entities/Index', [
            'entities' => $entities,
            'type' => 'supplier'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        $countries = Country::orderBy('name')->get(['id', 'name', 'code']);
        return Inertia::render('Entities/Create', [
            'type' => $type,
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:client,supplier,both',
            'number' => 'required|integer|unique:entities,number',
            'nif' => ['required', 'string', 'unique:entities,nif', function ($attribute, $value, $fail) {
                if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                    $fail('NIF must have 9 digits and start with 1,2,3,5,6,8 or 9.');
                }
            }],
            'name' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'website' => 'nullable|url',
            'rgpd_consent' => 'required|boolean',
            'notes' => 'nullable|string',
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
            'type' => 'required|in:client,supplier,both',
            'number' => 'required|integer|unique:entities,number,' . $entity->id,
            'nif' => ['required', 'string', 'unique:entities,nif,' . $entity->id, function ($attribute, $value, $fail) {
                if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                    $fail('NIF must have 9 digits and start with 1,2,3,5,6,8 or 9.');
                }
            }],
            'name' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'website' => 'nullable|url',
            'rgpd_consent' => 'required|boolean',
            'notes' => 'nullable|string',
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
    /**
     * VIES VAT number lookup.
     */
    public function viesLookup(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string|size:2',
            'vat_number' => 'required|string',
        ]);

        $countryCode = strtoupper($request->input('country_code'));
        $vatNumber = preg_replace('/\D/', '', $request->input('vat_number'));

        Log::info('VIES lookup request', [
            'country_code' => $countryCode,
            'vat_number' => $vatNumber,
        ]);

        try {
            $client = new \SoapClient('https://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl');
            $result = $client->checkVat([
                'countryCode' => $countryCode,
                'vatNumber' => $vatNumber,
            ]);

            Log::info('VIES lookup result', [
                'result' => $result
            ]);

            if ($result->valid) {
                return response()->json([
                    'valid' => true,
                    'name' => $result->name,
                    'address' => $result->address,
                ]);
            } else {
                return response()->json(['valid' => false], 404);
            }
        } catch (\Exception $e) {
            Log::error('VIES lookup error', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'VIES service unavailable', 'details' => $e->getMessage()], 500);
        }
    }
}
