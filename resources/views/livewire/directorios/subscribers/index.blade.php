<div class="">
    <div class="p-3 bg-black">
        <div class="d-inline-flex align-items-start mb-2">
            <h4 class="text-white mr-4">
                Buscar uno
            </h4>
            <x-jet-input
                type="text"
                class="border text-black"
                placeholder="cual buscas..."
                wire:model="search"
            >
            </x-jet-input>
        </div>
        <div class="px-8">
            @if ($subscribers->isEmpty())
                <div class="p-5">
                    <h1 class="text-danger">
                        No hay Prospectos aún.
                    </h1>
                </div>
            @else
                <table class="table table-borderless table-dark table-sm table-hover">
                    <thead class="text-orange-700 bg-black">
                        <tr>
                            <th><h4>Nombre Completo</h4></th>
                            <th><h4>Teléfono</h4></th>
                            <th><h4>Wats</h4></th>
                            <th><h4>Colonia/Sector</h4></th>
                            <th><h4>Localidad/Municipio</h4></th>
                            <th><h4>Entidad</h4></th>
                            <th><h4>Registrado</h4></th>
                            <th>---Acciones---</th>
                        </tr>
                    </thead>
                    <tbody class="text-white">
                        @foreach ($subscribers as $subscriber)
                        <tr class="border">
                            <td class="py-2 px-4">{{ $subscriber->nombre_full }}</td>
                            <td class="py-2 px-4">{{ $subscriber->telefono_movil }}</td>
                            <td class="py-2 px-4">{{ $subscriber->tiene_watsapp }}</td>
                            <td class="py-2 px-4">{{ $subscriber->colonia_o_sector }}</td>
                            <td class="py-2 px-4">{{ $subscriber->localidad_municipio }}</td>
                            <td class="py-2 px-4">{{ $subscriber->entidad_federativa }}</td>
                            <td class="py-2 px-4">{{ $subscriber->created_at->diffForHumans() }}</td>
                            <td class="py-2 px-4 ">
                                <x-jet-button
                                        class="btn btn-danger btn-sm "
                                        wire:click="$emit('confirmarDelete', {{ $subscriber->id }})"
                                >
                                    ELIMINAR
                                </x-jet-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="bg-black md:w-2/3" style="padding: 20px 30px 20px 50px;">
            <h4 class="font-weight-bolder text-white">{{ $subscribers->links() }}</h4>
        </div>
    </div>

    <script> console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>> lista de prospectos'); </script>

    <script>

        Livewire.on('confirmarDelete', (suscriberId) => {

            console.log('Se va eliminar el id: ' + suscriberId );

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger mx-4'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                imageUrl: '{{ asset('logos/Warning.png') }}',
                imageHeight: 200,
                imageWidth: 200,
                imageAlt: 'Imagen del avisao',
                title: '¿ Seguro que quieres borrarlo ?',
                text: 'Ya no podras utilizar este registro!',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;Si, borralo!',
                cancelButtonText: '<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;No, mejor no!',
                reverseButtons: true,
                footer: 'conste que te avisamos...'
            }).then((result) => {
                if (result.value) {
                    console.log('----- VALUE = VERDADERO -----')
                    console.log('----- dijo que SI lo borre -----')
                    Livewire.emitTo('subscribers', 'delete', suscriberId )
                    console.log('---> se manddo evento a controlador...')
                } else {
                    console.log('----- VALUE = FALSE -----')
                    console.log('----- dijo que mejor NO -----')
                    Swal.fire('OK, el registro sigue existiendo...')
                }
            })

        })
    </script>

    <script>
        Livewire.on('deleteOk', () => {
            console.log('---- Delete Definitivo OK ----');
            Swal.fire(
                'Registro Eliminado OK',
                'El registro fué eliminado definitivamente.',
                'success'
            )
        })
    </script>

</div>
