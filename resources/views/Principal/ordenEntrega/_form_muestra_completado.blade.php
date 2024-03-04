<div class="container mx-auto px-4 sm:px-8 md:px-16 lg:px-24">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Detalles de orden de Entrega</h2>
        </div>

        <div class="py-2">
            <div
                class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <div class="overflow-auto">
                    <table class="min-w-full">
                        <thead class="block sm:table-header-group">
                            <tr
                                class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre del cliente
                                </th>

                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Teléfono celular
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Correo electrónico
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    RFC
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Dirección de entrega
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Persona que atendió
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha de creacion del pedido
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Costo total
                                </th>
                                <th
                                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Cambio
                                </th>
                            </tr>
                        </thead>
                        <tbody class="block sm:table-row-group">
                            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $listaCliente->nombre_cliente }} {{ $listaCliente->apellido }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $listaCliente->telefono_cliente }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $listaCliente->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $listaCliente->comentario }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $datosPreventa->municipio }}, {{ $datosPreventa->estado }};
                                    Col.{{ $datosPreventa->localidad }}; {{ $datosPreventa->calle }}
                                    #{{ $datosPreventa->num_exterior }} / numero interior
                                    {{ $datosPreventa->num_interior }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {{ $listaEmpleado->nombre_empleado }} {{ $listaEmpleado->apellido }}-
                                    {{ $listaEmpleado->nombre_rol }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">

                                </td>
                                <!-- Repite el bloque anterior para los demás campos -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
