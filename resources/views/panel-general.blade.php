<x-app-layout>

    <div style="background-color: #000000" class="flex flex-col items-center max-w-7xl mx-auto h-screen mt-2 md:mt-1 pb-4 md:pb-2">

        <div class="flex flex-row w-full">

            <div class="hidden md:block w-1/12">
                <span></span>
            </div>

            <div class="flex flex-col w-full md:w-10/12 place-content-center">
                <div class="mt-12 md:rounded-3xl bg-gray-800 shadow text-2xl md:text-5xl text-white">
                    <h1 class="font-bold text-center py-4 md:py-12"> Damos la bienvenida a:&nbsp;&nbsp;{{ Auth::user()->name }}</h1>
                </div>
                <div style="background-color: #500000" class="mt-8 md:rounded-3xl shadow text-2xl md:text-6xl text-white">
                    <h1 class="font-bold text-center py-4 md:py-24">Inicio del Sistema</h1>
                </div>
            </div>

            <div class="hidden md:block w-1/12">
                <span></span>
            </div>

        </div>

    </div>

</x-app-layout>
