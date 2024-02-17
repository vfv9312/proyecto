<?php

namespace App\Http\Controllers;

use App\Models\productos;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    //
    public function index()
    {
        return view('Principal.inicio');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(productos $usuarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productos $usuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productos $usuarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productos $usuarios)
    {
        //
    }
}
