<div class=""
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        search: @entangle('search'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    {{-- Cuerpo del listado de indice --}}
    <div class="w-full p-3 overflow-hidden bg-black">

        {{-- Esta fila es para controles, busqueda y comandos --}}
        <div class="flex flex-row justify-start mt-4">
            <h4 class="mt-1 ml-8 mr-4 text-lg font-normal text-white">
                Cuántos por Página:
            </h4>
            <select
                class="h-10 p-1 mb-4 text-xl font-bold text-black bg-gray-200 border-2 border-gray-700 rounded-md focus:border-orange-600"
                wire:model="deCuantos"
            >
                <option value="6">de 6 en 6</option>
                <option value="20">de 20 en 20</option>
                <option value="50">de 50 en 50</option>
                <option value="100">ver cientos</option>
            </select>
            <h4 class="mt-1 ml-16 mr-4 text-lg font-normal text-white">
                Buscar nombre:
            </h4>
            <input
                type="text"
                class="h-10 p-1 mb-4 text-xl font-bold text-black bg-gray-200 border-2 border-gray-700 rounded-md focus:border-orange-600"
                placeholder="cual buscas..."
                wire:model="search"
            >
            <button
                class="w-10 h-10 px-1 py-1 mt-0 ml-2 bg-gray-300 border-2 border-indigo-800 rounded-md hover:bg-red-500"
                wire:click="$emit('limpiar')"
            >
                <x-heroicon-o-arrow-left/>
            </button>
        </div>

        {{-- Aqi empieza la lista de registros mostrados --}}
        <div class="px-8 mt-8">

            @if (is_array($rengs) || is_object($rengs))

            @if (count($rengs) < 1)
                <div class="p-5">
                    <span class="text-5xl font-bold text-red-600 bg-black">
                        No hay registros ....
                    </span>
                </div>
            @else

                <table class="border-collapse table-fixed">

                    <thead class="h-12 text-white bg-gray-800 border-t-4 border-l-2 border-r-2 border-gray-500">

                        <tr class="text-left uppercase">

                            <th wire:click="clasifica('id')" class="text-yellow-500 w-1/12 pl-4 cursor-pointer">
                                id
                                @if ($sortear == 'id')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th class="w-1/12 pl-4">
                                Creadeor
                            </th>

                            <th class="w-1/12 pl-4">
                                Tipo
                            </th>

                            <th class="w-2/12 pl-4">
                                Origen
                            </th>

                            <th class="w-1/12 pl-4">
                                Clasif
                            </th>

                            <th wire:click="clasifica('nombre_full')" class="text-yellow-500 w-3/12 pl-4 cursor-pointer">
                                Nombre Contacto
                                @if ($sortear == 'nombre_full')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th class="w-1/12 pl-4">
                                Celular
                            </th>

                            <th class="w-1/12 pl-4">
                                Alta
                            </th>

                            <th class="w-1/12">
                                <span class="ml-10">Acciones</span>
                            </th>

                        </tr>

                    </thead>

                    <tbody class="text-white">
                        
                        @foreach ($rengs as $renglon)

                        @php
                            $ident = $renglon->owner_id;
                            $valor = DB::table('owners')->where("id", $ident)->first()->nombre_titular;
                            $cadena = str_ireplace(' ','',$valor);
                            $propiet = substr($cadena,0,9);
                            $categor = strtolower($renglon->clasificacion);
                        @endphp

                        <tr class="border-2 border-gray-500 text-gray-400">

                            <td class="px-4 py-2 text-yellow-500 ">&nbsp;{{ $renglon->id }}</td>

                            <td class="px-4 py-2">{{ $propiet }}</td>

                            <td class="px-4 py-2">{{ $renglon->clave_tipo }}</td>

                            <td class="px-4 py-2">{{ $renglon->clave_origen }}</td>

                            <td class="px-4 py-2 capitalize">{{ $categor }}</td>

                            <td class="px-4 py-2 text-yellow-700 ">{{ $renglon->nombre_full }}</td>

                            <td class="px-4 py-2">{{ $renglon->telefono_movil }}</td>

                            <td class="px-4 py-2">{{ $renglon->created_at->diffForHumans() }}</td>

                            <td class="px-4 py-2">

                                <div class="flex flex-row">

                                    <button
                                            class="px-2 py-1 mx-2 bg-gray-800 border-2 border-blue-800 rounded-md hover:bg-blue-500"
                                            wire:click="editar({{ $renglon }})"
                                    >
                                    <x-heroicon-o-pencil-alt class="w-8 h-8 text-gray-500" />
                                    </button>

                                    <button
                                            class="px-2 py-1 mx-2 bg-gray-800 border-2 border-red-800 rounded-md hover:bg-red-500"
                                            wire:click="$emit('confirmarDelete', {{ $renglon->id }})"
                                    >
                                    <x-heroicon-o-x class="w-8 h-8 text-red-400" />
                                    </button>

                                </div>
                                
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                {{-- Aqui se muestran los links de paginación y asi --}}
                <div class="inline-flex justify-between text-xl font-bold text-white bg-black md:w-full" style="padding: 20px 30px 20px 50px;">
                    <div class="w-2/3">{{ $rengs->links() }}</div>
                    <div class="mt-1 mr-8 text-gray-500">Registros:&nbsp;&nbsp;{{ $cantidad }}</div>
                </div>

            @endif

            @else

            <div class="p-5">
                <span class="text-5xl font-bold text-red-600 bg-black">
                    Promblema con Registros ....
                </span>
            </div>

            @endif

        </div>

    </div>


    {{-- pregunta antes de eliminar --}}
    <script>

        Livewire.on('confirmarDelete', (userId) => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-6 py-2 mx-4 text-black text-xl font-extrabold border-2 rounded-md border-red-700 bg-red-500 hover:bg-red-300',
                    cancelButton: 'px-3 py-2 mr-4 text-black text-xl font-extrabold border-2 rounded-md border-blue-700 bg-blue-500 hover:bg-blue-300'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                imageUrl: '{{ asset('logos/Warning.png') }}',
                imageHeight: 200,
                imageWidth: 200,
                imageAlt: 'Imagen del aviso',
                title: '¿ Seguro que quieres borrarlo ?',
                text: 'Ya no podras utilizar este registro!',
                width: 600,
                padding: '3em',
                color: '#000000',
                background: '#cccc00',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;Si, borralo!',
                cancelButtonText: '<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;No, mejor no!',
                reverseButtons: true,
                footer: 'conste que te avisamos...'
            }).then((result) => {
                if (result.value) {
                    Livewire.emitTo('directorios.contactos.index', 'delete', userId )
                } else {
                    Swal.fire('OK, el registro sigue existiendo...')
                }
            })

        })
    </script>

    {{-- mensaje de eliminado ok --}}
    <script>

        Livewire.on('deleteOk', () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Eliminado!',
                text: 'El contacto fué eliminado definitivamente.',
                icon: 'success',
                width: 600,
                padding: '3em',
                color: '#000000',
                background: '#00aa00',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })
        })

    </script>


</div>
