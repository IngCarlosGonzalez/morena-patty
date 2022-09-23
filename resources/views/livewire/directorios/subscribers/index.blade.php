<div class=""
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        search: @entangle('search'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    <div class="p-3 bg-black w-full overflow-hidden">

        {{-- Esta fila e para controles, busqueda y comandos --}}
        <div class="flex flex-row justify-start mb-0">
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
                <option value="1000">ver por miles</option>
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
                class="border-2 ml-2 mt-0 px-1 w-10 h-10 py-1 border-indigo-800 rounded-md bg-gray-300 hover:bg-red-500"
                wire:click="$emit('limpiar')"
            >
                <x-heroicon-o-arrow-left/>
            </button>
            <button
                class="ml-36 text-bold text-xl text-white border-2 mt-0 px-1 w-48 h-10 py-1 border-red-800 rounded-md bg-red-600 hover:bg-red-400"
                wire:click="$emit('confirmarBulk')"
            >
                Eliminar Marcados
            </button>
        </div>

        {{-- Esta fila es para flash, filtros y select all --}}
        <div class="flex flex-row justify-end mb-4">
            @if ( flash()->message )
                <div class="{{ flash()->class }}">
                    {{ flash()->message }}
                </div>
            @endif
            <span class="mr-4 text-md text-gray-500">Ocultar Convertidos</span>
            <input
            class="w-6 h-6 mr-40 border rounded bg-orange-600 border-gray-500 focus:ring-orange-700 ring-offset-gray-800"
            wire:model="ocultar" type="checkbox" name="ocultar" id="ocultar"
            >
            <span class="mr-4 text-md text-gray-500">Seleccionar Todos</span>
            <input
            class="w-6 h-6 mr-16 border rounded bg-orange-600 border-gray-500 focus:ring-orange-700 ring-offset-gray-800"
            wire:model="todos" type="checkbox" name="todos" id="todos"
            >
        </div>

        {{-- Aqi empieza la lista de registros mostrados --}}
        <div class="px-8">

            @if ($subscribers->isEmpty())
                <div class="p-5">
                    <span class="text-red-600 bg-black texl-5xl font-bold">
                        No hay registros ....
                    </span>
                </div>
            @else

                <table class="border-collapse table-fixed">

                    <thead class="text-white bg-gray-800 h-12 border-t-4 border-l-2 border-r-2 border-gray-500">

                        <tr class="text-left uppercase">

                            <th wire:click="clasifica('nombre_full')" class="cursor-pointer w-3/12 pl-4">
                                Nombre
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

                            <th wire:click="clasifica('telefono_movil')" class="cursor-pointer w-1/12 pl-4">
                                Móvil
                                @if ($sortear == 'telefono_movil')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th class="w-1/12 ">
                                WatsApp
                            </th>

                            <th class="w-3/12 pl-4">
                                Ubicación
                            </th>

                            <th class="w-1/12 pl-4">
                                Alta
                            </th>

                            <th class="w-1/12 ">
                                Contacto
                            </th>

                            <th class="w-2/12">
                                <span class="ml-20">Acciones</span>
                                <span class="ml-20">sel</span>
                            </th>

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

                                    {{-- <a href="{{ route('directorios.subscribers.show', $subscriber->id) }}" class="border-2 px-2 py-0 border-blue-800 rounded-md bg-gray-800 hover:bg-blue-500">CHECAR</a> --}}

                                    <button
                                            class="border-2 mx-2 px-2 py-0 border-green-800 rounded-md bg-gray-800 hover:bg-green-500"
                                            wire:click="editar({{ $subscriber }})"
                                    >
                                        CHECAR
                                    </button>

                                    <button
                                            class="border-2 mx-2 px-2 py-0 border-red-800 rounded-md bg-gray-800 hover:bg-red-500"
                                            wire:click="$emit('confirmarDelete', {{ $subscriber->id }})"
                                    >
                                        BORRAR
                                    </button>

                                    <div class="ml-4 mr-2 rounded-full bg-orange-800 hover:bg-orange-600 border border-gray-200">
                                        <input
                                            wire:model.defer="itemsMarcados"
                                            id="itemsMarcados"
                                            name="itemsMarcados"
                                            type="checkbox"
                                            value="{{ $subscriber->id }}"
                                            class="casillas w-6 h-6 px-12 py-8 mt-1 mx-2 cursor-pointer border rounded bg-orange-800 border-gray-500 focus:ring-orange-700 ring-offset-gray-800 hover:bg-red-800"
                                        >
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

        {{-- Aqui se muestran los lonks de paginación y asi --}}
        <div class="bg-black inline-flex justify-between md:w-full font-bold text-xl text-white" style="padding: 20px 30px 20px 50px;">
            <div class="w-2/3">{{ $subscribers->links() }}</div>
            <div class="mr-8 mt-1 text-gray-500">Registros:&nbsp;&nbsp;{{ $cantidad }}</div>
        </div>

    </div>

    {{-- DIALOG MODAL PARA CHECAR y PROCESAR --}}
    <x-jet-dialog-modal wire:model="abrir">

        <x-slot name="title">
            <div class="text-center">
                Datos del Prospecto <span class="ml-4">{{ $editando->id }}</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white">

                <div class="mt-2">

                    <div class="flex flex-col md:flex-row md:items-center border-t-4 border-gray-600">
                        <span class="text-left w-24 mt-6 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Nombre:
                        </span>
                        <span class="text-left w-full mt-6 ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->nombre_full }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Teléfono:
                        </span>
                        <span class="text-left w-32 ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->telefono_movil }}
                        </span>
                        <span class="text-right w-48 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Con watsapp?
                        </span>
                        @if ($editando->tiene_watsapp == 1)
                        <span class="text-left w-48 md:mr-4 md:ml-4 md:mb-4 font-normal text-base leading-none text-gray-300">
                            <x-heroicon-o-check class="w-8 text-bold h-8 text-bold text-green-600"></x-heroicon-o-check>
                        </span>
                        @else
                        <span class="text-left w-48 md:mr-4 md:ml-4 md:mb-4 font-normal text-base leading-none text-gray-300">
                            <x-heroicon-o-x class="w-8 text-bold h-8 text-bold text-red-600"></x-heroicon-o-x>
                        </span>
                        @endif
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Colonia:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->colonia_o_sector }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Municipio:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->localidad_municipio }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Entidad:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->entidad_federativa }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Correo:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->correo_electronico }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center border-b-4 border-gray-600">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Mensaje:
                        </span>
                        <span class="break-all text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $editando->texto_del_mensaje }}
                        </span>
                    </div>

                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="my-6 mr-6">
                <a href="#" wire:click="$set('abrir', false)" class="px-12 py-2 text-black font-bold text-lg border-2 border-orange-700 bg-orange-500 hover:bg-orange-300">
                    CERRAR
                </a>
                @if ($editando->aso_a_contacto == 0)
                <a href="#" wire:click="procesar({{ $editando }})" class="ml-6 px-8 py-2 text-black font-bold text-xl border-2 border-green-700 bg-green-500 hover:bg-green-300">
                    <span wire:loading wire:target="procesar" class="px-12 animate-spin font-extrabold text-xl">
                        &#9696;
                    </span>
                    <span wire:loading.remove wire:target="procesar" class="text-xl">
                        CONVERTIR
                    </span>
                </a>
                @else
                    <span class="cursor-not-allowed ml-6 px-8 py-2 text-black font-bold text-xl border-2 border-green-700 bg-green-500 hover:bg-green-300">Ya Convertido</span>
                @endif
            </div>
        </x-slot>

    </x-jet-dialog-modal>

    {{-- mensaje de procesado ok --}}
    <script>

        Livewire.on('procesaOk', () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Procesado!',
                text: 'El Prospecto fué Cvonvertido en Contacto.',
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

    {{-- pregunta antes de eliminar --}}
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
                background: '#cccc00',
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
                text: 'El registro fué eliminado definitivamente.',
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

    {{-- aqui se desmarcan todos --}}
    <script>

        Livewire.on('desmarcar', () => {

            miscasillas=document.getElementsByClassName('casillas');

            for(i=0;i<miscasillas.length;i++)
            {
                if(miscasillas[i].type == "checkbox")
                {
                    miscasillas[i].checked=0;
                }
            }

        })

    </script>

    {{-- aqui se marcan todos --}}
    <script>

        Livewire.on('marcarall', () => {

            miscasillas=document.getElementsByClassName('casillas');

            for(i=0;i<miscasillas.length;i++)
            {
                if(miscasillas[i].type == "checkbox")
                {
                    miscasillas[i].checked=1;
                }
            }

        })

    </script>

    {{-- mensaje de bulk action ok --}}
    <script>

        Livewire.on('bulkOk', () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Completado!',
                text: 'El proceso de Eliminación se terminó OK.',
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

    {{-- mensaje de no se pudo bulk action --}}
    <script>

        Livewire.on('bulkNope', () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'No se Hizo!',
                text: 'El proceso global no fué realizado.',
                icon: 'error',
                width: 600,
                padding: '3em',
                color: '#ffffff',
                background: '#aa0000',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })

        })

    </script>

    {{-- pregunta si confirma la ejecución del bulk --}}
    <script>

        Livewire.on('confirmarBulk', () => {

            // console.log('>>>>> Entra a pregunta por Bulk...');

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
                title: '¿ Seguro que quieres continuar ?',
                text: 'La eliminación global no tiene reversa!',
                width: 600,
                padding: '3em',
                color: '#000000',
                background: '#cccc00',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: '<i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;Si, Ejecutar!',
                cancelButtonText: '<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;No, mejor no!',
                reverseButtons: true,
                footer: 'conste que te avisamos...'
            }).then((result) => {
                if (result.value) {
                    Livewire.emitTo('directorios.subscribers.index', 'ejecutaBulk' )
                } else {
                    Swal.fire('OK, el proceso global no se ejecutó...')
                }
            })

        })
    </script>

    {{-- para marcar/desmarcar todos --}}
    <script>
        function MarcarTodos(casilla)
        {
            miscasillas=document.getElementsByClassName('casillas'); //Rescatamos controles clase Casillas
            for(i=0;i<miscasillas.length;i++) //Ejecutamos y recorremos los controles
            {
                if(miscasillas[i].type == "checkbox") // Ejecutamos si es una casilla de verificacion
                {
                    miscasillas[i].checked=casilla.checked; // Si el input es CheckBox se aplica la funcion ActivarCasilla
                }
            }
        }
    </script>


    {{-- mensaje de editado ok --}}
    <script>

        Livewire.on('editadoOk', () => {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Actualizado!',
                text: 'El registro fué editado y almacenado.',
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
