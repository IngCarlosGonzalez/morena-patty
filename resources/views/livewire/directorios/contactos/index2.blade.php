<div wire:init = "inicializa"
    id="vista_index"
    class="w-full"
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        cueristri: @entangle('cueristri'),
        valorengs: @entangle('valorengs'),
        parametpp: @entangle('parametpp'),
        parametsx: @entangle('parametsx'),
        parametad: @entangle('parametad'),
        parametkt: @entangle('parametkt'),
        parametko: @entangle('parametko'),
        parametc1: @entangle('parametc1'),
        parametc2: @entangle('parametc2'),
        search: @entangle('search'),
        abrir: @entangle('abrir'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    {{-- Cuerpo del listado - indice de Mis Contactos--}}

    <div class="w-full p-3 overflow-hidden bg-black">

        {{-- Esta fila es para controles, busqueda y comandos --}}
        <div class="flex flex-row justify-start mt-4">
            <h4 class="mt-1 ml-8 mr-4 text-lg font-normal text-white">
                Cuántos por Página:
            </h4>
            <select
                class="w-48 h-10 p-1 mb-4 text-lg font-bold text-gray-200 bg-black border-2 border-gray-700 rounded-md cursor-pointer focus:border-orange-600"
                wire:model="deCuantos"
            >
                <option value="6">de 6 en 6</option>
                <option value="20">de 20 en 20</option>
                <option value="50">de 50 en 50</option>
                <option value="100">ver cientos</option>
            </select>
            <h4 class="mt-1 ml-12 mr-4 text-lg font-normal text-yellow-500">
                Prop:&nbsp;&nbsp;{{ $owner_nombre }}
            </h4>
            <h4 class="mt-1 ml-12 mr-4 text-lg font-normal text-white">
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

        {{-- Esta otra fila es para los filtros aplicables --}}
        <div class="flex flex-row justify-start h-12 pt-1 pb-4 mt-0 bg-black border border-gray-800 rounded-lg align-center">

            <h4 class="mt-2 ml-8 mr-4 text-xl font-normal text-white">
                FILTROS.-  
            </h4>
            <h4 class="mt-2 ml-8 mr-4 text-lg font-normal text-white">
                del Tipo:
            </h4>
            <select
                class="h-10 p-1 mb-2 text-lg font-bold text-gray-300 bg-black border-2 border-gray-700 rounded-md cursor-pointer focus:border-orange-600"
                wire:model="delTipo"
                id="select2_tip_id"
            >
            <option value="" class="text-orange-500">seleccionar...</option>
            @foreach ($cvetipos as $cvetipo)
            <option value="{{ $cvetipo }}" class="text-lg font-bold text-gray-300 uppercase">{{ $cvetipo }}</option>
            @endforeach
            </select>

            <h4 class="mt-2 ml-24 mr-4 text-lg font-normal text-white">
                Origen:
            </h4>
            <select
                class="h-10 p-1 mb-2 text-lg font-bold text-gray-300 bg-black border-2 border-gray-700 rounded-md cursor-pointer focus:border-orange-600"
                wire:model="delOrigen"
                id="select2_ori_id"
            >
            <option value="" class="text-orange-500">seleccionar...</option>
            @foreach ($origenes as $origen)
            <option value="{{ $origen }}" class="text-lg font-bold text-gray-300 uppercase">{{ $origen }}</option>
            @endforeach
            </select>
            
            <h4 class="mt-2 ml-24 mr-4 text-lg font-normal text-white">
                Clasif:
            </h4>
            <select
                class="h-10 p-1 mb-2 text-lg font-bold text-gray-300 bg-black border-2 border-gray-700 rounded-md cursor-pointer focus:border-orange-600"
                wire:model="delaCateg"
                id="select2_cat_id"
            >
            <option value="0" class="text-orange-500">seleccionar...</option>
            @foreach ($categos as $categ)
            <option value="{{ $categ->cat_id }}" class="text-lg font-bold text-gray-300 uppercase">{{ $categ->clasif }}</option>
            @endforeach
            </select>
            
        </div>

        {{-- Aqi empieza la lista de registros mostrados --}}
        <div class="px-8 mt-4">

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

                                <th wire:click="clasifica('id')" class="w-1/12 pl-4 text-yellow-500 cursor-pointer">
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

                                <th wire:click="clasifica('clave_tipo')" class="w-1/12 pl-4 text-white cursor-pointer">
                                    Tipo
                                    @if ($sortear == 'clave_tipo')
                                        @if ($elOrden == 'asc')
                                            <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                        @else
                                            <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                        @endif
                                    @else
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @endif
                                </th>

                                <th wire:click="clasifica('clave_origen')" class="w-2/12 pl-4 text-white cursor-pointer">
                                    Originado
                                    @if ($sortear == 'clave_origen')
                                        @if ($elOrden == 'asc')
                                            <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                        @else
                                            <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                        @endif
                                    @else
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @endif
                                </th>

                                <th wire:click="clasifica('clasificacion')" class="w-1/12 pl-4 text-white cursor-pointer">
                                    Clasif
                                    @if ($sortear == 'clasificacion')
                                        @if ($elOrden == 'asc')
                                            <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                        @else
                                            <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                        @endif
                                    @else
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @endif
                                </th>

                                <th wire:click="clasifica('nombre_full')" class="w-4/12 pl-4 text-yellow-500 cursor-pointer">
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

                                <th wire:click="clasifica('telefono_movil')" class="w-1/12 pl-4 text-white cursor-pointer">
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

                                <th wire:click="clasifica('created_at')" class="w-1/12 pl-4 text-white cursor-pointer">
                                    Alta
                                    @if ($sortear == 'created_at')
                                        @if ($elOrden == 'asc')
                                            <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                        @else
                                            <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                        @endif
                                    @else
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @endif
                                </th>

                                <th class="w-1/12">
                                    <span class="ml-10">Acciones</span>
                                </th>

                            </tr>

                        </thead>

                        <tbody class="text-white">
                            
                            @foreach ($rengs as $renglon)

                            @php
                                $categor = strtolower($renglon->clasificacion);
                            @endphp

                            <tr wire:key="{{ $renglon->id }}" class="text-gray-400 border-2 border-gray-500">

                                <td class="px-4 py-2 text-yellow-500 ">&nbsp;{{ $renglon->id }}</td>

                                <td class="px-4 py-2">{{ $renglon->clave_tipo }}</td>

                                <td class="px-4 py-2">{{ $renglon->clave_origen }}</td>

                                <td class="px-4 py-2 capitalize">{{ $categor }}</td>

                                <td class="px-4 py-2 text-yellow-300 ">{{ $renglon->nombre_full }}</td>

                                <td class="px-4 py-2">{{ $renglon->telefono_movil }}</td>

                                <td class="px-4 py-2">{{ $renglon->created_at->diffForHumans() }}</td>

                                <td class="px-4 py-2">

                                    <div class="flex flex-row">

                                        <button
                                                class="px-2 py-1 mx-2 bg-gray-800 border-2 border-blue-800 rounded-md hover:bg-blue-500"
                                                wire:click="$emit('editar', {{ $renglon }}, {{ $loop->iteration }})"
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

                    <div class="hidden mt-4">
                        <span class="px-4 py-2 text-2xl font-bold text-white">
                            {{ $rengs->currentPage() }}
                        </span>
                    </div>

                @endif

            @else

                <div class="p-5">
                    <span class="text-5xl font-bold text-red-600 bg-black">
                        Promblema con el Servidor de Registros ....
                    </span>
                </div>

            @endif

        </div>

    </div>


    {{-- DIALOG MODAL PARA VER Y ACTUALIZAR DATOS DE CONTACTO --}}
    <x-jet-dialog-modal wire:model="abrir" id="modal_editar">

        <x-slot name="title">
            <div class="text-center my-4 text-2xl text-orange-500 text-bold"">
                Datos del Contacto con id: <span class="ml-4">{{ $editando->id }}</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white ">

                <div class="mt-0" style="width: 720px;">

                    <form
                        class="flex flex-col items-center flex-1 p-1"
                        wire:submit.prevent="procesar"
                    >
                        <div class="w-full">

                            <div class="flex flex-col mb-6 wire:ignore md:mx-24 md:flex-row md:items-center ">
                                {{-- Aquí va la CATEGORÍA del contacto --}}
                                <label for="categoria_id" class="w-48 text-base font-normal leading-none text-gray-300 ">
                                    Categoría Asignada:
                                </label>
                                <select
                                    class="w-64 px-2 py-1 mr-4 text-xl font-extrabold text-black border-gray-300 rounded-md shadow-sm select2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    id="mod_select2_cat_id"
                                    name="categoria_id"
                                    wire:model="categoria_id"
                                >
                                    <option value="0" class="text-orange-500">seleccionar...</option>
                                    @foreach ($categos as $categ)
                                    <option value="{{ $categ->cat_id }}" class="text-xl font-extrabold text-black">{{ $categ->clasif }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('categoria_id'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('categoria_id') }}
                                </div>
                            @endif

                            <div class="flex flex-col mb-6 wire:ignore md:mx-24 md:flex-row md:items-center ">
                                {{-- Aquí va el TIPO de contacto --}}
                                <label for="clave_tipo" class="w-48 text-base font-normal leading-none text-gray-300 ">
                                    Tipo de Contacto:
                                </label>
                                <select
                                    class="w-64 px-2 py-1 mr-4 text-xl font-extrabold text-black border-gray-300 rounded-md shadow-sm select2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    id="mod_select2_tip_id"
                                    name="clave_tipo"
                                    wire:model="clave_tipo"
                                >
                                    <option value="" class="text-orange-500">seleccionar...</option>
                                    @foreach ($cvetipos as $cvetipo)
                                    <option value="{{ $cvetipo }}" class="text-xl font-extrabold text-black">{{ $cvetipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('clave_tipo'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('clave_tipo') }}
                                </div>
                            @endif

                            <div class="flex flex-col mb-6 wire:ignore md:mx-24 md:flex-row md:items-center ">
                                {{-- Aquí va el ORIGEN del registro --}}
                                <label for="clave_origen" class="w-48 text-base font-normal leading-none text-gray-300 ">
                                    Origen del Registro:
                                </label>
                                <select
                                    class="w-64 px-2 py-1 mr-4 text-xl font-extrabold text-black border-gray-300 rounded-md shadow-sm select2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    id="mod_select2_ori_id"
                                    name="clave_origen"
                                    wire:model="clave_origen"
                                >
                                    <option value="" class="text-orange-500">seleccionar...</option>
                                    @foreach ($origenes as $origen)
                                    <option value="{{ $origen }}" class="text-xl font-extrabold text-black">{{ $origen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('clave_origen'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('clave_origen') }}
                                </div>
                            @endif

                            <div class="flex flex-col mb-6 wire:ignore md:mx-24 md:flex-row md:items-center ">
                                {{-- Aquí va el GENERO de la PERSONA --}}
                                <label for="clave_genero" class="w-48 text-base font-normal leading-none text-gray-300 ">
                                    Género del Contacto:
                                </label>
                                <select
                                    class="w-64 px-2 py-1 mr-4 text-xl font-extrabold text-black border-gray-300 rounded-md shadow-sm select2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    id="mod_select2_gen_id"
                                    name="clave_genero"
                                    wire:model="clave_genero"
                                >
                                    <option value="" class="text-orange-500">seleccionar...</option>
                                    @foreach ($generos as $genero)
                                    <option value="{{ $genero }}" class="text-xl font-extrabold text-black">{{ $genero }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('clave_genero'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('clave_genero') }}
                                </div>
                            @endif

                            <div class="flex flex-col mt-4 md:flex-row md:items-center ">
                                {{-- Aquí entra el nombre completo del contacto --}}
                                <label for="nombre_full" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                    Nombre del Contacto:
                                </label>
                                <input
                                    style="width: 400px;"
                                    class="px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="nombre_full"
                                    name="nombre_full"
                                    placeholder="nombre completo"
                                    wire:model="nombre_full"
                                >
                            </div>
                            @if($errors->has('nombre_full'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('nombre_full') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el domicilio completo del contacto --}}
                                <label for="domicilio_full" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                    Domicilio de Contacto:
                                </label>
                                <input
                                    style="width: 400px;"
                                    class="px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 uppercase border-gray-300 rounded-md shadow-sm brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="text"
                                    id="domicilio_full"
                                    name="domicilio_full"
                                    placeholder="domicilio completo"
                                    wire:model="domicilio_full"
                                >
                            </div>
                            @if($errors->has('domicilio_full'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('domicilio_full') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí entra el numero de telefono FIJO --}}
                                <label for="telefono_fijo" class="w-48 text-base font-normal leading-none text-gray-300 md:mb-4 ">
                                    Teléfono de Casa:
                                </label>
                                <input
                                    class="px-2 py-1 mb-4 text-xl font-bold text-black placeholder-orange-400 border-gray-300 rounded-md shadow-sm md:w-48 md:mr-2 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="number"
                                    size="10"
                                    maxlength="10"
                                    id="telefono_fijo"
                                    name="telefono_fijo"
                                    placeholder="obligatorio"
                                    wire:model="telefono_fijo"
                                >
                            </div>
                            @if($errors->has('telefono_fijo'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:mb-6 text-extrabold">
                                    {{ $errors->first('telefono_fijo') }}
                                </div>
                            @endif

                            <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                                {{-- Aquí entra el numero de telefono celular --}}
                                <label for="telefono_movil" class="w-48 text-base font-normal leading-none text-gray-300 md:mb-4 ">
                                    Teléfono Celular:
                                </label>
                                <input
                                    class="px-2 py-1 mb-4 mr-0 text-xl font-bold text-black placeholder-orange-400 border-gray-300 rounded-md shadow-sm md:w-48 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="number"
                                    size="10"
                                    maxlength="10"
                                    id="telefono_movil"
                                    name="telefono_movil"
                                    placeholder="obligatorio"
                                    wire:model="telefono_movil"
                                >
                                <div class="flex flex-row justify-center mb-3">
                                    <label for="tiene_watsapp" class="ml-0 mr-4 text-base font-normal leading-none text-left text-gray-300 md:ml-4 md:text-right">
                                        Tiene Watsapp...
                                    </label>
                                    <input
                                        class="w-6 h-6 bg-orange-600 border border-gray-500 rounded md:mr-8 focus:ring-orange-700 ring-offset-gray-800"
                                        type="checkbox"
                                        id="tiene_watsapp"
                                        name="tiene_watsapp"
                                        wire:model="tiene_watsapp"
                                    >
                                </div>
                            </div>
                            @if($errors->has('telefono_movil'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('telefono_movil') }}
                                </div>
                            @endif
      
                            <div class="flex flex-col md:flex-row md:items-center ">
                                {{-- Aquí entra el correo electrónico del contacto --}}
                                <label for="direccion_email" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                    Correo Electrónico:
                                </label>
                                <input
                                    style="width: 400px;"
                                    class="px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 lowercase border-gray-300 rounded-md shadow-sm md:mr-12 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="email"
                                    id="direccion_email"
                                    name="direccion_email"
                                    wire:model="direccion_email"
                                >
                            </div>
                            @if($errors->has('direccion_email'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('direccion_email') }}
                                </div>
                            @endif

                            {{-- Este es un honeypot rístico --}}
                            <div class="invisible">
                                <input
                                    type="checkbox"
                                    id="trampa"
                                    name="trampa"
                                    wire:model="trampa"
                                >
                            </div>
        
                            <div class="flex flex-col justify-start md:flex-row">

                                <button wire:click="abortar" class="w-48 px-12 py-2 text-lg font-bold text-black bg-orange-500 border-2 border-orange-700 hover:bg-orange-300">
                                    SIEMPRE NO
                                </button>
                
                                <button wire:click="procesar" class="w-48 px-8 py-2 text-xl font-bold text-black bg-green-500 border-2 border-green-700 md:ml-32 hover:bg-green-300">
                                    <span wire:loading wire:target="procesar" class="px-12 text-xl font-extrabold animate-spin">
                                        &#9696;
                                    </span>
                                    <span wire:loading.remove wire:target="procesar" class="text-xl">
                                        ACTUALIZAR
                                    </span>
                                </button>

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


    {{-- para informar parametros  --}}
    <script>

        document.addEventListener('livewire:load', () => {

            @this.on('informar', (contacto, posicion) => {

                // const querystring = window.location.search;
                // @this.cueristri = window.location.search;
                // console.log(querystring);
                // const params = new URLSearchParams(querystring);

                // if (params.has("rengs")) {
                //     console.log('Param rengs: ', params.get('rengs'));
                //     @this.valorengs = params.get('rengs');
                // }
                // if (params.has("pp")) {
                //     console.log('Param PP: ', params.get('pp'));
                //     @this.parametpp = params.get('pp');
                // }
                // if (params.has("sx")) {
                //     console.log('Param SX: ', params.get('sx'));
                //     @this.parametpp = params.get('sx');
                // }
                // if (params.has("ad")) {
                //     console.log('Param AD: ', params.get('ad'));
                //     @this.parametpp = params.get('ad');
                // }
                // if (params.has("kt")) {
                //     console.log('Param KT: ', params.get('kt'));
                //     @this.parametpp = params.get('kt');
                // }
                // if (params.has("ko")) {
                //     console.log('Param KOT: ', params.get('ko'));
                //     @this.parametpp = params.get('ko');
                // }
                // if (params.has("c1")) {
                //     console.log('Param C1: ', params.get('c1'));
                //     @this.parametpp = params.get('c1');
                // }
                // if (params.has("c2")) {
                //     console.log('Param C2: ', params.get('c2'));
                //     @this.parametpp = params.get('c2');
                // }
                // console.log('Informado: ok');
                // Livewire.emitTo('directorios.contactos.index2', 'editar', contacto, posicion )

            })

        })

    </script>


    {{-- listeners de los select's  --}}
    <script>
        document.addEventListener('livewire:load', function(){

            console.log('+++++++ mis contactos');

            // estos son para los filtros:

            $('#select2_tip_id').select2({
                dropdownParent: $('#vista_index')
            });
            $('#select2_tip_id').on('change', function(){
                // console.log('Tip-sel: ', this.value);
                @this.delTipo = this.value;
            });

            $('#select2_ori_id').select2({
                dropdownParent: $('#vista_index')
            });
            $('#select2_ori_id').on('change', function(){
                // console.log('Ori-sel: ', this.value);
                @this.delOrigen = this.value;
            });

            $('#select2_cat_id').select2({
                dropdownParent: $('#vista_index')
            });
            $('#select2_cat_id').on('change', function(){
                // console.log('Cat-sel: ', this.value);
                @this.delaCateg = this.value;
            });

            // estos son para el modal de edicion:
        
            $('#mod_select2_cat_id').select2({
                dropdownParent: $('#modal_editar')
            });
            $('#mod_select2_cat_id').on('change', function(){
                // console.log('C-sel: ', this.value);
                @this.categoria_id = this.value;
            });

            $('#mod_select2_tip_id').select2({
                dropdownParent: $('#modal_editar')
            });
            $('#mod_select2_tip_id').on('change', function(){
                // console.log('T-sel: ', this.value);
                @this.clave_tipo = this.value;
            });

            $('#mod_select2_ori_id').select2({
                dropdownParent: $('#modal_editar')
            });
            $('#mod_select2_ori_id').on('change', function(){
                // console.log('O-sel: ', this.value);
                @this.clave_origen = this.value;
            });

            $('#mod_select2_gen_id').select2({
                dropdownParent: $('#modal_editar')
            });
            $('#mod_select2_gen_id').on('change', function(){
                // console.log('G-sel: ', this.value);
                @this.clave_genero = this.value;
            });
            
        });
        
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
                    Livewire.emitTo('directorios.contactos.index2', 'delete', userId )
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
                text: 'El Contacto fué Actualizado Correctamente.',
                icon: 'success',
                timer: 3000,
                width: 600,
                padding: '3em',
                color: '#000000',
                background: '#00aa00',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })
        })

    </script>


    {{-- toast que avisa que no se procesó --}}
    <script>

        Livewire.on('abortado', () => {

            console.log('<< abortado >>');
            
            const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            width: 720,
            padding: '3em',
            color: '#006600',
            background: '#ccff33',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            Toast.fire({
            imageUrl: '{{ asset('logos/Tick.png') }}',
            imageHeight: 95,
            imageWidth: 95,
            title: '<h6 class="text-5xl font-extrabold">No se aplicaron cambios</h6>'
            })

        })

    </script>


</div>
