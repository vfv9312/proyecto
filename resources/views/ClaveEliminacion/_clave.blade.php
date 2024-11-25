<div class=" flex flex-col items-center justify-center w-full">

    <form action="{{ route('eliminacion.store') }}" method="post" class="max-w-sm mb-4">
        @csrf
        <div class="flex mb-2 space-x-2 rtl:space-x-reverse">
            <div>
                <label for="code-1" class="sr-only">First code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1"
                    name="code-1"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-2" class="sr-only">Second code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1"
                    data-focus-input-next="code-3" id="code-2" name="code-2"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-3" class="sr-only">Third code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2"
                    data-focus-input-next="code-4" id="code-3" name="code-3"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-4" class="sr-only">Fourth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3"
                    data-focus-input-next="code-5" id="code-4" name="code-4"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-5" class="sr-only">Fifth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4"
                    data-focus-input-next="code-6" id="code-5" name="code-5"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
            <div>
                <label for="code-6" class="sr-only">Sixth code</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6"
                    name="code-6"
                    class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required />
            </div>
        </div>
        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Por favor introduce 6
            dígitos para crear la clave
            .</p>
        <div class=" flex justify-center">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-floppy2-fill mr-2" viewBox="0 0 16 16">
                    <path d="M12 2h-2v3h2z" />
                    <path
                        d="M1.5 0A1.5 1.5 0 0 0 0 1.5v13A1.5 1.5 0 0 0 1.5 16h13a1.5 1.5 0 0 0 1.5-1.5V2.914a1.5 1.5 0 0 0-.44-1.06L14.147.439A1.5 1.5 0 0 0 13.086 0zM4 6a1 1 0 0 1-1-1V1h10v4a1 1 0 0 1-1 1zM3 9h10a1 1 0 0 1 1 1v5H2v-5a1 1 0 0 1 1-1" />
                </svg>
                Guardar
            </button>
        </div>
    </form>
    <div class=" ml-auto mr-2">
        <button id="generateButton"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                class="bi bi-key-fill mr-2" viewBox="0 0 16 16">
                <path
                    d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
            </svg>
            <span class="hidden md:inline">Generar Clave</span>
        </button>
    </div>
</div>
