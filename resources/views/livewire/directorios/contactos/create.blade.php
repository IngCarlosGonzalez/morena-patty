<div wire:init="evaluar"
    class="flex flex-col h-auto"
    x-data="{
        crear: @entangle('crear'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    <h1 class="mt-10 text-xl text-white md:mt-20 md:text-3xl text-bold">
        Creación de Contactos
    </h1>

    <div>
        @if (session()->has('nosepuede'))
            <div class="my-12 ml-8 text-xl font-bold text-yellow-600">
                {{ session('nosepuede') }}
            </div>
        @endif
    </div>

    <div class="flex flex-col items-start justify-center w-full text-left">
        
        <h1 class="mt-4 mb-2 text-lg font-bold leading-tight text-orange-500 md:mt-12 md:text-2xl" >
            <span class="">{{ $leyenda_top }}</span>
        </h1>

        <h1 class="mb-4 text-lg font-bold leading-tight text-orange-500 md:mb-12 md:text-2xl" >
            <span class="">{{ $owner_nombre }}</span>
        </h1>
        
        <div class="flex flex-col items-center mb-4">

            @if ($mostrar_boton)

                <div class="m-4" >
                    <x-jet-button
                    class="justify-center w-32 px-4 py-2 text-base bg-green-600 md:w-64 md:px-8 md:py-4 md:text-lg hover:bg-yellow-700"
                    wire:click="agregar"
                    >
                    Agregar Otro
                    </x-jet-button>
                </div>

                <p class="mt-2 mb-8 text-base leading-normal text-gray-400">
                    Completar datos adicionales en lista general.
                </p>
         
            @endif
            
            {{-- <div wire:poll.visible class="mt-8 text-base leading-normal text-gray-400">
                Current time: {{ now() }}
            </div> --}}

        </div>

    </div>


    {{-- DIALOG MODAL PARA CAPTURAR NUEVO y PROCESAR INSERT --}}
    <x-jet-dialog-modal wire:model="crear" id="modal_crear">

        <x-slot name="title">
            <div class="text-center">
                Datos del Nuevo Contacto 
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
                                    id="select2_cat_id"
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
                                    id="select2_tip_id"
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
                                    id="select2_ori_id"
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
                                    id="select2_gen_id"
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
                                    type="text"
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
                                    type="text"
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
                                <label for="correo_electronico" class="w-48 mt-2 mb-4 text-base font-normal leading-none text-gray-300 ">
                                    Correo Electrónico:
                                </label>
                                <input
                                    style="width: 400px;"
                                    class="px-2 py-1 mb-4 mr-4 text-xl font-bold text-black placeholder-orange-400 lowercase border-gray-300 rounded-md shadow-sm md:mr-12 brder focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                                    type="email"
                                    id="correo_electronico"
                                    name="correo_electronico"
                                    placeholder="ejemplo_correo@servidor.com"
                                    wire:model="correo_electronico"
                                >
                            </div>
                            @if($errors->has('correo_electronico'))
                                <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                                    {{ $errors->first('correo_electronico') }}
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

                                <a href="#" wire:click="$set('crear', false)" class="w-48 px-12 py-2 text-lg font-bold text-black bg-orange-500 border-2 border-orange-700 hover:bg-orange-300">
                                    CERRAR
                                </a>
                
                                <a href="#" wire:click="procesar" class="w-48 px-8 py-2 text-xl font-bold text-black bg-green-500 border-2 border-green-700 md:ml-32 hover:bg-green-300">
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


    {{-- listeners de los select's  --}}
    <script>
        document.addEventListener('livewire:load', function(){

            console.log('- - - - - - - new');

            $('#select2_cat_id').select2({
                dropdownParent: $('#modal_crear')
            });
            $('#select2_cat_id').on('change', function(){
                console.log('C-sel: ', this.value);
                @this.categoria_id = this.value;
            });

            $('#select2_tip_id').select2({
                dropdownParent: $('#modal_crear')
            });
            $('#select2_tip_id').on('change', function(){
                console.log('T-sel: ', this.value);
                @this.clave_tipo = this.value;
            });

            $('#select2_ori_id').select2({
                dropdownParent: $('#modal_crear')
            });
            $('#select2_ori_id').on('change', function(){
                console.log('O-sel: ', this.value);
                @this.clave_origen = this.value;
            });

            $('#select2_gen_id').select2({
                dropdownParent: $('#modal_crear')
            });
            $('#select2_gen_id').on('change', function(){
                console.log('G-sel: ', this.value);
                @this.clave_genero = this.value;
            });
            
        });
        
    </script>


    {{-- mensaje de procesado ok --}}
    <script>

        Livewire.on('procesaOk', () => {

            // const Toast = Swal.mixin({
            // toast: true,
            // position: 'center',
            // showConfirmButton: true,
            // timer: 30000,
            // width: 600,
            // padding: '3em',
            // color: '#000000',
            // background: '#00aa00',
            // showConfirmButton: true,
            // confirmButtonText: 'O K',
            // timerProgressBar: true,
            // didOpen: (toast) => {
            //     toast.addEventListener('mouseenter', Swal.stopTimer)
            //     toast.addEventListener('mouseleave', Swal.resumeTimer)
            // }
            // })
            // Toast.fire({
            // icon: 'success',
            // title: 'El nuevo contacto se creó correctamante.'
            // })

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Procesado!',
                text: 'El Contacto fué Agregado Correctamente.',
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

    
    {{-- toast que rechaza proceso por no ser propietario --}}
    <script>

        Livewire.on('rechazado', () => {

            console.log('<< rechazado >>');
            
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })
            Toast.fire({
            icon: 'warning',
            title: 'Usted no tiene opcion de crear nuevo'
            })

        })

    </script>


    {{-- este es un swal de rechazo  --}}
    <script>

        window.addEventListener('ejecuta', () => {

            console.log('<< se rechaza >>');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Deshabilitado!',
                text: 'El Usuario Actual Debe ser Propietario.',
                icon: 'error',
                width: 600,
                padding: '3em',
                color: '#ffff00',
                background: '#ff0000',
                showConfirmButton: true,
                confirmButtonText: 'CERRAR',
                timer: 5000
            })

        })

    </script>

</div>
