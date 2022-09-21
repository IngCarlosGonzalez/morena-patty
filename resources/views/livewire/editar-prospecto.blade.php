<div>

    <button wire:click="$set('abrir', true)" class="border-2 px-6 py-0 border-blue-800 rounded-md bg-gray-800 hover:bg-blue-500">
        VER
    <button>

    <x-jet-dialog-modal wire:model="abrir">

        <x-slot name="title">
            <div class="">
                Datos del Prospecto
                <div>{{ $procesado }}</div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-white">

                <div class="mt-4">

                    <div class="flex flex-col md:flex-row md:items-center border-t-4 border-gray-600">
                        <span class="text-left w-24 mt-6 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Nombre:
                        </span>
                        <span class="text-left w-full mt-6 ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->nombre_full }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Teléfono:
                        </span>
                        <span class="text-left w-32 ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->telefono_movil }}
                        </span>
                        <span class="text-right w-48 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Con watsapp?
                        </span>
                        @if ($subscriber->tiene_watsapp == 1)
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
                            {{ $subscriber->colonia_o_sector }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Municipio:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->localidad_municipio }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Entidad:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->entidad_federativa }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center ">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Correo:
                        </span>
                        <span class="text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->correo_electronico }}
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center border-b-4 border-gray-600">
                        <span class="text-left w-24 md:mr-4 md:ml-6 md:mb-4 font-normal text-base leading-none text-gray-300">
                            Mensaje:
                        </span>
                        <span class="break-all text-left w-full ont-bold text-xl mb-4 px-2 py-1 mr-4 brder rounded-md shadow-sm border-gray-300">
                            {{ $subscriber->texto_del_mensaje }}
                        </span>
                    </div>

                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="my-6 mr-6">
                <a href="#" wire:click="$set('abrir', false)" class="px-12 py-2 text-black text-bold text-lg border-2 border-orange-700 bg-orange-500 hover:bg-orange-300">
                CERRAR
                </a>
                <a href="#" wire:click="procesar" class="ml-6 px-8 py-2 text-black text-bold text-lg border-2 border-green-700 bg-green-500 hover:bg-green-300">
                    <span wire:loading wire:target="procesar" class="px-11 animate-spin text-extrabold text-xl">
                        &#9696;
                    </span>
                    <span wire:loading.remove wire:target="procesar" class="text-xl">
                        CONVERTIR
                    </span>
                </a>
            </div>
        </x-slot>

    </x-jet-dialog-modal>

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
                color: '#ffffff',
                background: '#006600',
                showConfirmButton: true,
                confirmButtonText: 'O K'
            })
        })

    </script>

</div>
