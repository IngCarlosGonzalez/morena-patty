<x-app-layout>
    <div style="background-color: #000000" class="flex flex-col items-center min-h-screen pb-4 mx-auto mt-2 max-w-7xl md:mt-1 md:pb-2">

        <div class="flex flex-row w-full">
            <div class="hidden w-1/12 md:block">
                <span></span>
            </div>
            <div class="flex flex-col w-full md:w-10/12 place-content-center">
                <div style="background-color: rgb(86, 13, 13);" class="px-4 mt-2 mb-2 text-xl text-white shadow-2xl shadow-outline md:mt-4 md:rounded-3xl md:text-2xl">
                    <h1 class="font-sans font-light tracking-widest text-center">
                    Indice de Prospectos Registrados en mi Página
                    </h1>
                </div>
            </div>
            <div class="hidden w-1/12 md:block">
                <span></span>
            </div>
        </div>

        <div class="flex flex-row w-full">
            @livewire('directorios.subscribers.index')
            {{-- esta fué de pruebas de PowerGrid @livewire('subscriber-table') --}}
        </div>

    </div>

</x-app-layout>
