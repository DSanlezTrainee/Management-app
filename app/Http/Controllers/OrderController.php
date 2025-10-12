<?php

    namespace App\Http\Controllers;

    use App\Models\Order;
    use App\Models\Entity;
    use App\Models\Article;
    use Illuminate\Http\Request;
    use Inertia\Inertia;

    class OrderController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $orders = Order::with('client')->orderByDesc('date')->paginate(20);
            return Inertia::render('Orders/Index', [
                'orders' => $orders,
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            $clients = Entity::where('type', 'client')->get();
            $articles = Article::all();
            $suppliers = Entity::where('type', 'supplier')->get();
            return Inertia::render('Orders/Create', [
                'clients' => $clients,
                'articles' => $articles,
                'suppliers' => $suppliers,
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
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

            $number = 'ENC-' . str_pad(Order::max('id') + 1, 5, '0', STR_PAD_LEFT);
            $order = Order::create([
                'number' => $number,
                'date' => $validated['date'],
                'client_id' => $validated['client_id'],
                'valid_until' => $validated['valid_until'],
                'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
                'status' => $validated['status'],
            ]);
            foreach ($validated['lines'] as $line) {
                $order->lines()->create($line);
            }
            return redirect()->route('orders.index')->with('success', 'Order created successfully!');
        }

        /**
         * Display the specified resource.
         */
        public function show(Order $order)
        {
            $order->load(['client', 'lines.article', 'lines.supplier']);
            return Inertia::render('Orders/Show', [
                'order' => $order,
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Order $order)
        {
            $order->load(['lines']);
            $clients = Entity::where('type', 'client')->get();
            $suppliers = Entity::where('type', 'supplier')->get();
            $articles = Article::all();
            return Inertia::render('Orders/Edit', [
                'order' => $order,
                'clients' => $clients,
                'suppliers' => $suppliers,
                'articles' => $articles,
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Order $order)
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

            $order->update([
                'date' => $validated['date'],
                'client_id' => $validated['client_id'],
                'valid_until' => $validated['valid_until'],
                'status' => $validated['status'],
                'total' => collect($validated['lines'])->sum(fn($l) => $l['price'] * $l['quantity']),
            ]);
            $order->lines()->delete();
            foreach ($validated['lines'] as $line) {
                $order->lines()->create($line);
            }
            return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Order $order)
        {
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
        }

        /**
         * Gera o PDF da encomenda de cliente.
         */
        public function pdf(Order $order)
        {
            $order->load(['client', 'lines.article', 'lines.supplier']);
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('pdf.order', ['order' => $order]);
            $filename = 'Order_' . $order->number . '.pdf';
            return $pdf->download($filename);
        }
    }
