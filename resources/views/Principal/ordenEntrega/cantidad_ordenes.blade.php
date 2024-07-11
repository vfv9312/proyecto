@extends('layouts.admin')

@section('title', 'Ordenes')


@section('content')
    <section class=" flex flex-col justify-center  h-screen">
        <h1 class=" text-center font-bold mb-5">Pedido realizado</h1>

        <h3 class=" text-center"> {{ $producto ? $producto->created_at : $servicio->created_at }}</h3>

        <h1 class=" text-center font-medium">Cliente : {{ $cliente->nombre }}
            {{ $cliente->apellido != '.' ? $cliente->apellido : '' }}</h1>
        <div class="flex flex-col md:flex-row justify-center">
            <span
                class="inline-block px-2 py-1 mb-0 text-center text-base font-normal leading-normal cursor-text bg-white border border-gray-300 rounded">
                Telefono : {{ $cliente->telefono }}</span>
            <span
                class="inline-block px-2 py-1 mb-0 text-center text-base font-normal leading-normal cursor-text bg-white border border-gray-300 rounded">
                Correo electronico : {{ $cliente->email }}</span>
            <span
                class="inline-block px-2 py-1 mb-0 text-center text-base font-normal leading-normal cursor-text bg-white border border-gray-300 rounded">
                Atiende : {{ $producto ? $producto->nombre_atencion : $servicio->nombre_atencion }}
            </span>
            <span
                class="inline-block px-2 py-1 mb-0 text-center text-base font-normal leading-normal cursor-text bg-white border border-gray-300 rounded">
                Recibe :
                {{ $producto ? $producto->nombre_quien_recibe : $servicio->nombre_quien_recibe }}
            </span>
            <span
                class="inline-block px-2 py-1 mb-0 text-center text-base font-normal leading-normal cursor-text bg-white border border-gray-300 rounded">

                {{ $servicio ? 'Entrega :' . ' ' . $servicio->nombre_quien_recibe : 'productos de entrega' }}
            </span>
        </div>
        <div class=" flex flex-row justify-evenly mt-7">
            @if ($producto)
                <div class="flex items-center">
                    <a href="{{ route('orden_recoleccion.vistaPreviaOrdenEntrega', $producto->id) }}"
                        class="inline-flex items-center px-20 py-20 text-white rounded" style="background-color: #01652f;"
                        onmouseover="this.style.backgroundColor='#0F5132';"
                        onmouseout="this.style.backgroundColor='#01652f';">
                        Entrega
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                            class="bi bi-file-earmark-text ml-2" viewBox="0 0 16 16">
                            <path
                                d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                            <path
                                d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                        </svg>
                    </a>
                </div>
            @endif

            @if ($servicio)
                <div class=" flex items-center">
                    <a href="{{ route('ordenServicio.vistaGeneral', ['id' => $ordenrecoleccionServicio->id]) }}"
                        class="inline-flex items-center px-20 py-20 bg-green-700 text-white rounded hover:bg-green-800">
                        Recolección
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                            class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                            <path
                                d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                            <path
                                d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                        </svg></a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <!-- Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--Font Awesome para los iconos-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('js')
    <script></script>
@endpush
