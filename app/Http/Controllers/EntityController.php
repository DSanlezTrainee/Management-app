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
        // Store the referring URL in session, but only if it's not the create form itself
        $referer = request()->headers->get('referer');
        if ($referer && !str_contains($referer, '/entities/create')) {
            session(['entity_create_referer' => $referer]);
        }

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
        // Verification personalized for duplicate NIFs
        if (Entity::nifExists($request->input('nif'))) {
            return back()->withErrors(['nif' => 'The NIF has already been taken.'])->withInput();
        }

        $country = Country::find($request->input('country_id'));
        $validated = $request->validate([
            'type' => 'required|in:client,supplier,both',
            'nif' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($country) {
                    if ($country && strtoupper($country->code) === 'PT') {
                        if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                            $fail('NIF must start with 1,2,3,5,6,8 or 9 and have 9 digits.');
                        }
                    }
                }
            ],
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

        $nextNumber = (Entity::max('number') ?? 0) + 1;
        $validated['number'] = $nextNumber;

        $entity = Entity::create($validated);

        // Redirects for a stored URL in the session, or to the default list if it doesn't exist
        $redirectUrl = session('entity_create_referer');
        if ($redirectUrl) {
            session()->forget('entity_create_referer');
            return redirect($redirectUrl)->with('success', 'Entity created successfully!');
        }

        // Fallback: redirect based on the entity type
        if ($entity->type === 'client' || $entity->type === 'both') {
            return redirect()->route('entities.clients')->with('success', 'Entity created successfully!');
        } else {
            return redirect()->route('entities.suppliers')->with('success', 'Entity created successfully!');
        }
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
        $countries = Country::orderBy('name')->get(['id', 'name', 'code']);
        return Inertia::render('Entities/Edit', [
            'entity' => $entity->load('country'),
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entity $entity)
    {
        if ($request->input('nif') !== $entity->nif && Entity::nifExists($request->input('nif'), $entity->id)) {
            return back()->withErrors(['nif' => 'The NIF has already been taken.'])->withInput();
        }

        $country = Country::find($request->input('country_id'));
        $validated = $request->validate([
            'type' => 'required|in:client,supplier,both',
            'number' => 'required|integer|unique:entities,number,' . $entity->id,
            'nif' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($country) {
                    if ($country && strtoupper($country->code) === 'PT') {
                        if (!preg_match('/^[1|2|3|5|6|8|9][0-9]{8}$/', $value)) {
                            $fail('NIF deve ter 9 dígitos e começar por 1,2,3,5,6,8 ou 9.');
                        }
                    }
                    // Para outros países, apenas required|string (sem regex específica)
                }
            ],
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

        if ($entity->type === 'client' || $entity->type === 'both') {
            return redirect()->route('entities.clients')->with('success', 'Entity updated successfully!');
        } else {
            return redirect()->route('entities.suppliers')->with('success', 'Entity updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entity $entity)
    {
        $type = $entity->type;
        $entity->delete();

        if ($type === 'client' || $type === 'both') {
            return redirect()->route('entities.clients')->with('success', 'Entity deleted successfully!');
        } else {
            return redirect()->route('entities.suppliers')->with('success', 'Entity deleted successfully!');
        }
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

        try {
            $endpoint = 'https://ec.europa.eu/taxation_customs/vies/rest-api//check-vat-number';
            $payload = [
                'countryCode' => $countryCode,
                'vatNumber' => $vatNumber,
            ];
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->acceptJson()
                ->post($endpoint, $payload);

            $data = $response->json();
            if ($response->ok() && isset($data['valid'])) {
                return response()->json([
                    'valid' => $data['valid'],
                    'name' => $data['name'] ?? ($data['traderName'] ?? ''),
                    'address' => $data['address'] ?? ($data['traderAddress'] ?? ''),
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => $data['message'] ?? 'Erro desconhecido na resposta do VIES',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Serviço VIES indisponível. Tente novamente mais tarde.',
            ], 503);
        }
    }
}
