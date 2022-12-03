<div 
    wire:init="iniciar"
    id="vista_edit"
    class="flex flex-col h-auto"
    x-data="{
        abrir: @entangle('abrir'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>
    <div style="background-color: #000" class="flex flex-col items-center min-h-screen pb-4 mx-auto mt-2 max-w-7xl md:mt-1 md:pb-2">

        <h1 class="my-4 text-2xl text-orange-500 text-bold">
            Editando el Contacto con id: <span class="ml-4">{{ $editando->id }}</span>
        </h1>

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
                        wire:model="editando.categoria_id"
                    >
                        <option value="0" class="text-orange-500">seleccionar...</option>
                        @foreach ($categos as $categ)
                        <option value="{{ $categ->cat_id }}" class="text-xl font-extrabold text-black">{{ $categ->clasif }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('editando.categoria_id'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.categoria_id') }}
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
                        wire:model="editando.clave_tipo"
                    >
                        <option value="" class="text-orange-500">seleccionar...</option>
                        @foreach ($cvetipos as $cvetipo)
                        <option value="{{ $cvetipo }}" class="text-xl font-extrabold text-black">{{ $cvetipo }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('editando.clave_tipo'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.clave_tipo') }}
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
                        wire:model="editando.clave_origen"
                    >
                        <option value="" class="text-orange-500">seleccionar...</option>
                        @foreach ($origenes as $origen)
                        <option value="{{ $origen }}" class="text-xl font-extrabold text-black">{{ $origen }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('editando.clave_origen'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.clave_origen') }}
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
                        wire:model="editando.clave_genero"
                    >
                        <option value="" class="text-orange-500">seleccionar...</option>
                        @foreach ($generos as $genero)
                        <option value="{{ $genero }}" class="text-xl font-extrabold text-black">{{ $genero }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('editando.clave_genero'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.clave_genero') }}
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
                        wire:model="editando.nombre_full"
                    >
                </div>
                @if($errors->has('editando.nombre_full'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.nombre_full') }}
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
                        wire:model="editando.domicilio_full"
                    >
                </div>
                @if($errors->has('editando.domicilio_full'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.domicilio_full') }}
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
                        wire:model="editando.telefono_fijo"
                    >
                </div>
                @if($errors->has('editando.telefono_fijo'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.telefono_fijo') }}
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
                        wire:model="editando.telefono_movil"
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
                            wire:model="editando.tiene_watsapp"
                        >
                    </div>
                </div>
                @if($errors->has('editando.telefono_movil'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.telefono_movil') }}
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
                        placeholder="ejemplo@servidor.com"
                        wire:model="editando.direccion_email"
                    >
                </div>
                @if($errors->has('editando.direccion_email'))
                    <div class="mb-8 text-xl text-center text-white bg-red-800 animate-pulse md:w-96 md:ml-8 md:mb-6 text-extrabold">
                        {{ $errors->first('editando.direccion_email') }}
                    </div>
                @endif

                <div class="flex flex-col justify-start h-16 md:flex-row">

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


    {{-- listeners de los select's  --}}
    <script>
        document.addEventListener('livewire:load', function(){

            console.log('- - - - - - - edita');

            $('#select2_cat_id').select2({
                dropdownParent: $('#vista_edit')
            });
            $('#select2_cat_id').on('change', function(){
                console.log('C-sel: ', this.value);
                @this.editando.categoria_id = this.value;
            });

            $('#select2_tip_id').select2({
                dropdownParent: $('#vista_edit')
            });
            $('#select2_tip_id').on('change', function(){
                console.log('T-sel: ', this.value);
                @this.editando.clave_tipo = this.value;
            });

            $('#select2_ori_id').select2({
                dropdownParent: $('#vista_edit')
            });
            $('#select2_ori_id').on('change', function(){
                console.log('O-sel: ', this.value);
                @this.editando.clave_origen = this.value;
            });

            $('#select2_gen_id').select2({
                dropdownParent: $('#vista_edit')
            });
            $('#select2_gen_id').on('change', function(){
                console.log('G-sel: ', this.value);
                @this.editando.clave_genero = this.value;
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
