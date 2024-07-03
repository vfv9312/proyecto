<aside id="default-sidebar" aria-hidden="true"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-600 dark:bg-gray-800">
        <div class=" lg:justify-start">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('logo_ecotoner.png') }}" class=" h-14" alt="Flowbite Logo" />
            </a>
        </div>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('inicio.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-black hover:bg-black dark:hover:bg-gray-700 group">
                    <i class=" fas fa-home"></i>
                    <span class="ms-3">Inicio</span>
                </a>
            </li>
            <li class="text-green-500 my-2 text-center">
                Menu
            </li>
            <li>
                <a href="{{ route('orden_recoleccion.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-shipping-fast"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Total de Ordenes</span>
                    {{-- <span
                        class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span> --}}
                </a>
            </li>
            <li>
                <a href="{{ route('ventas.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Ordenes procesadas</span>
                    {{-- <span
                        class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> --}}
                </a>
            </li>
            <li>
                <a href="{{ route('cancelar.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-ban"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Cancelaciones</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group menu-desplegable-siderbar">
                    <i class="fas fa-hourglass-half"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Moto Reparto</span> <i class="fas fa-angle-down"></i>
                </a>
                <ul class="menu-content hidden">
                    <li>
                        <a href="{{ route('TiempoAproximado.index') }}"
                            class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                            <i class="fas fa-clock"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Tiempo aproximado</span>
                        </a>
                    </li>
                    <!-- Agrega más enlaces aquí -->
                </ul>
            </li>
            <li class="menu">
                @if (Auth::user()->id_rol == 1)
                    <a href="#"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group menu-desplegable-siderbar">
                        <i class="fas fa-cogs"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Ajustes</span> <i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="menu-content hidden">
                        <li>
                            <a href="{{ route('Restablecer.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <i class="fas fa-trash"></i>
                                <span class="flex-1 ms-3 whitespace-nowrap">Recuperar información</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cancelar.create') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <i class="fas fa-times"></i>
                                <span class="flex-1 ms-3 whitespace-nowrap">Cancelación</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categorias.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-book-half" viewBox="0 0 16 16">
                                    <path
                                        d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Categorias</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('marcas.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-threads" viewBox="0 0 16 16">
                                    <path
                                        d="M6.321 6.016c-.27-.18-1.166-.802-1.166-.802.756-1.081 1.753-1.502 3.132-1.502.975 0 1.803.327 2.394.948s.928 1.509 1.005 2.644q.492.207.905.484c1.109.745 1.719 1.86 1.719 3.137 0 2.716-2.226 5.075-6.256 5.075C4.594 16 1 13.987 1 7.994 1 2.034 4.482 0 8.044 0 9.69 0 13.55.243 15 5.036l-1.36.353C12.516 1.974 10.163 1.43 8.006 1.43c-3.565 0-5.582 2.171-5.582 6.79 0 4.143 2.254 6.343 5.63 6.343 2.777 0 4.847-1.443 4.847-3.556 0-1.438-1.208-2.127-1.27-2.127-.236 1.234-.868 3.31-3.644 3.31-1.618 0-3.013-1.118-3.013-2.582 0-2.09 1.984-2.847 3.55-2.847.586 0 1.294.04 1.663.114 0-.637-.54-1.728-1.9-1.728-1.25 0-1.566.405-1.967.868ZM8.716 8.19c-2.04 0-2.304.87-2.304 1.416 0 .878 1.043 1.168 1.6 1.168 1.02 0 2.067-.282 2.232-2.423a6.2 6.2 0 0 0-1.528-.161" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Marcas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('descuentos.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <i class="fas fa-tags"></i>
                                <span class="flex-1 ms-3 whitespace-nowrap">Descuentos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('infoticket.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <i class="fas fa-address-book"></i>
                                <span class="flex-1 ms-3 whitespace-nowrap">Datos de contacto</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('eliminacion.index') }}"
                                class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Clave de eliminación</span>
                            </a>
                        </li>
                        <!-- Agrega más enlaces aquí -->
                    </ul>
                @endif
            </li>
            <li class="text-green-500 my-2 text-center">
                Vista rapida
            </li>
            <li>
                <a href="{{ route('clientes.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-users"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Clientes</span>
                </a>
            </li>
            @if (Auth::user()->id_rol == 1)
                <li>
                    <a href="{{ route('empleados.index') }}"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                        <i class="fas fa-briefcase"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Empleados</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{ route('productos.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-box-open"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Productos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('servicios.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-bucket-fill" viewBox="0 0 16 16">
                        <path
                            d="M2.522 5H2a.5.5 0 0 0-.494.574l1.372 9.149A1.5 1.5 0 0 0 4.36 16h7.278a1.5 1.5 0 0 0 1.483-1.277l1.373-9.149A.5.5 0 0 0 14 5h-.522A5.5 5.5 0 0 0 2.522 5m1.005 0a4.5 4.5 0 0 1 8.945 0z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Recargas</span>
                </a>
            </li>
            <li>
            <li class="text-green-500 my-2 text-center">
                Cuenta
            </li>
            <li>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-user"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Cuenta</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 dark:text-green-500 group-hover:text-white dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Cerrar Sesion</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</aside>
