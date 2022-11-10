<div wire:init = "inicializa">
    
    {{-- componente para avisos de mis contactos --}}

    <div class="mt-36 ml-64">

        <span class="font-bold text-4xl text-red-500">

            No se puede procesar ésta función.

        </span>

        <div class="mt-16 font-bold text-2xl text-yellow-500">

            <span>
                {{ $contenido }}
            </span>

        </div>

    </div>

    {{-- este es un swal de rechazo  --}}
    <script>

        window.addEventListener('notif_d_c_i_2', () => {

            console.log('<< se rechaza >>');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'px-12 py-3 my-8 text-black text-3xl font-extrabold border-2 rounded-md border-gray-600 bg-gray-400 hover:bg-gray-200'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Deshabilitado!',
                text: 'El Usuario Actual Debe ser Propietario.',
                icon: 'error',
                width: 600,
                padding: '3em',
                color: '#ffff00',
                background: '#ff0000',
                showConfirmButton: true,
                confirmButtonText: 'CERRAR',
                timer: 5000
            })

        })

    </script>

</div>
