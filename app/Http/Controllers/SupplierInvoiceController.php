<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Entity;
use Illuminate\Http\Request;
use App\Models\SupplierOrder;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\Mail;

class SupplierInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = SupplierInvoice::with(['supplier', 'supplierOrder'])->orderByDesc('invoice_date')->paginate(20);
        return Inertia::render('SupplierInvoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Entity::where('type', 'supplier')->get();
        $supplierOrders = SupplierOrder::all();
        return \Inertia\Inertia::render('SupplierInvoices/Create', [
            'suppliers' => $suppliers,
            'supplierOrders' => $supplierOrders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'supplier_id' => 'required|exists:entities,id',
            'supplier_order_id' => 'nullable|exists:supplier_orders,id',
            'total' => 'required|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'payment_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'status' => 'required|in:pending,paid',
        ]);

        $data = $validated;

        $nextId = (SupplierInvoice::max('id') ?? 0) + 1;
        $data['number'] = 'FTF-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('invoices/documents', 'public');
        }
        if ($request->hasFile('payment_receipt')) {
            $data['payment_receipt'] = $request->file('payment_receipt')->store('invoices/receipts', 'public');
        }
        $invoice = SupplierInvoice::create($data);

        if ($invoice->status === 'paid' && $invoice->payment_receipt && $invoice->supplier && $invoice->supplier->email) {
            Mail::to($invoice->supplier->email)->send(
                new \App\Mail\SupplierInvoicePaymentReceipt($invoice, $invoice->supplier, $invoice->payment_receipt)
            );
        }
        return redirect()->route('supplier-invoices.index')->with('success', 'Invoice created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = \App\Models\SupplierInvoice::with(['supplier', 'supplierOrder'])->findOrFail($id);
        return \Inertia\Inertia::render('SupplierInvoices/Show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = \App\Models\SupplierInvoice::findOrFail($id);
        $suppliers = \App\Models\Entity::where('type', 'supplier')->get();
        $supplierOrders = \App\Models\SupplierOrder::all();
        return \Inertia\Inertia::render('SupplierInvoices/Edit', [
            'invoice' => $invoice,
            'suppliers' => $suppliers,
            'supplierOrders' => $supplierOrders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = \App\Models\SupplierInvoice::findOrFail($id);
        $validated = $request->validate([
            'number' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'supplier_id' => 'required|exists:entities,id',
            'supplier_order_id' => 'nullable|exists:supplier_orders,id',
            'total' => 'required|numeric|min:0',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'payment_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'status' => 'required|in:pending,paid',
        ]);
        $data = $validated;
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('invoices/documents', 'public');
        }
        if ($request->hasFile('payment_receipt')) {
            $data['payment_receipt'] = $request->file('payment_receipt')->store('invoices/receipts', 'public');
        }
        $invoice->update($data);


        if ($invoice->status === 'paid' && $invoice->payment_receipt && $invoice->supplier && $invoice->supplier->email) {
            Mail::to($invoice->supplier->email)->send(
                new \App\Mail\SupplierInvoicePaymentReceipt($invoice, $invoice->supplier, $invoice->payment_receipt)
            );
        }
        return redirect()->route('supplier-invoices.index')->with('success', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierInvoice $supplierInvoice)
    {
        $supplierInvoice->delete();
        return redirect()->route('supplier-invoices.index')->with('success', 'Invoice deleted successfully!');
    }
}
