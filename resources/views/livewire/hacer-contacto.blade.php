<div
    class="flex flex-col h-auto"
    x-data="{
        showSubscribe: @entangle('showSubscribe'),
        showSuccess: @entangle('showSuccess'),
        recaptcha: @entangle('recaptcha'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    {{-- Este botón es el que se inserta en la vista LandingPage --}}
    <div class="m-4" >
        <x-jet-button
        class="w-full bg-green-600 text-lg justify-center py-4 px-8 hover:bg-yellow-700"
        x-on:click="showSubscribe=true"
        >
        Ponte en Contacto
        </x-jet-button>
    </div>

    {{-- Modal con formato para registrar al prospecto --}}
    <x-dialogo x-data="" x-cloak class="bg-black" disparador="showSubscribe">

    	<div class="h-auto md:container mb-6 md:mx-auto w-full max-w-6xl text-white rounded-lg overflow-hidden shadow-xl transform transition-all">

	        <form
	            class="flex flex-1 flex-col items-center p-1"
	            wire:submit.prevent="subscribe"
	        >
                <div class="mt-4 mx-24">

                    <div class="uppercase text-left ml-6 mb-4 mt-4 text-gray-300 font-normal text-xl md:text-3xl">
                        Estos son mis datos ...
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí entra el nombre completo del prospecto --}}
                        <label for="nombre_full" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Nombre Completo:
                        </label>
                        <input
                            class="w-full uppercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="text"
                            id="nombre_full"
                            name="nombre_full"
                            placeholder="nombre y apellidos"
                            wire:model.defer="nombre_full"
                        >
                    </div>
                    @if($errors->has('nombre_full'))
                        <div class="animate-pulse mb-8 md:w-96 md:ml-8 md:mb-6 text-center text-extrabold text-xl text-white bg-red-800">
                            {{ $errors->first('nombre_full') }}
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row md:items-center md:justify-start">
                        {{-- Aquí entra el numero de telefono celular --}}
                        <label for="telefono_movil" class="md:ml-6 md:mb-4 md:w-48 font-normal text-base leading-none text-gray-300">
                            Teléfono Móvil:
                        </label>
                        <input
                            class="w-full md:-ml-2 md:w-48 placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 md:mr-2 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="tel"
                            id="telefono_movil"
                            name="telefono_movil"
                            placeholder="0000000000"
                            wire:model.defer="telefono_movil"
                        >
                        <div class="flex flex-row mb-3 justify-center">
                            <label for="tiene_watsapp" class="ml-0 mr-4 md:ml-4 text-left md:text-right font-normal text-base leading-none text-gray-300">
                                Teléfono con Watsapp...
                            </label>
                            <input
                                class="w-6 h-6 md:mr-8 border rounded bg-orange-600 border-gray-500 focus:ring-orange-700 ring-offset-gray-800"
                                type="checkbox"
                                id="tiene_watsapp"
                                name="tiene_watsapp"
                                wire:model.defer="tiene_watsapp"
                            >
                        </div>
                    </div>
                    @if($errors->has('telefono_movil'))
                        <div class="animate-pulse mb-8 md:w-96 md:ml-8 md:mb-6 text-center text-extrabold text-xl text-white bg-red-800">
                            {{ $errors->first('telefono_movil') }}
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí entra la colonia de residencia --}}
                        <label for="colonia_o_sector" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Colonia o Sector:
                        </label>
                        <input
                            class="w-full uppercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="text"
                            id="colonia_o_sector"
                            name="colonia_o_sector"
                            placeholder="nombre de colonia"
                            wire:model.defer="colonia_o_sector"
                        >
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí entra la localidad de residencia --}}
                        <label for="localidad_municipio" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Localidad y Municipio:
                        </label>
                        <input
                            class="w-full uppercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="text"
                            id="localidad_municipio"
                            name="localidad_municipio"
                            placeholder="nombre de localidad"
                            wire:model.defer="localidad_municipio"
                        >
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí entra la estado de residencia --}}
                        <label for="entidad_federativa" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Entidad Federativa:
                        </label>
                        <input
                            class="w-full uppercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="text"
                            id="entidad_federativa"
                            name="entidad_federativa"
                            placeholder="nombre del estado"
                            wire:model.defer="entidad_federativa"
                        >
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí entra el correo electrónico del prospecto --}}
                        <label for="email" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Correo:
                        </label>
                        <input
                            class="w-full lowercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            type="email"
                            id="correo_electronico"
                            name="correo_electronico"
                            placeholder="ejemplo_correo@servidor.com"
                            wire:model.defer="correo_electronico"
                        >
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        {{-- Aquí se captura el mensaje --}}
                        <label for="texto_del_mensaje" class="md:mr-4 md:ml-6 md:mb-4 md:w-64 font-normal text-base leading-none text-gray-300">
                            Deje su Mensaje:
                        </label>
                        <textarea
                            rows="3"
                            class="w-full uppercase placeholder-orange-400 font-bold text-xl text-black mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300 focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                            id="texto_del_mensaje"
                            name="texto_del_mensaje"
                            placeholder="teclee aquí su mensaje"
                            wire:model.defer="texto_del_mensaje"
                        ></textarea>
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

                    {{-- Aqui se incluye el widget de recaptchav2 --}}
                    <div class="flex flex-col bg-black w-4/5 ml-24 items-center justify-end mt-1 mb-8 py-1 ">
                        <div  wire:ignore>
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display(['data-size' => 'normal', 'data-theme' => 'dark', 'data-callback' => 'captchaCallback']) !!}
                        </div>
                        @if($errors->has('recaptcha'))
                            <div class="animate-pulse mb-8 md:w-96 md:ml-8 md:mb-8 text-center text-extrabold text-xl text-white bg-red-800">
                                {{ $errors->first('recaptcha') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col mx-auto px-4 mb-12">
                        {{-- Este es el botón para submit de datos con animación --}}
                        <button class="hover:scale-90 mt-4 px-12 py-3 bg-orange-600 border border-orange-200 rounded-lg hover:bg-orange-400">
                            <span wire:loading wire:target="subscribe" class="animate-spin text-extrabold text-4xl">
                                &#9696;
                            </span>
                            <span wire:loading.remove wire:target="subscribe" class="text-3xl">
                                Registrarme
                            </span>
                        </button>
                    </div>

                </div>

	        </form>

        </div>

    </x-dialogo>

    {{-- Este modal avisa que el registro fué exitoso --}}
    <x-dialogo x-data="" x-cloak class="bg-green-700" disparador="showSuccess">

        <div class="h-auto md:container md:mx-auto w-full max-w-6xl text-yellow-500 rounded-lg overflow-hidden shadow-xl transform transition-all">

            <p class="mt-12 animate-bounce text-white font-extrabold text-9xl text-center">
                &check;
            </p>

            <p class="text-white font-extrabold text-4xl text-center m-10">
                Muy bien !
            </p>

            <p class="mx-36 mb-12 text-white text-bold text-2xl text-center">
                Pronto me pondré en contacto...
            </p>

            <div class="flex flex-col mb-12 justify-center w-48 mx-auto">
                <button class="mt-4 px-12 py-3 text-black bg-white border border-gray-200 rounded-lg hover:bg-yellow-600"
                    wire:click="$toggle('showSuccess')" wire:loading.attr="disabled">
                    Cerrar
                </button>
            </div>

        </div>

    </x-dialogo>

    {{-- Este script enlaza al modal con la clase para cachar el response --}}
    <script>
        var captchaCallback = function() {
            @this.
            set('recaptcha', grecaptcha.getResponse());
            console.log('---------------------');
        };
    </script>

    {{-- mensaje para limpieza despues de registrar --}}
    <script>

        Livewire.on('limpieza', () => {
            @this.
            set('recaptcha', 0);
            console.log('-------cleaned---------');
        })

    </script>

</div>
