<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoliosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Modificacion_Folio.folios');
    }
}
