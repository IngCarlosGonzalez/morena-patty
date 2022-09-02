<x-app-layout>
    <div style="background-color: #000000" class="flex flex-col items-center max-w-7xl mx-auto min-h-screen mt-2 md:mt-1 pb-4 md:pb-2">

        <div class="flex flex-row w-full">
            <div class="hidden md:block w-1/12">
                <span></span>
            </div>
            <div class="flex flex-col w-full md:w-10/12 place-content-center">
                <div style="background-color: rgb(86, 13, 13);" class="px-4 mt-2 mb-2 md:mt-4 md:rounded-3xl shadow-2xl shadow-outline text-xl md:text-2xl text-white">
                    <h1 class="font-sans font-light text-center tracking-widest">
                    Consulta de Datos de un Contacto
                    </h1>
                </div>
            </div>
            <div class="hidden md:block w-1/12">
                <span></span>
            </div>
        </div>

        <div class="flex flex-row w-full">
            @livewire('directorios.contactos.show')
        </div>

    </div>
</x-app-layout>
