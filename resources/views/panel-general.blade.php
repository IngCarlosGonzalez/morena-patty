<x-app-layout>

    <div style="background-color: #000000" class="flex flex-col items-center h-screen pb-4 mx-auto mt-2 max-w-7xl md:mt-1 md:pb-2">

        <div class="flex flex-row w-full">

            <div class="hidden w-1/12 md:block">
                <span></span>
            </div>

            <div class="flex flex-col w-full md:w-10/12 place-content-center">

                @php
                    $lafoto = null;
                    $urlfoto = Auth::user()->profile_photo_path;
                    if (!is_null($urlfoto) ) {
                        if (Storage::disk('digitalocean')->exists($urlfoto)) {
                            $lafoto = "https://archivosdoctorsmate.nyc3.digitaloceanspaces.com/" . $urlfoto;
                        }
                    }
                @endphp

                <div class="flex flex-col items-center justify-center mt-12 text-2xl text-white bg-gray-800 shadow md:rounded-3xl md:text-5xl">
                    <h1 class="py-4 font-bold text-center "> 
                        Damos la bienvenida a:&nbsp;&nbsp;{{ Auth::user()->name }}
                    </h1>
                    <div class="mx-8 my-4">
                        @if ($lafoto)
                            <img class="w-32 h-48" src="{{ $lafoto }}" alt="aqui va la foto actual">
                        @else
                            <x-heroicon-o-user-add class="w-32 h-48"/>
                        @endif
                    </div>
                </div>

                <div style="background-color: #500000" class="mt-8 text-2xl text-white shadow md:rounded-3xl md:text-6xl">
                    <h1 class="py-4 font-bold text-center md:py-24">Inicio del Sistema</h1>
                </div>

            </div>

            <div class="hidden w-1/12 md:block">
                <span></span>
            </div>

        </div>

    </div>

</x-app-layout>
