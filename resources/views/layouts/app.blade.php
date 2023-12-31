<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SistemaMorenaPatty') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- recursos básicos -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles propios -->
        <style>

            .topnavv {
              overflow: hidden;
              background-color: #800000;
            }

            .topnavv a {
              float: left;
              display: block;
              color: #d36e6e;
              text-align: center;
              padding: 14px 16px;
              text-decoration: none;
              font-size: 17px;
            }

            .topnavv a:active {
              background-color: #500000;
              color: white;
            }

            .topnavv .icon {
              display: none;
            }

            .dropdownv {
              float: left;
              overflow: hidden;
            }

            .dropdownv .dropbtnv {
              font-size: 17px;
              border: none;
              outline: none;
              color: white;
              padding: 14px 16px;
              background-color: inherit;
              font-family: inherit;
              margin: 0;
            }

            .dropdownv-content {
              display: none;
              position: absolute;
              color: black;
              background-color: #f9f9f9;
              min-width: 160px;
              box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
              z-index: 1;
            }

            .dropdownv-content a {
              float: none;
              color: black;
              padding: 12px 16px;
              text-decoration: none;
              display: block;
              text-align: left;
            }

            .topnavv a:hover, .dropdownv:hover .dropbtnv {
              background-color: #555;
              color: white;
            }

            .dropdownv-content a:hover {
              background-color: rgb(234, 121, 121);
              color: black;
            }

            .dropdownv:hover .dropdownv-content {
              display: block;
            }

            .dropdownv-content a:active {
              background-color: #33362bd8;
              color: white;
            }

            @media screen and (max-width: 600px) {
              .topnavv a:not(:first-child), .dropdownv .dropbtnv {
                display: none;
              }
              .topnavv a.icon {
                float: right;
                display: block;
              }
            }

            @media screen and (max-width: 600px) {
              .topnavv.responsive {position: relative;}
              .topnavv.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
              }
              .topnavv.responsive a {
                float: none;
                display: block;
                text-align: left;
              }
              .topnavv.responsive .dropdownv {float: none;}
              .topnavv.responsive .dropdownv-content {position: relative;}
              .topnavv.responsive .dropdownv .dropbtnv {
                display: block;
                width: 100%;
                text-align: left;
              }
            }
        </style>

        @wireUiScripts

        <!-- estilos para Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        @livewireStyles

    </head>

    <body class="min-h-screen font-sans antialiased bg-gray-800">

        <div class="bg-black">

            <!-- Mi top navbar personal -->
            @if(@Auth::user()->hasRole('superusuario'))

                <!-- Navigation Links del Superusuario -->

                <div class="topnavv" id="myTopnav">

                    <div>
                        <a href="/" style="background-color: #c0c0c0">
                            <img src="https://morena.org/wp-content/uploads/2021/02/logo_retina.png" alt="Logo Oficial de MNorena" width="96" height="96">
                        </a>
                    </div>
                    
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('dashboard'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            onclick="window.location.href='{{ route('dashboard') }}'">
                            <i class="fa fa-home"></i>
                            &nbsp;&nbsp;INICIO&nbsp;&nbsp;
                        </button>
                    </div>

                    <!-- Catálogos del Sistema -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('catalogos.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >CATALOGOS
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('catalogos.usuarios.index') }}"
                            @if (request()->routeIs('catalogos.usuarios.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Usuarios</a>

                            <a href="{{ route('catalogos.owners.index') }}"
                            @if (request()->routeIs('catalogos.owners.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Propietarios</a>

                            <a href="{{ route('catalogos.categorias.index') }}"
                            @if (request()->routeIs('catalogos.categorias.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Categorias</a>

                        </div>
                    </div>

                    <!-- Manejo de Contactos -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('directorios.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >CONTACTOS
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('directorios.subscribers.index') }}"
                            @if (request()->routeIs('directorios.subscribers.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            style="color: #000055;"
                            >Lista de Prospectos</a>

                            <br>

                            <a href="{{ route('directorios.contactos.create') }}"
                            @if (request()->routeIs('directorios.contactos.create'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Nuevo Contacto</a>

                            <a href="{{ route('directorios.contactos.index2') }}"
                            @if (request()->routeIs('directorios.contactos.index2'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Mis Contactos</a>

                            <a href="{{ route('directorios.contactos.index') }}"
                            @if (request()->routeIs('directorios.contactos.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Lista Global</a>

                            {{-- <a href="{{ route('directorios.documentos.index') }}"
                            @if (request()->routeIs('directorios.documentos.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Expedientes</a> --}}

                        </div>
                    </div>

                    <!-- Control de Visitantes -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('oficinas.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >VISITANTES
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('oficinas.visitas.create') }}"
                            @if (request()->routeIs('oficinas.visitas.create'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Registrar Visita</a>

                            <a href="{{ route('oficinas.visitas.index') }}"
                            @if (request()->routeIs('oficinas.visitas.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Listado de Visitas</a>

                            {{-- <a href="#"
                            >Seguimiento</a> --}}

                        </div>
                    </div>

                    <!-- Manejo de Agenda -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('controles.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >AGENDA
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('controles.agendas.index') }}"
                            @if (request()->routeIs('controles.agendas.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Mi Agenda</a>

                            {{-- <a href="#"
                            >Mis Compromisos</a>

                            <a href="#"
                            >Otra Agenda</a>

                            <a href="#"
                            >Lista General</a> --}}

                        </div>
                    </div>

                    <!-- Salir del Sistema -->
                    <div class="dropdownv">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropbtnv">
                                &nbsp;&nbsp;SALIR&nbsp;&nbsp;
                                <i class="fa fa-arrow-circle-o-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="dropdownv">
                        <div class="dropbtnv"style="color: #fff;">
                            <div class="flex flex-col md:pl-12 xl:pl-24">
                                <span id="fechadehoy" class="text-base text-yellow-500 "></span>
                            </div>
                        </div>
                    </div>

                    <!-- Utilities de Usuario -->
                    <div class="dropdownv md:pl-12 xl:pl-24">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('users.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >{{  Auth::user()->name }}
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="#"
                            @if (request()->routeIs('users.utilities.password'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >MI PASSWORD</a>

                            <a href="#"
                            @if (request()->routeIs('users.utilities.refuerzo'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >SEGURIDAD</a>

                        </div>
                    </div>

                    <div>
                        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
                    </div>

                </div>

            @elseif(@Auth::user()->hasRole('usuariocomun'))

                <!-- Navigation Links del Usuario Común -->

                <div class="topnavv" id="myTopnav">

                    <div>
                        <a href="/" style="background-color: #c0c0c0">
                            <img src="https://morena.org/wp-content/uploads/2021/02/logo_retina.png" alt="Logo Oficial de MNorena" width="96" height="96">
                        </a>
                    </div>

                    <div class="dropdownv">
                        <button class="dropbtnv" onclick="window.location.href='{{ route('dashboard') }}'">
                            <i class="fa fa-home"></i>
                            &nbsp;&nbsp;INICIO&nbsp;&nbsp;
                        </button>
                    </div>

                    <!-- Manejo de Contactos -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('directorios.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >CONTACTOS
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('directorios.contactos.create') }}"
                            @if (request()->routeIs('directorios.contactos.create'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Agregar Nuevo</a>

                            <a href="{{ route('directorios.contactos.index2') }}"
                            @if (request()->routeIs('directorios.contactos.index2'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Mis Contactos</a>

                            {{-- <a href="#"
                            >otras opciones</a> --}}

                        </div>
                    </div>

                    <!-- Manejo de Agenda -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('controles.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >AGENDA
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('controles.agendas.index') }}"
                            @if (request()->routeIs('controles.agendas.index'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Mi Agenda</a>

                            {{-- <a href="#"
                            >Compromisos</a> --}}

                        </div>
                    </div>

                    <!-- Salir del Sistema -->
                    <div class="dropdownv">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropbtnv">
                                &nbsp;&nbsp;SALIR&nbsp;&nbsp;
                                <i class="fa fa-arrow-circle-o-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="dropdownv">
                        <button class="dropbtnv"style="color: #fff;">
                            <span id="fechadehoy" class="text-base text-yellow-500 md:pl-12 xl:pl-24"></span>
                        </button>
                    </div>

                    <!-- Utilities de Usuario -->
                    <div class="dropdownv md:pl-12 xl:pl-24">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('users.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >{{  Auth::user()->name }}
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="#"
                            @if (request()->routeIs('users.utilities.password'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >MI PASSWORD</a>

                            <a href="#"
                            @if (request()->routeIs('users.utilities.refuerzo'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >SEGURIDAD</a>
                        </div>
                    </div>

                    <div>
                        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
                    </div>

                </div>

            @else

                <!-- Navigation Links del Usuario MOVIL -->

                <div class="topnavv" id="myTopnav">

                    <div>
                        <a href="/" style="background-color: #c0c0c0">
                            <img src="https://morena.org/wp-content/uploads/2021/02/logo_retina.png" alt="Logo Oficial de MNorena" width="96" height="96">
                        </a>
                    </div>

                    <div class="dropdownv">
                        <button class="dropbtnv" onclick="window.location.href='{{ route('dashboard') }}'">
                            <i class="fa fa-home"></i>
                            &nbsp;&nbsp;INICIO&nbsp;&nbsp;
                        </button>
                    </div>

                    <!-- Manejo de Contactos -->
                    <div class="dropdownv">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('directorios.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >CONTACTOS
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="{{ route('directorios.contactos.create') }}"
                            @if (request()->routeIs('directorios.contactos.create'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >Agregar Nuevo</a>

                            {{-- <a href="#"
                            >otras opciones</a> --}}

                        </div>
                        
                    </div>

                    <!-- Salir del Sistema -->
                    <div class="dropdownv">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropbtnv">
                                &nbsp;&nbsp;SALIR&nbsp;&nbsp;
                                <i class="fa fa-arrow-circle-o-right"></i>
                            </button>
                        </form>
                    </div>

                    <div class="dropdownv">
                        <button class="dropbtnv"style="color: #fff;">
                            <span id="fechadehoy" class="text-base text-yellow-500 md:pl-12 xl:pl-24"></span>
                        </button>
                    </div>

                    <!-- Utilities de Usuario -->
                    <div class="dropdownv md:pl-12 xl:pl-24">
                        <button
                            class="dropbtnv"
                            @if (request()->routeIs('users.*'))
                            style="background-color: #330000;"
                            @else
                            style="color: #fff;"
                            @endif
                            >{{  Auth::user()->name }}
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdownv-content">

                            <a href="#"
                            @if (request()->routeIs('users.utilities.password'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >MI PASSWORD</a>

                            <a href="#"
                            @if (request()->routeIs('users.utilities.refuerzo'))
                            style="background-color: #aa0000; color:#fff;"
                            @endif
                            >SEGURIDAD</a>
                        </div>
                    </div>

                    <div>
                        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
                    </div>

                </div>

            @endif

            @livewireScripts

            <!-- Page Content -->
            <main>

                {{ $slot }}

            </main>

            <footer style="background-color: #800000">
                <div class="container px-8 mx-auto">
                    <div class="flex flex-row w-full py-6">
                        <div class="flex-1 mb-2">
                            <a class="text-base text-red-400 no-underline hover:no-underline" href="#">
                                &copy;calin_mx 2022
                            </a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

        @stack('modals')

        {{-- mas scripts --}}

        <script>
            function myFunction() {
              var x = document.getElementById("myTopnav");
              if (x.className === "topnavv") {
                x.className += " responsive";
              } else {
                x.className = "topnavv";
              }
            }
        </script>

        <script>
            console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>');
            const meses = ["Ene.","Feb.","Mar.","Abr.","Mayo","Jun.","Jul.","Ago.","Sep.","Oct.","Nov.","Dic."];
            const hoydia = new Date();
            let eldia = hoydia.getDate();
            let elmes = meses[hoydia.getMonth()];
            let elano = hoydia.getFullYear();
            const lafecha = eldia + " de " + elmes + " de " + elano;
            console.log(lafecha);
            var xxx = document.getElementById("fechadehoy");
            xxx.innerHTML = lafecha;
        </script>

    </body>

</html>
