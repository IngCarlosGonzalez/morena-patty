<div class=""
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        search: @entangle('search'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

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

            @if (!$users > 0)
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

                            <th wire:click="clasifica('name')" class="w-3/12 pl-4 cursor-pointer">
                                Nombre Usuario
                                @if ($sortear == 'name')
                                    @if ($elOrden == 'asc')
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @else
                                        <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                    @endif
                                @else
                                    <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                @endif
                            </th>

                            <th class="w-3/12 pl-4">
                                Correo Electrónico
                            </th>

                            <th class="w-2/12 pl-4">
                                Alta
                            </th>

                            <th class="w-1/12 pl-4">
                                Role
                            </th>

                            <th class="w-2/12">
                                <span class="ml-24">Acciones</span>
                            </th>

                        </tr>

                    </thead>

                    <tbody class="text-white">

                        @foreach ($users as $usuario)
                        @php
                            $privilegio = "";
                            $privilegio = $usuario->roles()->first()->name;
                            if (is_null($privilegio) ) {
                                $privilegio = "";
                            }
                            if ($privilegio == 'superusuario') {
                                $privilegio = "ADMIN";
                            } else {
                                $privilegio = "Normal";
                            }
                        @endphp
                        <tr class="border-2 border-gray-500">

                            <td class="px-4 py-2">&nbsp;{{ $usuario->id }}</td>

                            <td class="px-4 py-2 tracking-tighter break-all">{{ $usuario->name }}</td>

                            <td class="px-4 py-2 tracking-tighter break-all">{{ $usuario->email }}</td>

                            <td class="px-4 py-2 tracking-tighter break-all">{{ $usuario->created_at->diffForHumans() }}</td>

                            <td class="px-4 py-2">{{ $privilegio }}</td>

                            <td class="px-4 py-2">
                                <div class="flex flex-row">

                                    <button
                                            class="px-4 py-0 mx-4 bg-gray-800 border-2 border-blue-800 rounded-md hover:bg-blue-500"
                                            wire:click="editar({{ $usuario }})"
                                    >
                                        EDITAR
                                    </button>

                                    <button
                                            class="px-4 py-0 mx-4 bg-gray-800 border-2 border-red-800 rounded-md hover:bg-red-500"
                                            wire:click="$emit('confirmarDelete', {{ $usuario->id }})"
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
            <div class="w-2/3">{{ $users->links() }}</div>
            <div class="mt-1 mr-8 text-gray-500">Registros:&nbsp;&nbsp;{{ $cantidad }}</div>
        </div>

    </div>


    {{-- DIALOG MODAL PARA CAPTURAR NUEVO y PROCESAR INSERT --}}
    <x-jet-dialog-modal wire:model="crear">

        <x-slot name="title">
            <div class="text-center">
                Datos del Nuevo Usuario 
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
                                {{-- Aquí entra el nombre del usuario --}}
                                <label for="name" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Nombre:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="nombre del usuario"
                                    wire:model.defer="name"
                                >
                            </div>
                            @if($errors->has('name'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra la password del usuario --}}
                                <label for="password" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Password:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="password"
                                    name="password"
                                    placeholder="la password"
                                    wire:model.defer="password"
                                >
                            </div>
                            @if($errors->has('password'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el correo electrónico del prospecto --}}
                                <label for="email" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Correo:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 lowercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="ejemplo_correo@servidor.com"
                                    wire:model.defer="email"
                                >
                            </div>
                            @if($errors->has('email'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
        
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se indica la clave de role --}}
                                <div class="flex flex-row justify-center mb-6">
                                    <label for="clave_role" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                        Es un SuperUsuario ?
                                    </label>
                                    <input
                                        class="w-6 h-6 mt-1 bg-orange-600 border border-gray-500 rounded md:mr-8 focus:ring-orange-700 ring-offset-gray-800"
                                        type="checkbox"
                                        id="clave_role"
                                        name="clave_role"
                                        wire:model.defer="clave_role"
                                    >
                                </div>
                            </div>
        
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se carga la imagen "avatar" del usuario --}}
                                <div class="flex flex-row justify-center mb-6">
                                    <input
                                        class="text-xl font-bold"
                                        type="file"
                                        id="numerin"
                                        wire:model="imagen"
                                    >
                                </div>
                            </div>
                            @if($errors->has('imagen'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('imagen') }}
                                </div>
                            @endif
                            
                            <div wire:loading wire:target="imagen">
                                <div class="relative items-center w-full px-5 py-12 mx-auto md:px-12 lg:px-24 max-w-7xl">
                                    <div class="p-6 border-l-4 border-yellow-600 rounded-r-xl bg-yellow-50">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <h3 class="text-2xl font-bold text-yellow-800">Cargando la imagen...</h3>
                                                <div class="mt-2 text-xl text-yellow-600">
                                                    <p> Espere un momento en lo que se carga la imagen seleccionada </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div wire:loading.remove wire:target="imagen">
                                @if ($imagen)
                                    <div class="flex flex-row justify-center">
                                        <img class="w-48 h-64" src="{{ $imagen->temporaryUrl() }}">
                                    </div>
                                @else
                                    <div class="flex flex-row justify-center">
                                        <x-heroicon-o-user-add class="w-32 h-48"/>
                                    </div>
                                @endif
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
                                    <span wire:loading.remove wire:target="procesar, imagen" class="text-xl">
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

    {{-- DIALOG MODAL PARA EDITAR REGISTRO DE USUARIO --}}
    <x-jet-dialog-modal wire:model="abrir">

        <x-slot name="title">
            <div class="text-center">
                Editando el Usuario <span class="ml-4"> {{ $editando->name }} </span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white">

                <div class="mt-2">

                    <form
                        class="flex flex-col items-center flex-1 p-1"
                        wire:submit.prevent="procesar"
                    >
                        <div class="mx-24 mt-4">

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el nombre del usuario --}}
                                <label for="name" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Nombre:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="name"
                                    name="name"
                                    wire:model="name"
                                >
                            </div>
                            @if($errors->has('name'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            
                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra la password del usuario --}}
                                <label for="password" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Nueva Password:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="password"
                                    name="password"
                                    placeholder="TECLEAR NUEVA PASSWORD"
                                    wire:model="password"
                                >
                            </div>
                            @if($errors->has('password'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el correo electrónico del prospecto --}}
                                <label for="email" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                    Correo:
                                </label>
                                <input
                                    class="w-64 px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 lowercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="email"
                                    id="email"
                                    name="email"
                                    wire:model="email"
                                >
                            </div>
                            @if($errors->has('email'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
        
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se indica la clave de role --}}
                                <div class="flex flex-row justify-center mb-6">
                                    <label for="clave_role" class="w-48 mt-2 mb-8 text-base font-normal leading-none text-gray-300 ">
                                        Es un SuperUsuario ?
                                    </label>
                                    <input
                                        class="w-6 h-6 mt-1 bg-orange-600 border border-gray-500 rounded md:mr-8 focus:ring-orange-700 ring-offset-gray-800"
                                        type="checkbox"
                                        wire:model="clave_role"
                                    >
                                </div>
                            </div>
                
                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí se carga la imagen "avatar" del usuario --}}
                                <div class="flex flex-row justify-center mb-6">
                                    <input
                                        class="text-xl font-bold"
                                        type="file"
                                        id="numerin"
                                        wire:model="imagen"
                                    >
                                </div>
                            </div>
                            @if($errors->has('imagen'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('imagen') }}
                                </div>
                            @endif
                            
                            <div wire:loading wire:target="imagen">
                                <div class="relative items-center w-full px-5 py-12 mx-auto md:px-12 lg:px-24 max-w-7xl">
                                    <div class="p-6 border-l-4 border-yellow-600 rounded-r-xl bg-yellow-50">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <h3 class="text-2xl font-bold text-yellow-800">Cargando la imagen...</h3>
                                                <div class="mt-2 text-xl text-yellow-600">
                                                    <p> Espere un momento en lo que se carga la imagen seleccionada </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div wire:loading.remove wire:target="imagen">
                                @if ($imagen)
                                    <div class="flex flex-row justify-center">
                                        <img class="w-48 h-64" src="{{ $imagen->temporaryUrl() }}">
                                    </div>
                                @else
                                    @if ($lafoto)
                                        <div class="flex flex-row justify-center">
                                            <img class="w-48 h-64" src="{{ Storage::disk('digitalocean')->url($urlfoto) }}" alt="aqui va una foto">
                                        </div>
                                    @else
                                        <div class="flex flex-row justify-center">
                                            <x-heroicon-o-user-add class="w-32 h-48"/>
                                        </div>
                                    @endif
                                @endif
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
                text: 'El Usuario fué Agregado Correctamente.',
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
                    Livewire.emitTo('catalogos.usuarios.index', 'delete', userId )
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
