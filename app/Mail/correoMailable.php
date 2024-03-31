<?php

namespace App\Mail;

use App\Models\Orden_recoleccion;
use App\Models\precios_productos;
use App\Models\TiempoAproximado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address as MailablesAddress;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class correoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $ordenRecoleccion;
    public $listaProductos;
    public $Tiempo;

    /**
     * Create a new message instance.
     */
    public function __construct($ordenRecoleccion, $listaProductos, $Tiempo)
    {
        $this->ordenRecoleccion = $ordenRecoleccion;
        $this->listaProductos = $listaProductos;
        $this->Tiempo = $Tiempo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // from: new MailablesAddress('admin@ecotonerdelsureste.com', 'AdministradorEcotoner'),
            subject: 'Notificación de folio',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {



        return new Content(
            view: 'correo.enviarCorreo',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
