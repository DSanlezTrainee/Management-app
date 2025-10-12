<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Entity;
use App\Models\Article;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('client')->orderByDesc('date')->paginate(20);
        return Inertia::render('Proposals/Index', [
            'proposals' => $proposals,
        ]);
    }

    public function create()
    {
        $clients = Entity::where('type', 'client')->get();
        $articles = Article::all();
        $suppliers = Entity::where('type', 'supplier')->get();
        return Inertia::render('Proposals/Create', [
            'clients' => $clients,
            'articles' => $articles,
            'suppliers' => $suppliers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'client_id' => 'required|exists:entities,id',
            'valid_until' => 'required|date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.article_id' => 'required|exists:articles,id',
            'lines.*.quantity' => 'required|numeric|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.supplier_id' => 'nullable|exists:entities,id',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);

        $number = 'PROP-' . Str::padLeft(Proposal::max('id') + 1, 5, '0');
        $proposal = Proposal::create([
            'number' => $number,
            'date' => $validated['date'],
            'client_id' => $validated['client_id'],
            'valid_until' => $validated['valid_until'],
            'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
            'status' => $validated['status'],
        ]);
        foreach ($validated['lines'] as $line) {
            $proposal->lines()->create($line);
        }

        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully!');
    }

    public function show(Proposal $proposal)
    {
        $proposal->load(['client', 'lines.article', 'lines.supplier']);
        return Inertia::render('Proposals/Show', [
            'proposal' => $proposal,
        ]);
    }

    public function edit(Proposal $proposal)
    {
        $proposal->load(['lines']);
        $clients = Entity::where('type', 'client')->get();
        $suppliers = Entity::where('type', 'supplier')->get();
        $articles = Article::all();
        return Inertia::render('Proposals/Edit', [
            'proposal' => $proposal,
            'clients' => $clients,
            'suppliers' => $suppliers,
            'articles' => $articles,
        ]);
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'client_id' => 'required|exists:entities,id',
            'valid_until' => 'required|date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.article_id' => 'required|exists:articles,id',
            'lines.*.quantity' => 'required|numeric|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.supplier_id' => 'nullable|exists:entities,id',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);

        $proposal->update([
            'date' => $validated['date'],
            'client_id' => $validated['client_id'],
            'valid_until' => $validated['valid_until'],
            'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
            'status' => $validated['status'],
        ]);
        $proposal->lines()->delete();
        foreach ($validated['lines'] as $line) {
            $proposal->lines()->create($line);
        }
        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully!');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully!');
    }

    public function pdf(Proposal $proposal)
    {
        $proposal->load(['client', 'lines.article', 'lines.supplier']);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.proposal', ['proposal' => $proposal]);
        $filename = 'Proposal_' . $proposal->number . '.pdf';
        return $pdf->download($filename);
    }

    public function convertToOrder(Proposal $proposal)
    {
        $proposal->load('lines');

        $nextId = Order::max('id') + 1;
        $number = 'ENC-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $order = Order::create([
            'number' => $number,
            'date' => $proposal->date, // Usar a data da proposta
            'client_id' => $proposal->client_id,
            'valid_until' => $proposal->valid_until,
            'total' => $proposal->total,
            'status' => 'draft',
        ]);

        foreach ($proposal->lines as $line) {
            $order->lines()->create([
                'article_id' => $line->article_id,
                'supplier_id' => $line->supplier_id,
                'quantity' => $line->quantity,
                'price' => $line->price,
                'cost_price' => $line->cost_price ?? null,
            ]);
        }

        $proposal->delete();

        return redirect()->route('orders.index', $order->id)
            ->with('success', 'Orders created from the proposal!');
    }
}
