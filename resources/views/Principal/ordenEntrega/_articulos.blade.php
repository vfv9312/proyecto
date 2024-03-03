<section class="flex flex-wrap">
    @foreach ($productos as $producto)
        <div class="producto m-3 pb-10 bg-white cursor-pointer w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 h-72 border rounded-lg hover:shadow-lg hover:bg-black hover:bg-opacity-30"
            data-nombre="{{ $producto->nombre_comercial }}" data-marca="{{ $producto->marca_id }}"
            data-tipo="{{ $producto->tipo_id }}">
            <figure class=" relative mb-3 w-full h-4/5">
                <span
                    class=" absolute bottom-0 left-0  bg-green-500 rounded-lg text-sm m-2">{{ $producto->marca }}</span>
                <img class=" w-full h-full object-cover rounded-lg" src="{{ $producto->fotografia }}" alt="producto" />
                <div
                    class=" absolute top-0 right-0 flex justify-center items-center bg-green-600 w-6 h-6 rounded-full m-2">
                    <i class="fas fa-info-circle"></i>
                </div>
            </figure>

            <p class=" flex flex-col">
                <span class=" text-sm font-light truncate">{{ $producto->nombre_comercial }}</span>
                <span class=" text-lg font-bold truncate">$ {{ $producto->precio }}</span>
            </p>
            <p class="flex justify-between">
                <span>Cantidad</span>
                <input type="hidden" name="producto_id[]" value="{{ $producto->id }}">
                <input type="number" class="suma form-input w-20 mr-4" name="cantidad[]" value="0">
            </p>

        </div>
    @endforeach
</section>
