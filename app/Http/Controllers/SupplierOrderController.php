<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\SupplierOrder;
use App\Models\SupplierOrderLine;
use App\Models\Entity;
use App\Models\Article;
use Inertia\Inertia;

class SupplierOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = SupplierOrder::with('supplier')->orderByDesc('date')->paginate(20);
        return Inertia::render('SupplierOrders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Entity::where('type', 'supplier')->get();
        $articles = Article::all();
        return Inertia::render('SupplierOrders/Create', [
            'suppliers' => $suppliers,
            'articles' => $articles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:entities,id',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.article_id' => 'required|exists:articles,id',
            'lines.*.quantity' => 'required|numeric|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);
        $number = 'ENF-' . str_pad(SupplierOrder::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $order = SupplierOrder::create([
            'number' => $number,
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'valid_until' => $validated['valid_until'],
            'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
            'status' => $validated['status'],
        ]);
        foreach ($validated['lines'] as $line) {
            $order->lines()->create($line);
        }
        return redirect()->route('supplier-orders.index')->with('success', 'Encomenda de fornecedor criada!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = SupplierOrder::with(['supplier', 'lines.article'])->findOrFail($id);
        return Inertia::render('SupplierOrders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = SupplierOrder::with('lines')->findOrFail($id);
        $suppliers = Entity::where('type', 'supplier')->get();
        $articles = Article::all();
        return Inertia::render('SupplierOrders/Edit', [
            'order' => $order,
            'suppliers' => $suppliers,
            'articles' => $articles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = SupplierOrder::findOrFail($id);
        $validated = $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:entities,id',
            'valid_until' => 'nullable|date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.article_id' => 'required|exists:articles,id',
            'lines.*.quantity' => 'required|numeric|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);
        $order->update([
            'date' => $validated['date'],
            'supplier_id' => $validated['supplier_id'],
            'valid_until' => $validated['valid_until'],
            'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
            'status' => $validated['status'],
        ]);
        $order->lines()->delete();
        foreach ($validated['lines'] as $line) {
            $order->lines()->create($line);
        }
        return redirect()->route('supplier-orders.index')->with('success', 'Encomenda de fornecedor atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierOrder $supplierOrder)
    {
        $supplierOrder->delete();
        return redirect()->route('supplier-orders.index')->with('success', 'Supplier order deleted!');
    }
}
