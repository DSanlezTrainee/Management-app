<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\VatRate;
use Illuminate\Http\Request;

class VatRateController extends Controller
{
    public function index()
    {
        $vatRates = VatRate::orderBy('name')->paginate(20);
        return Inertia::render(
            'VatRates/Index',
            [
                'vatRates' => $vatRates
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Vat-rates/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'requited|numeric|min:0|max:100',
            'active' => 'required|boolean',
        ]);

        VatRate::create($validated);

        return redirect()->route('vat-rates.index')->with('success', 'Vat rate created successfully!');
    }

    public function show(VatRate $vatRate)
    {
        return Inertia::render('VatRates/Show', [
            'vatRate' => $vatRate
        ]);
    }
    public function edit(VatRate $vatRate)
    {
        return Inertia::render(
            'VatRates/Edit',
            [
                'vatRate' => $vatRate
            ]
        );
    }

    public function update(Request $request, VatRate $vatRate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
            'active' => 'required|boolean'
        ]);

        return redirect()->route('vat-rates.index')->with('sucess', 'VAT rate updated successfully!');
    }

    public function destroy(VatRate $vatRate)
    {
        $vatRate->delete();
        return redirect()->route('vat-rates.index')->with('success', 'VAT rate deleted successfully!');
    }
}
