   <!--tabla-->
   <section class="overflow-x-auto">
       <!--La clase overflow-x-auto hace que el div tenga un desplazamiento horizontal si su contenido es demasiado ancho para caber en la pantalla-->
       <table class="min-w-full">
           <!--La clase min-w-full hace que la tabla tenga al menos el ancho completo de su contenedor, lo que significa que se desplazará horizontalmente si es necesario.-->
           <tr class="text-black uppercase text-xs  font-bold leading-normal">
               <td class="py-3 px-6 text-left border-r">ID</td>
               <td class="py-3 px-6 text-left border-r">Usuario</td>
               <td class="py-3 px-6 text-left border-r">Clave</td>
               <td class="py-3 px-6 text-left border-r">Fecha y hora de creacion</td>
               <td class="py-3 px-6 text-left border-r">Fecha y hora de expiración</td>

           </tr>
           @foreach ($claves as $clave)
               <tr class=" border-b border-gray-200 text-sm">
                   <td class=" px-6 py-4">
                       {{ $clave->id }}
                   </td>
                   <td class=" px-6 py-4">
                       {{ $clave->creado_por }}
                   </td>
                   <td class="px-6 py-4">
                       <input id="clave{{ $clave->id }}" type="password" value="{{ $clave->clave }}" readonly>
                       <i id="toggleClave{{ $clave->id }}" class="fa fa-eye"></i>
                   </td>
                   <td class="px-6 py-4">
                       {{ $clave->created_at }}
                   </td>
                   <td class="px-6 py-4">
                       {{ $clave->deleted_at }}
                   </td>

               </tr>
               <!-- Aquí deberías mostrar otros datos del producto -->
           @endforeach
       </table>
       <div class=" mt-3">
           <p>Total de resultados: {{ $claves->total() }}</p> <!--mostrar total de resultados-->
           {{ $claves->links() }} <!-- Esto mostrará los enlaces de paginación -->
       </div>
   </section>
