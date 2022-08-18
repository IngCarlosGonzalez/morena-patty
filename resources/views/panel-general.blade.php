<x-app-layout>

    <div class="py-12">

        <div style="background-color: #aa0000" class="max-w-7xl mx-auto h-screen mt-4 md:mt-2 pb-24 md:pb-5">

            <div class="w-full bg-gray-800 pt-3">
                <div class="md:rounded-3xl bg-black p-1 shadow text-2xl md:text-5xl text-white">
                    <h1 class="font-bold pl-6 pt-6 mb-8"> Damos la bienvenida a:&nbsp;&nbsp;{{ Auth::user()->name }}</h1>
                </div>
            </div>

            <div class="w-full bg-gray-800 pt-8 flex flex-row justify-center ">
                <div class="md:rounded-3xl pt-8 pb-4 shadow text-2xl md:text-6xl text-white">
                    <h1 class="font-bold mb-12"> PANEL DE CONTROL </h1>
                </div>
            </div>

        </div>

    </div>

</x-app-layout>
