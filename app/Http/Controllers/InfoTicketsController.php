<?php

namespace App\Http\Controllers;

use App\Models\Info_tickets;
use Illuminate\Http\Request;

class InfoTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $InformacionDelTicket = Info_tickets::where('id', 1)->select('*')->first();

        return view('TicketUbicacion.index', compact('InformacionDelTicket'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    public function show(Info_tickets $info_tickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Info_tickets $infoticket)
    {

        return view('TicketUbicacion.edit', compact('infoticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Info_tickets $infoticket)
    {
        try {
            $ubicacion = $request->input('txtubicacion');
            $telefono = $request->input('txttelefono');
            $whatsapp = $request->input('txtwhatsapp');
            $paginaWeb = $request->input('txtpagina-web');

            $infoticket->update([
                'ubicaciones' => $ubicacion,
                'telefono' => $telefono,
                'whatsapp' => $whatsapp,
                'pagina_web' => $paginaWeb
            ]);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            session()->flash("incorrect", "Error al actualizar el registro");
            return redirect()->route('infoticket.index');
        }
        session()->flash("correcto", "Datos actualizados correctamente");
        return redirect()->route('infoticket.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Info_tickets $info_tickets)
    {
        //
    }
}
