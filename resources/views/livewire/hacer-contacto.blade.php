<div
    class="flex flex-col h-auto"
    x-data="{
        showSubscribe: @entangle('showSubscribe'),
        showSuccess: @entangle('showSuccess'),
        mensaje: 'Developed by: calin_mx @2022'
    }"
>

    <div class="m-4">
        <x-jet-button
        class="w-full bg-black text-lg justify-center py-4 px-8 hover:bg-yellow-700"
        x-on:click="showSubscribe=true"
        >
        Deja tus Datos
        </x-jet-button>
    </div>

    <x-jet-dialog-modal wire:model="showSubscribe"
        style="background-color: #000000">

        <x-slot name="title">
            Mis datos para contacto...
        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4"
                    placeholder="NOMBRE COMPLETO"
                    id="nombre_full"
                    name="nombre_full"
                    wire:model.defer="nombre_full"
                />
                <x-jet-input-error for="nombre_full" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-input type="tel" class="mt-1 block w-3/4"
                    placeholder="TELÉFONO MÓVIL NÚMERO"
                    id="telefono_movil"
                    name="telefono_movil"
                    wire:model.defer="telefono_movil"
                />
                <x-jet-input-error for="telefono_movil" class="mt-2" />
            </div>

            <div class="flex items-start mt-4">
                <div class="flex items-center h-5">
                    <input type="checkbox"
                        id="tiene_watsapp"
                        name="tiene_watsapp"
                        wire:model.defer="tiene_watsapp"
                        value="0"
                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required
                    >
                </div>
                <label for="tiene_watsapp" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-400">Mi teléfono si tiene watsapp</label>
            </div>

            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4"
                    placeholder="COLONIA O SECTOR"
                    id="colonia_o_sector"
                    name="colonia_o_sector"
                    wire:model.defer="colonia_o_sector"
                />
                <x-jet-input-error for="colonia_o_sector" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4"
                    placeholder="LOCALIDAD Y MUNICIPIO"
                    id="localidad_municipio"
                    name="localidad_municipio"
                    wire:model.defer="localidad_municipio"
                />
                <x-jet-input-error for="localidad_municipio" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4"
                    placeholder="ENTIDAD FEDERATIVA"
                    id="entidad_federativa"
                    name="entidad_federativa"
                    wire:model.defer="entidad_federativa"
                />
                <x-jet-input-error for="entidad_federativa" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-input type="email" class="mt-1 block w-3/4"
                    placeholder="correo@electronico"
                    id="correo_electronico"
                    name="correo_electronico"
                    wire:model.defer="correo_electronico"
                />
                <x-jet-input-error for="correo_electronico" class="mt-2" />
            </div>

            <div class="mt-4">
                <textarea
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="EN NÉSTE ESPACIO DEJAR UN MENSAJE..."
                    rows="4"
                    id="texto_del_mensaje"
                    name="texto_del_mensaje"
                    wire:model.defer="texto_del_mensaje"
                >
                </textarea>
                <x-jet-input-error for="texto_del_mensaje" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="footer">

            <x-jet-button class="mt-4 px-5 py-3 w-80 bg-blue-500 justify-center">
                <span wire:loading wire:target="subscribe" class="animate-spin text-extrabold text-5xl">
                    &#9696;
                </span>
                <span wire:loading.remove wire:target="subscribe">
                    Registrarme
                </span>
            </x-jet-button>

        </x-slot>

    </x-jet-dialog-modal>

    <x-modal class="bg-green-500" disparador="showSuccess">

        <p class="animate-pulse text-white font-extrabold text-9xl text-center">
            &check;
        </p>

        <p class="text-white font-extrabold text-4xl text-center m-10">
            Muy bien !
        </p>

        <p class="text-green-800 text-2xl text-center">
            Pronto me pondré en contacto...
        </p>

    </x-modal>

</div>
