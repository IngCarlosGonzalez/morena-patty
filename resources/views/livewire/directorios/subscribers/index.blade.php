<div class=""
    x-data="{
        quiereBorrar: @entangle('quiereBorrar'),
        aCualId: @entangle('aCualId'),
        deleteOk: @entangle('deleteOk'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    <div class="p-3 bg-black">

        <div class="flex flex-row justify-start mb-2">
            <h4 class="text-white text-lg font-normal ml-8 mt-2 mr-4">
                Buscar nombre:
            </h4>
            <input
                type="text"
                class="font-bold text-2xl p-1 border-2 border-gray-700 focus:border-orange-600 rounded-md bg-gray-200 text-black mb-4"
                placeholder="cual buscas..."
                wire:model="search"
            >
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
                    <thead class="text-black bg-gray-400 border-t-4 border-l-2 border-r-2 border-gray-700">
                        <tr class="table-row">
                            <th class=""><h4>Nombre Completo</h4></th>
                            <th class=""><h4>Teléfono</h4></th>
                            <th class=""><h4>Wats</h4></th>
                            <th class=""><h4>Ubicación</h4></th>
                            <th class=""><h4>Registrado</h4></th>
                            <th class=""><h4>Acciones</h4></th>
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
                        @endphp
                        <tr class="table-row border-2 border-gray-500">
                            <td class="table-cell py-2 px-4">{{ $subscriber->nombre_full }}</td>
                            <td class="table-cell py-2 px-4">{{ $subscriber->telefono_movil }}</td>
                            <td class="table-cell py-2 px-4">{{ $subscriber->tiene_watsapp }}</td>
                            <td class="table-cell py-2 px-4">{{ $ubicacion }}</td>
                            <td class="table-cell py-2 px-4">{{ $subscriber->created_at->diffForHumans() }}</td>
                            <td class="table-cell py-2 px-4">
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

        <div class="bg-black md:w-2/3 font-bold text-2xl text-white" style="padding: 20px 30px 20px 50px;">
            {{ $subscribers->links() }}
        </div>

    </div>

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
