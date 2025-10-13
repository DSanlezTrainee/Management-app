<?php

namespace App\Http\Controllers;

use App\Traits\LogsActivityHelper;
use Inertia\Inertia;
use App\Models\VatRate;
use Illuminate\Http\Request;

class VatRateController extends Controller
{
    use LogsActivityHelper;
    public function index()
    {
        $vatRates = VatRate::orderBy('name')->paginate(20);
        $this->logActivity('viewed vat rates list');
        return Inertia::render(
            'VatRates/Index',
            [
                'vatRates' => $vatRates
            ]
        );
    }

    public function create()
    {
        return Inertia::render('VatRates/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0|max:100',
            'active' => 'required|boolean',
        ]);

        $vatRate = VatRate::create($validated);
        $this->logActivity('created vat rate', $vatRate);
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

        $vatRate->update($validated);
        $this->logActivity('updated vat rate', $vatRate);
        return redirect()->route('vat-rates.index')->with('success', 'VAT rate updated successfully!');
    }

    public function destroy(VatRate $vatRate)
    {
        $vatRate->delete();
        $this->logActivity('deleted vat rate', $vatRate);
        return redirect()->route('vat-rates.index')->with('success', 'VAT rate deleted successfully!');
    }
}
