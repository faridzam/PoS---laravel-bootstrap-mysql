<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\produk;
use App\Models\invoice;
use App\Models\penjualan;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorepenjualanRequest;
use App\Http\Requests\UpdatepenjualanRequest;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $produk=produk::all();
        $penjualan = penjualan::all();
        $invoice = invoice::all();
        $TIDs = Str::random(20);

        return view('dashboard.penjualan', compact('produk', 'penjualan', 'invoice', 'TIDs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepenjualanRequest $request)
    {
        //

        $request->validate([
            'id_produk' => 'required',
            't_id' => 'nullable',
            'nama_produk' => 'required',
            'harga_produk' => 'required',
            'kuantitas' => 'required',
            'jumlah' => 'required'
        ]);

        penjualan::create($request->all());

        return redirect()->route(route: 'dashboardInvoice.index')
            ->with('SUKSES!','order sukses.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(invoice $invoice)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepenjualanRequest  $request
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepenjualanRequest $request, penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(penjualan $penjualan)
    {
        //
    }
}
