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
            <div class="flex justify-between items-center">
                <span class="text-sm font-light truncate mr-2">{{ $producto->nombre_comercial }}</span>
                <div>
                    @if ($producto->idColor == 1)
                        <div style="height:25px;width:25px;background-color:black;border-radius:50%;"></div>
                    @elseif ($producto->idColor == 2)
                        <div style="height:25px;width:25px;background-color:yellow;border-radius:50%;"></div>
                    @elseif ($producto->idColor == 3)
                        <div style="height:25px;width:25px;background-color:cyan;border-radius:50%;"></div>
                    @elseif ($producto->idColor == 4)
                        <div style="height:25px;width:25px;background-color:magenta;border-radius:50%;"></div>
                    @elseif ($producto->idColor == 5)
                        <div
                            style="background: linear-gradient(to right, cyan 33%, magenta 33%, magenta 66%, yellow 66%); border-radius: 50%; width: 50px; height: 50px;">
                        </div>
                    @elseif ($producto->idColor == 6)
                        <div
                            style="background: linear-gradient(to right, cyan 25%, magenta 25%, magenta 50%, yellow 50%, yellow 75%, black 75%); border-radius: 50%; width: 50px; height: 50px;">
                        </div>
                    @endif
                </div>
            </div>
            </span>
            <span class=" text-lg font-bold truncate">$ {{ $producto->precio }}</span>
            </p>
            <p class="flex justify-between">
                <span>Cantidad</span>
                <input type="hidden" name="producto_id[]" value="{{ $producto->id }}">
                <input type="number" class="suma form-input w-20 " name="cantidad[]" value="0">
                <i class="fas fa-minus"></i>
                <i class="fas fa-plus ml-0"></i>
            </p>

        </div>
    @endforeach
</section>
