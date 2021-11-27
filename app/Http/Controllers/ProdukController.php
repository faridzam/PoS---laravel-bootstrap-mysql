<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;

class ProdukController extends Controller
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
        return view('dashboard.produk', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.produk');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreprodukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreprodukRequest $request)
    {
        //  
        $validated = $request->validate([
            'nama_produk' => 'required',
            'harga_produk' => 'required',
            'stok_produk' => 'required',
        ]);

        //produk::create($validated->all());
        $produk = produk::find($id)->update($validated->all());

        return redirect()->route(route: 'dashboardProduk.index')
            ->with('SUKSES!','Produk telah ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(produk $produk, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(produk $produk, $id)
    {
        //
        $produk = produk::findOrfail($id);
        return view('dashboard.modal.editProduk', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateprodukRequest  $request
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateprodukRequest $request, produk $produk, $id)
    {
        //
        $request->validate([
            'nama_produk' => 'required|unique:produks',
            'harga_produk' => 'required',
            'stok_produk' => 'required'
        ]);

        $produk = produk::findOrfail($id);
        
        $produk->update($request->all());

        if ($produk->save()) {
            return redirect()->route(route: 'dashboardProduk.index')->with('SUKSES!', 'Produk telah diupdate');
        } else {
            // handle error.
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = produk::findOrfail($id);
        $produk->delete();

        return redirect()->route(route: 'dashboardProduk.index')
            ->with('SUKSES!','Produk telah dihapus.');
    }
}
