<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\invoice;
use App\Models\penjualan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreinvoiceRequest;
use App\Http\Requests\UpdateinvoiceRequest;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoice = invoice::all();
        $penjualan = penjualan::all();
        $latest = DB::table('penjualans')->latest('created_at')->first();

        if(!$penjualan->count() !== 0) {
            $dtn = $latest->created_at;
            $pesananBaru = DB::table('penjualans')->where('created_at', '=', $dtn)->get();
            $hartot = $pesananBaru->sum('jumlah');
        } else {
            $pesananBaru = $penjualan;
            $hartot = $pesananBaru->sum('jumlah');
        }

        return view('dashboard.invoice', compact('penjualan', 'latest', 'dtn', 'pesananBaru', 'invoice', 'hartot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $invoice = invoice::whereDate('created_at', Carbon::today())->get();
        // $penjualan = penjualan::whereDate('created_at', Carbon::today())->get();

        // return view('dashboard.close', compact('invoice', 'penjualan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreinvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreinvoiceRequest $request)
    {
        //

        $request->validate([
            'penjualan' => 'required',
            'tagihan' => 'required',
            'jumlah_bayar' => 'required',
            'kembalian' => 'required'
        ]);

        invoice::create($request->all());

        return redirect('/printInvoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(invoice $invoice)
    {
        //
        $invoice = invoice::all();
        $lateinv = DB::table('invoices')->latest('created_at')->first();
        $penjualan = penjualan::all();
        $latest = DB::table('penjualans')->latest('created_at')->first();

        if(!$penjualan->count() !== 0) {
            $dtn = $latest->created_at;
            $pesananBaru = DB::table('penjualans')->where('created_at', '=', $dtn)->get();
            $hartot = $pesananBaru->sum('jumlah');
        } else {
            $pesananBaru = $penjualan;
            $hartot = $pesananBaru->sum('jumlah');
        }

        // Set params
        $mid = $latest->id;
        $store_name = 'SALOKA';
        $store_address = 'Semarang';
        $store_phone = '08987654321';
        $store_email = 'admin@salokapark.com';
        $store_website = 'salokapark.com';
        $tax_percentage = 10;
        $transaction_id = $dtn;

        // Set items
        $jsons = $lateinv->penjualan;
        $items = json_decode($jsons, true);

        // Init printer
        $printer = new ReceiptPrinter;
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['nama_produk'],
                $item['harga_produk'],
                $item['kuantitas'],
                $item['jumlah']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();

        return redirect('/dashboardPenjualan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinvoiceRequest  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateinvoiceRequest $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice $invoice)
    {
        //
    }
}
