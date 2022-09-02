<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Morena Patty</title>

    <meta name="description" content="Morena-Patty Landing Page" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <!--Replace with your tailwind.css once created-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .gradient {
        background: linear-gradient(90deg, #300000 0%, #e31212 100%);
        }
    </style>

    @livewireStyles

</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">

    <nav id="header" style="background-color:rgb(9, 1, 1)" class="abslute w-full z-30 top-0 text-white">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="pl-4 flex items-center">
                <a class="toggleColour text-white no-underline hover:no-underline font-bold text-xl lg:text-2xl" href="#">
                <img class="w-6 md:w-12 border-2 border-white rounded-full" src="{{ asset('patty.jpg') }}" />
                </a>
                <span class="ml-4 text-red-300 text-bold text-2xl">Morena Patty</span>
            </div>
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
    </nav>

    <div class="pt-12">

        <div class="container px-3 mx-auto flex flex-col md:flex-row">

            <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
                <h1 class="mt-4 text-5xl font-bold leading-tight">
                    Patty González
                </h1>
                <h1 class="mb-4 text-5xl font-bold leading-tight">
                    Morena Coahuila
                </h1>
                <p class="leading-normal text-2xl mb-8">
                    Éste es mi sistema web personal
                </p>

                <div class="flex flex-col items-center mb-2">
                    <span class="animate-bounce">Te invito a unirte a mi Lista de Contactos</span>

                    @livewire('hacer-contacto')

                </div>

                <p class="hidden mb-16 md:block ml-16 leading-normal text-sm italic text-opacity-50 mt-1 ">
                    Gracias por registrarte
                </p>

            </div>

            <div class="flex flex-col w-full md:w-3/5 items-center">
                <div class="animate-pulse mt-4 md:mt-12">
                    <img src="{{ asset('logo4t3.png') }}" alt="logo de la 4t" class="h-24 md:h-48 border-2 border-black rounded-lg shadow-2xl">
                </div>
            </div>

        </div>

    </div>

    <div class="relative -mt-12 lg:-mt-24">
        <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                    d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                    opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
                </g>
                <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path
                    d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
                ></path>
                </g>
            </g>
        </svg>
    </div>

    <section class="bg-white border-b py-8">
        <div class="container max-w-5xl mx-auto m-8">
            <h2 class="w-full my-2 text-2xl md:text-5xl font-bold leading-tight text-center text-gray-800">
                Morena es mi pasión
            </h2>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-36 md:w-96 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap justify-center">
                <div class="w-full p-6">
                    <img class="w-full border-2 border-black rounded-xl" src="{{ asset('morena.jpg') }}" />
                </div>
            </div>
        </div>
    </section>

    <svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
            <g class="wave" fill="#f8fafc">
            <path
                d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z"
            ></path>
            </g>
            <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
            <g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" opacity="0.200000003"></path>
            </g>
            </g>
        </g>
        </g>
    </svg>

    <section class="container mx-auto text-center py-6 mb-12">

        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">
        A trabajar...
        </h2>

        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <h3 class="animate-bounce my-4 text-xl italic leading-tight">
        Solo para usuarios de mi oficina autorizados
        </h3>

        @if (Route::has('login'))
            <div class="block px-6 py-4">
                @auth
                <div class="flex flex-col items-center">
                    <span>Hola:&nbsp;&nbsp;{{ Auth::user()->name }}</span>
                    <button type="button" onclick="window.location.href='{{ url('/dashboard') }}'"  class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    EMPEZAR
                    </button>
                </div>
                @else
                    <button type="button" onclick="window.location.href='{{ route('login') }}'"  class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    Identificarse
                    </button>
                @endauth
            </div>
        @endif

    </section>

    <footer class="bg-black">
        <div class="container mx-auto px-8">
            <div class="w-full flex flex-row py-6">
                <div class="flex-1 mb-6 text-black">
                    <a class="text-pink-400 no-underline hover:no-underline text-xl lg:text-2xl" href="#">
                        &copy;calin_mx 2022
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts

</body>

</html>
