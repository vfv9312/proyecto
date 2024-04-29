<nav class="bg-gray-600 border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-3xl flex flex-wrap items-center justify-between mx-auto p-4">
        <div class=" lg:justify-start">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('logo_ecotoner.png') }}" class=" h-11" alt="Flowbite Logo" />
            </a>
        </div>
        <div class="lg:flex lg:justify-center items-center ml-auto mr-auto hidden sm:block">
            <strong class="mr-2">Usuario :</strong> <strong class=" text-green-500">{{ Auth::user()->name }}</strong>
            <strong class="mx-2">Rol :</strong>
            <strong class=" text-green-500">{{ Auth::user()->role->nombre }}</strong>
        </div>
        <div class="flex md:order-2">


            <button data-collapse-toggle="navbar-search" type="button" data-drawer-target="default-sidebar"
                data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>


    </div>
    </div>
</nav>
