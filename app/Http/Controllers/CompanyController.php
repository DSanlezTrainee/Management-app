<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Exibe o formulário de edição dos dados da empresa.
     */
    public function edit()
    {
        $company = Company::info();

        return Inertia::render('Settings/Company', [
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {

        $company = Company::info();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|regex:/^\d{4}-\d{3}$/',
            'city' => 'nullable|string|max:100',
            'nif' => 'required|string|max:30',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company_logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('settings.company.edit')->with('success', 'Company data updated successfully!');
    }
}
