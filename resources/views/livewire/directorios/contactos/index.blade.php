<div wire:init = "inicializa"
    id="vista_index"
    class="w-full"
    x-data="{
        cantidad: @entangle('cantidad'),
        deCuantos: @entangle('deCuantos'),
        search: @entangle('search'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    {{-- Cuerpo del listado de indice global de contactos --}}

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

            <h4 class="mt-1 ml-16 mr-4 text-lg font-normal text-white">
                Prop:
            </h4>
            <select
                class="h-10 p-1 mb-2 text-lg font-bold text-gray-300 bg-black border-2 border-gray-700 rounded-md cursor-pointer focus:border-orange-600"
                wire:model="delPropie"
                id="select2_own_id"
            >
            <option value="0" class="text-orange-500">seleccionar...</option>
            @foreach ($propiets as $propiet)
            <option value="{{ $propiet->own_id }}" class="text-lg font-bold text-gray-300 uppercase">{{ $propiet->nombre }}</option>
            @endforeach
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

            <h4 class="mt-2 ml-20 mr-4 text-lg font-normal text-white">
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
            
            <h4 class="mt-2 ml-20 mr-4 text-lg font-normal text-white">
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

                                {{-- <th class="w-1/12 pl-4">
                                    Owner
                                </th> --}}
                                <th wire:click="clasifica('owner_id')" class="w-1/12 pl-4 text-white cursor-pointer">
                                    Prop
                                    @if ($sortear == 'owner_id')
                                        @if ($elOrden == 'asc')
                                            <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                        @else
                                            <x-heroicon-o-sort-ascending class="float-right w-6 h-6" />
                                        @endif
                                    @else
                                        <x-heroicon-o-sort-descending class="float-right w-6 h-6" />
                                    @endif
                                </th>

                                {{-- <th class="w-1/12 pl-4">
                                    Tipo
                                </th> --}}
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

                                {{-- <th class="w-2/12 pl-4">
                                    Origen
                                </th> --}}
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

                                {{-- <th class="w-1/12 pl-4">
                                    Clasif
                                </th> --}}
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

                                <th wire:click="clasifica('nombre_full')" class="w-3/12 pl-4 text-yellow-500 cursor-pointer">
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

                                {{-- <th class="w-1/12 pl-4">
                                    Móvil
                                </th> --}}
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

                                {{-- <th class="w-1/12 pl-4">
                                    Alta
                                </th> --}}
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
                                $ident = $renglon->owner_id;
                                $valor = DB::table('owners')->where("id", $ident)->first()->nombre_titular;
                                $cadena = str_ireplace(' ','',$valor);
                                $propiet = strtolower(substr($cadena,0,9));
                                $categor = strtolower($renglon->clasificacion);
                            @endphp

                            <tr wire:key="{{ $renglon->id }}" class="text-gray-400 border-2 border-gray-500">

                                <td class="px-4 py-2 text-yellow-500 ">&nbsp;{{ $renglon->id }}</td>

                                <td class="px-4 py-2 capitalize">{{ $propiet }}</td>

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
                        Promblema con el Servidor de Registros ....
                    </span>
                </div>

            @endif

        </div>

    </div>


    {{-- listeners de los select's  --}}
    <script>
        document.addEventListener('livewire:load', function(){

            console.log('+++++++ contactos');

            $('#select2_own_id').select2({
                dropdownParent: $('#vista_index')
            });
            $('#select2_own_id').on('change', function(){
                // console.log('Own-sel: ', this.value);
                @this.delPropie = this.value;
            });

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
