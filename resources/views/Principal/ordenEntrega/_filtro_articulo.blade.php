<section id="filters-section" style="display: none;">

    <section class="flex justify-center items-cente">
        <div class=" mr-6">
            <label for="tipo">Tipo</label>
            <select class="" id="modo" name="modo">
                <option value="">Buscar por tipo</option> <!-- Opción vacía -->
                @foreach ($modos as $modo)
                    <option value="{{ $modo->id }}">{{ $modo->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class=" mr-6">
            <label for="color">Color</label>
            <select class="" id="color" name="color">
                <option value="">Buscar por color</option> <!-- Opción vacía -->
                @foreach ($colores as $color)
                    <option value="{{ $color->id }}">{{ $color->nombre }}</option>
                @endforeach
            </select>
        </div>
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
            <label for="tipo">Categoria</label>
            <select class="" id="tipo" name="tipo">
                <option value="">Buscar por categoria</option> <!-- Opción vacía -->
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
    </section>

</section>
