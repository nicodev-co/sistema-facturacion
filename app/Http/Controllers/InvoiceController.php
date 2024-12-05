<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('invoices.index', [
            'invoices' => Invoice::orderBy('id','desc')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoice = new Invoice();
        $products = Product::all();
        $customers = Customer::all();
        return view('invoices.create', compact('invoice', 'products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();

        $invoice = Invoice::create($data);

        foreach ($data['details'] as $detail) {
            $invoice->invoiceDetails()->create($detail);
        }

        return redirect()->route('invoices.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $products = Product::all();
        $customers = Customer::all();

        return view('invoices.create', compact('invoice','products','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $invoice->update($data);

        $products = array_column($data['details'],'product_id');
        $invoice->invoiceDetails()->whereNotIn('product_id',$products)->delete();

        foreach ($data['details'] as $detail) {
            $invoice->invoiceDetails()->updateOrCreate(['product_id' => $detail['product_id']],$detail);
        }

        return redirect()->route('invoices.index');
    }

    public function cancel(Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);
        return redirect()->route('invoices.show', $invoice);
    }

    public function search(Request $request)
    {
        $invoices = Invoice::where('id', 'like', "%{$request->search}%")
            ->orWhereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->orWhere('total_amount', 'like', "%{$request->search}%")
            ->orderBy('id','desc')
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }
}
