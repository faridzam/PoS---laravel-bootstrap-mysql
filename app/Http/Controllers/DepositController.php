<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredepositRequest;
use App\Http\Requests\UpdatedepositRequest;
use App\Models\deposit;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoredepositRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredepositRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedepositRequest  $request
     * @param  \App\Models\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatedepositRequest $request, deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(deposit $deposit)
    {
        //
    }
}
