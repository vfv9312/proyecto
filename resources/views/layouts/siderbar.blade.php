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
            <li class="text-yellow-500 my-2 text-center">
                Menu
            </li>
            <li>
                <a href="{{ route('orden_recoleccion.index') }}"
                    class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-black dark:hover:bg-gray-700 group">
                    <i class="fas fa-shipping-fast"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Recoleccion</span>
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
                        <!-- Agrega más enlaces aquí -->
                    </ul>
                @endif
            </li>
            <li class="text-yellow-500 my-2 text-center">
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
                    <i class="fas fa-concierge-bell"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Servicios</span>
                </a>
            </li>
            <li>
            <li class="text-yellow-500 my-2 text-center">
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
