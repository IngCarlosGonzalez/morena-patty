<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Http\Requests\StoreColoniaRequest;
use App\Http\Requests\UpdateColoniaRequest;

class ColoniaController extends Controller
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
     * @param  \App\Http\Requests\StoreColoniaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreColoniaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colonia  $colonia
     * @return \Illuminate\Http\Response
     */
    public function show(Colonia $colonia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colonia  $colonia
     * @return \Illuminate\Http\Response
     */
    public function edit(Colonia $colonia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColoniaRequest  $request
     * @param  \App\Models\Colonia  $colonia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColoniaRequest $request, Colonia $colonia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colonia  $colonia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colonia $colonia)
    {
        //
    }
}
