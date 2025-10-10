<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Article;
use App\Models\VatRate;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('vatRate')->paginate(20);
        return Inertia::render('Articles/Index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vatRates = VatRate::where('active', true)
            ->orderBy('name')->get(['id', 'name', 'rate']);

        return Inertia::render('Articles/Create', [
            'vatRates' => $vatRates
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'reference' => 'required|unique:articles,reference',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'vat_rate_id' => 'required|exists:vat_rates,id',
                'photo' => 'nullable|image|max:2048',
                'notes' => 'nullable|string',
                'status' => 'required|in:active,inactive',
            ]);

            if (!($vatRate = VatRate::find($validated['vat_rate_id']))) {
                return redirect()->back()->withErrors(['vat_rate_id' => 'VAT rate not found.']);
            }

            $priceWithVat = $validated['price'] * (1 + ($vatRate->rate / 100));
            $validated['price_with_vat'] = round($priceWithVat, 2);

            Article::create($validated);

            return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the article.' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return Inertia::render('Articles/Show', [
            'article' => $article->load('vatRate')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $vatRates = VatRate::where('status', 'active')
            ->orderBy('name')->get();

        return Inertia::render('Articles/Edit', [
            'article' => $article->load('vatRate'),
            'vatRates' => $vatRates
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $validated = $request->validate([
                'reference' => 'required|string|max:255|unique:articles,reference,' . $article->id,
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'vat_rate_id' => 'required|exists:vat_rates,id',
                'photo' => 'nullable|string',
                'notes' => 'nullable|string',
                'status' => 'required|in:active,inactive',
            ]);

            if (!($vatRate = VatRate::find($validated['vat_rate_id']))) {
                return redirect()->back()->withErrors(['vat_rate_id' => 'VAT rate not found.']);
            }

            $priceWithVat = $validated['price'] * (1 + ($vatRate->rate / 100));
            $validated['price_with_vat'] = round($priceWithVat, 2);

            $article->update($validated);

            return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error updating article: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error deleting article: ' . $e->getMessage()]);
        }
    }
}
