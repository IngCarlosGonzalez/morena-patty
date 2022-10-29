<div class=""
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        search: @entangle('search'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    {{-- Componente: listado de INDEX de OWNERS o PROPIETARIOS DE RECURSOS--}}
    {{-- °°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°°--}}
    
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
            <button
                class="w-48 h-10 px-1 py-1 mt-0 ml-24 text-xl text-white bg-green-600 border-2 border-green-800 rounded-md text-bold hover:bg-green-400"
                wire:click="$emit('agregar')"
            >
                Agregar Nuevo
            </button>
        </div>

        {{-- Aqi empieza la lista de registros mostrados --}}
        <div class="px-8 mt-8">

            @if (!$acuales > 0)
                <div class="p-5">
                    <span class="text-5xl font-bold text-red-600 bg-black">
                        No hay registros ....
                    </span>
                </div>
            @else

                <table class="border-collapse table-fixed">

                    <thead class="h-12 text-white bg-gray-800 border-t-4 border-l-2 border-r-2 border-gray-500">

                        <tr class="text-left uppercase">

                            <th wire:click="clasifica('id')" class="w-1/12 pl-4 cursor-pointer">
                                Id
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

                            <th wire:click="clasifica('user_id')" class="w-2/12 pl-4 cursor-pointer">
                                Usuario
                                @if ($sortear == 'user_id')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th wire:click="clasifica('esta_vigente')" class="w-1/12 pl-4 cursor-pointer">
                                Activo
                            </th>

                            <th wire:click="clasifica('area_o_depto')" class="w-2/12 pl-4 cursor-pointer">
                                Area/Depto
                                @if ($sortear == 'area_o_depto')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th wire:click="clasifica('nombre_titular')" class="w-2/12 pl-4 cursor-pointer">
                                Nombre
                                @if ($sortear == 'nombre_titular')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th wire:click="clasifica('puesto_titular')" class="w-2/12 pl-4 cursor-pointer">
                                Puesto
                                @if ($sortear == 'puesto_titular')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th class="w-2/12">
                                <span class="ml-24">Acciones</span>
                            </th>

                        </tr>

                    </thead>

                    <tbody class="text-white">

                        @foreach ($acuales as $owner)

                        @php
                            $etiqueta = "";
                            $ident = $owner->user_id;
                            $valor = DB::table('users')->where("id", $ident)->first()->name;
                            $etiqueta = $ident . " - " . $valor;
                            $estatus = "";
                            if ($owner->esta_vigente == 1) {
                                $estatus = "-SI-";
                            } else {
                                $estatus = "-NO-";
                            }
                        @endphp

                        <tr class="border-2 border-gray-500">

                            <td class="px-4 py-2">&nbsp;{{ $owner->id }}</td>

                            <td class="px-4 py-2">{{ $etiqueta }}</td>

                            <td class="px-4 py-2">{{ $estatus }}</td>

                            <td class="px-4 py-2 break-all">{{ $owner->area_o_depto }}</td>

                            <td class="px-4 py-2 break-all">{{ $owner->nombre_titular }}</td>

                            <td class="px-4 py-2 break-all">{{ $owner->puesto_titular }}</td>

                            <td class="px-4 py-2">
                                <div class="flex flex-row">

                                    <button
                                            class="px-4 py-0 mx-4 bg-gray-800 border-2 border-blue-800 rounded-md hover:bg-blue-500"
                                            wire:click="editar({{ $owner }})"
                                    >
                                        EDITAR
                                    </button>

                                    <button
                                            class="px-4 py-0 mx-4 bg-gray-800 border-2 border-red-800 rounded-md hover:bg-red-500"
                                            wire:click="$emit('confirmarDelete', {{ $owner->id }})"
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

        {{-- Aqui se muestran los links de paginación y asi --}}
        <div class="inline-flex justify-between text-xl font-bold text-white bg-black md:w-full" style="padding: 20px 30px 20px 50px;">
            <div class="w-2/3">{{ $acuales->links() }}</div>
            <div class="mt-1 mr-8 text-gray-500">Registros:&nbsp;&nbsp;{{ $cantidad }}</div>
        </div>

    </div>


    {{-- DIALOG MODAL PARA CAPTURAR NUEVO y PROCESAR INSERT --}}
    <x-jet-dialog-modal wire:model="crear" id="modal_crear">

        <x-slot name="title">
            <div class="text-center">
                Datos del Nuevo Owner 
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white ">

                <div class="mt-2">

                    <form
                        class="flex flex-col items-center flex-1 p-1"
                        wire:submit.prevent="procesar"
                    >
                        <div class="mx-24 mt-4">

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el usuario registrado --}}
                                <label for="user_id" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Usuario Registrado:
                                </label>
                                <select
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 border-gray-300 rounded-md shadow-sm select2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    id="select2_user_id"
                                    name="user_id"
                                    wire:model.defer="user_id"
                                >
                                    <option value="0" class="text-orange-500">seleccionar...</option>
                                    @foreach ($libres as $opcion)
                                    <option value="{{ $opcion->ident }}">{{ $opcion->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('user_id'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('user_id') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el area o departamento --}}
                                <label for="area_o_depto" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Area o Depatamento:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="area_o_depto"
                                    name="area_o_depto"
                                    placeholder="area / deparatmento"
                                    wire:model.defer="area_o_depto"
                                >
                            </div>
                            @if($errors->has('area_o_depto'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('area_o_depto') }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el nombre del propietarrio --}}
                                <label for="nombre_titular" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Nombre del Titular:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="nombre_titular"
                                    name="nombre_titular"
                                    placeholder="nombre completo"
                                    wire:model.defer="nombre_titular"
                                >
                            </div>
                            @if($errors->has('nombre_titular'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('nombre_titular') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el puesto del titular --}}
                                <label for="puesto_titular" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Puesto del Titular:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="puesto_titular"
                                    id="puesto_titular"
                                    name="puesto_titular"
                                    placeholder="puesto titular"
                                    wire:model.defer="puesto_titular"
                                >
                            </div>
                            @if($errors->has('puesto_titular'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('puesto_titular') }}
                                </div>
                            @endif
        
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se indica la clave de estatus --}}
                                <div class="flex flex-row justify-center mb-4">
                                    <label for="esta_vigente" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                        Se encuentra Vigente ?
                                    </label>
                                    <input
                                        class="w-6 h-6 mt-1 bg-orange-600 border border-gray-500 rounded md:mr-8 focus:ring-orange-700 ring-offset-gray-800"
                                        type="checkbox"
                                        id="esta_vigente"
                                        name="esta_vigente"
                                        wire:model.defer="esta_vigente"
                                    >
                                </div>
                            </div>

                            {{-- Este es un honeypot rístico --}}
                            <div class="invisible">
                                <input
                                    type="checkbox"
                                    id="trampa"
                                    name="trampa"
                                    wire:model.defer="trampa"
                                >
                            </div>
        
                            <div class="flex flex-row justify-between">

                                <a href="#" wire:click="$set('crear', false)" class="w-48 px-12 py-2 text-lg font-bold text-black bg-orange-500 border-2 border-orange-700 hover:bg-orange-300">
                                    CERRAR
                                </a>
                
                                <a href="#" wire:click="procesar" class="w-48 px-8 py-2 ml-10 text-xl font-bold text-black bg-green-500 border-2 border-green-700 hover:bg-green-300">
                                    <span wire:loading wire:target="procesar" class="px-12 text-xl font-extrabold animate-spin">
                                        &#9696;
                                    </span>
                                    <span wire:loading.remove wire:target="procesar" class="text-xl">
                                        ALMACENAR
                                    </span>
                                </a>

                            </div>
        
                        </div>
        
                    </form>

                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="my-6 mr-6">

                <span class="w-full border-b-2 border-white">

                </span>

            </div>
        </x-slot>

    </x-jet-dialog-modal>


    {{-- DIALOG MODAL PARA EDITAR Y ACTUALIZAR UN REGISTRO --}}
    <x-jet-dialog-modal wire:model="abrir">

        <x-slot name="title">
            <div class="text-center">
                Editando el owner <span class="ml-4"> {{ $editando->nombre_titlar }} </span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white">

                <div class="mt-0">

                    <form
                        class="flex flex-col items-center flex-1 p-1"
                        wire:submit.prevent="procesar"
                    >
                        <div class="mx-24 mt-1">

                            <div class="flex flex-row md:items-center ">
                                {{-- Aquí sale el usuario registrado --}}
                                <span class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Usuario Registrado:
                                </span>
                                <span
                                    class="w-64 px-2 py-1 mb-4 mr-4 -mt-2 text-xl font-bold text-white placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                >
                                {{ $editando->user_id }}&nbsp;&nbsp;{{ $user_name }}
                                </span>
                            </div>

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el area o departamentor --}}
                                <label for="area_o_depto" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Area o Depatamento:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="area_o_depto"
                                    name="area_o_depto"
                                    placeholder="area / deparatmento"
                                    wire:model.defer="area_o_depto"
                                >
                            </div>
                            @if($errors->has('area_o_depto'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('area_o_depto') }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el nombre del propietarrio --}}
                                <label for="nombre_titular" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Nombre del Titular:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="nombre_titular"
                                    name="nombre_titular"
                                    placeholder="nombre completo"
                                    wire:model.defer="nombre_titular"
                                >
                            </div>
                            @if($errors->has('nombre_titular'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('nombre_titular') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el puesto del titular --}}
                                <label for="puesto_titular" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Puesto del Titular:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="puesto_titular"
                                    id="puesto_titular"
                                    name="puesto_titular"
                                    placeholder="puesto titular"
                                    wire:model.defer="puesto_titular"
                                >
                            </div>
                            @if($errors->has('puesto_titular'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('puesto_titular') }}
                                </div>
                            @endif
        
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se indica la clave de estatus --}}
                                <div class="flex flex-row justify-center mb-4">
                                    <label for="esta_vigente" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                        Se encuentra Vigente ?
                                    </label>
                                    <input
                                        class="w-6 h-6 mt-1 bg-orange-600 border border-gray-500 rounded md:mr-8 focus:ring-orange-700 ring-offset-gray-800"
                                        type="checkbox"
                                        id="esta_vigente"
                                        name="esta_vigente"
                                        wire:model.defer="esta_vigente"
                                    >
                                </div>
                            </div>

                            {{-- Este es un honeypot rístico --}}
                            <div class="invisible">
                                <input
                                    type="checkbox"
                                    id="trampa"
                                    name="trampa"
                                    wire:model="trampa"
                                >
                            </div>
        
                            <div class="flex flex-row justify-between">

                                <a href="#" wire:click="$set('abrir', false)" class="w-48 px-12 py-2 text-lg font-bold text-black bg-orange-500 border-2 border-orange-700 hover:bg-orange-300">
                                    CERRAR
                                </a>
                
                                <a href="#" wire:click="cambios" class="w-48 px-8 py-2 ml-10 text-xl font-bold text-black bg-green-500 border-2 border-green-700 hover:bg-green-300">
                                    <span wire:loading wire:target="cambios" class="px-12 text-xl font-extrabold animate-spin">
                                        &#9696;
                                    </span>
                                    <span wire:loading.remove wire:target="cambios" class="text-xl text-center">
                                        ACTUALIZAR
                                    </span>
                                </a>

                            </div>
        
                        </div>
        
                    </form>

                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="my-6 mr-6">

                <span class="w-full border-b-2 border-white">

                </span>

            </div>
        </x-slot>

    </x-jet-dialog-modal>

        
    {{-- aqui se llama al Select2 de modal_crear --}}
    <script>
        document.addEventListener('livewire:load', function(){
            $('#select2_user_id').select2({
                dropdownParent: $('#modal_crear')
            });
            // console.log('°°°°°°°°°°°° select2');
            $('#select2_user_id').on('change', function(){
                console.log('seleccionado: ', this.value);
            });
        });
    </script>

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
                text: 'El Owner fué Agregado Correctamente.',
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
                    Livewire.emitTo('catalogos.owners.index', 'delete', propiet )
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
                background: '#008000',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })
        })

    </script>

</div>
