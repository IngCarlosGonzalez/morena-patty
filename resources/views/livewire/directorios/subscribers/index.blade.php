<div class=""
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        deleteOk: @entangle('deleteOk'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    <div class="p-3 bg-black w-full overflow-hidden">

        <div class="flex flex-row justify-start mb-2">
            <h4 class="text-white text-lg font-normal ml-8 mt-1 mr-4">
                Cuántos por Página:
            </h4>
            <select
                class="h-10 font-bold text-xl p-1 border-2 border-gray-700 focus:border-orange-600 rounded-md bg-gray-200 text-black mb-4"
                wire:model="deCuantos"
            >
                <option value="6">de 6 en 6</option>
                <option value="20">de 20 en 20</option>
                <option value="50">de 50 en 50</option>
                <option value="1000">verlos todos</option>
            </select>
            <h4 class="text-white text-lg font-normal ml-16 mt-1 mr-4">
                Buscar nombre:
            </h4>
            <input
                type="text"
                class="h-10 font-bold text-xl p-1 border-2 border-gray-700 focus:border-orange-600 rounded-md bg-gray-200 text-black mb-4"
                placeholder="cual buscas..."
                wire:model="search"
            >
            <button
                class="border-2 ml-2 mt-1.5 px-1 w-8 h-8 py-1 border-indigo-800 rounded-md bg-gray-300 hover:bg-red-500"
                wire:click="$emit('limpiaBuscador')"
            >
                <x-heroicon-o-arrow-left/>
            </button>
        </div>

        <div class="px-8">
            @if ($subscribers->isEmpty())
                <div class="p-5">
                    <h1 class="text-red-800 bg-black texl-3xl font-bold">
                        No hay registros ....
                    </h1>
                </div>
            @else
                <table class="border-collapse table-fixed">
                    <thead class="text-white bg-gray-800 h-12 border-t-4 border-l-2 border-r-2 border-gray-500">
                        <tr class="text-left uppercase">
                            <th class="w-3/12 pl-4">Nombre Completo</th>
                            <th class="w-1/12 pl-4">Teléfono</th>
                            <th class="w-1/12 ">WatsApp</th>
                            <th class="w-3/12 pl-4">Ubicación</th>
                            <th class="w-1/12 pl-4">Alta</th>
                            <th class="w-1/12 ">Contacto</th>
                            <th class="w-2/12 pl-16">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @foreach ($subscribers as $subscriber)
                        @php
                            $ubicacion = "";
                            if (! is_null($subscriber->colonia_o_sector) ) {
                                if (! empty($subscriber->colonia_o_sector) ) {
                                    $ubicacion = $subscriber->colonia_o_sector;
                                }
                            }
                            if (! is_null($subscriber->localidad_municipio) ) {
                                if (! empty($subscriber->localidad_municipio) ) {
                                    $ubicacion = $ubicacion . " " . $subscriber->localidad_municipio;
                                }
                            }
                            if (! is_null($subscriber->entidad_federativa) ) {
                                if (! empty($subscriber->entidad_federativa) ) {
                                    $ubicacion = $ubicacion . " " . $subscriber->entidad_federativa;
                                }
                            }
                            $ubicacion = trim($ubicacion);
                            $conwatsap = 0;
                            if ($subscriber->tiene_watsapp == 1) {
                                $conwatsap = 1;
                            }
                            $convertido = 0;
                            if ($subscriber->paso_a_contacto == 1) {
                                $convertido = 1;
                            }
                        @endphp
                        <tr class="border-2 border-gray-500">

                            <td class="py-2 px-4 break-all tracking-tighter">{{ $subscriber->nombre_full }}</td>

                            <td class="py-2 px-4">{{ $subscriber->telefono_movil }}</td>

                            @if ($conwatsap == 1)
                                <td class="py-0 pl-6">
                                    <x-heroicon-o-check-circle class="w-8 h-8"/>
                                </td>
                            @else
                                <td class="py-0 pl-6">
                                    <x-heroicon-o-x class="w-8 h-8"/>
                                </td>
                            @endif

                            <td class="py-2 px-4 break-all tracking-tighter">{{ $ubicacion }}</td>

                            <td class="py-2 px-4">{{ $subscriber->created_at->diffForHumans() }}</td>

                            @if ($convertido == 1)
                                <td class="py-0 pl-6">
                                    <x-heroicon-o-user-add class="w-8 h-8"/>
                                </td>
                            @else
                                <td class="py-0 pl-6">
                                    <x-heroicon-o-x class="w-8 h-8 text-red-400" />
                                </td>
                            @endif

                            <td class="py-2 px-4">
                                <div class="flex flew-row">
                                    <button
                                            class="border-2 px-2 py-0 border-blue-800 rounded-md bg-gray-800 hover:bg-blue-500"
                                            wire:click="$emit('checarDatos', {{ $subscriber->id }})"
                                    >
                                        CHECAR
                                    </button>
                                    <button
                                            class="border-2 mx-2 px-2 py-0 border-red-800 rounded-md bg-gray-800 hover:bg-red-500"
                                            wire:click="$emit('confirmarDelete', {{ $subscriber->id }})"
                                    >
                                        BORRAR
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="bg-black inline-flex justify-between md:w-full font-bold text-xl text-white" style="padding: 20px 30px 20px 50px;">
            <div class="w-2/3">{{ $subscribers->links() }}</div>
            <div class="mr-8 mt-1 text-gray-500">Registros:&nbsp;&nbsp;{{ $cantidad }}</div>
        </div>

    </div>

    <script>

        Livewire.on('limpiaBuscador', () => {
            Livewire.emitTo('directorios.subscribers.index', 'limpiar')
        })

    </script>

    <script>

        Livewire.on('confirmarDelete', (suscriberId) => {

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
                background: '#bbbbbb',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;Si, borralo!',
                cancelButtonText: '<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;No, mejor no!',
                reverseButtons: true,
                footer: 'conste que te avisamos...'
            }).then((result) => {
                if (result.value) {
                    Livewire.emitTo('directorios.subscribers.index', 'delete', suscriberId )
                } else {
                    Swal.fire('OK, el registro sigue existiendo...')
                }
            })

        })
    </script>

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
                text: 'El registro fué eliminado definitivamente.',
                icon: 'success',
                width: 600,
                padding: '3em',
                color: '#ffffff',
                background: '#800000',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })
        })

    </script>

</div>
