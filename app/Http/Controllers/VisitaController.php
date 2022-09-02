<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Http\Requests\StoreVisitaRequest;
use App\Http\Requests\UpdateVisitaRequest;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('oficinas.visitas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('oficinas.visitas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita)
    {
        return view('oficinas.visitas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function edit(Visita $visita)
    {
        return view('oficinas.visitas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitaRequest  $request
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitaRequest $request, Visita $visita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        //
    }
}
