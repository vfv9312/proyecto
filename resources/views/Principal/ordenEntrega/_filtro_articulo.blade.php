<section>
    <section class="flex justify-center items-center">
        <div class=" mr-6">
            <label for="marca">Marca</label>
            <select class="" id="marca" name="marca">
                <option value="">Buscar por marca</option> <!-- Opción vacía -->
                @foreach ($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <label for="tipo">Tipo</label>
            <select class="" id="tipo" name="tipo">
                <option value="">Buscar por tipo</option> <!-- Opción vacía -->
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
    </section>

</section>
