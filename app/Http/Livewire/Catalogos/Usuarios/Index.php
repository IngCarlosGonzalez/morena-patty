<?php

namespace App\Http\Livewire\Catalogos\Usuarios;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination;

    public $usuario;
    public $editando;

    public $crear = false;
    public $abrir = false;

    protected $listeners = ['agregar', 'delete', 'limpiar', 'refrescar'];

    public $deCuantos = 6;
    public $search = '';
    public $estatus = 2;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $elAviso = '';

    public $procesado = '';

    public $cantidad = 0;
    public $renglones = 0;
    public $ubicacion = '';

    public $name;
    public $password;
    public $email;
    public $clave_role;
    public $trampa;
    public $mivariable;

    // Ejecuta método MOUNT cuando inicia el componente
    public function mount()
    {
        $this->editando = new User();
    }

    // Controla el ResetPage al modificar el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Aplica la accion de LIMPIAR el buscador
    public function limpiar()
    {
        $this->search = '';
    }

    // Aplica la acción de CREAR un nuevo registro
    public function agregar(User $user)
    {
        $this->editando = $user;
        $this->crear = true;
    }

    // Aplica la acción de EDITAR o checar el registro
    public function editar(User $user)
    {
        $this->editando = $user;
        Log::debug('Editando id... ' . $this->editando->id );
        $this->abrir = true;
    }

    // reglas de validación aplicables
    protected $rules = [
        'name' => 'required|string|min:4|max:30',
        'password' => 'required|string|min:8|max:20',
        'email' => 'required|email',
    ];

    // Procesa accion de insertar nuevo registro
    public function procesar()
    {

        //Log::debug('Registrando nuevo... ');

        $this->validate();

        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->name);
        $this->name = $this->mivariable;

        if (is_null($this->clave_role)) {
            $this->clave_role = 0;
        }

        DB::transaction(function () {
            $nuevo = User::create(
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]
            );

            if ($this->clave_role == 1) {
                $nuevo->assignRole('superusuario');
                //Log::debug('Se dió de alta nuevo SU: ' . $nuevo->id);
            } else {
                $nuevo->assignRole('usuariocomun');
                //Log::debug('Se dió de alta user ID: ' . $nuevo->id);
            }
        });

        $this->reset('name');
        $this->reset('password');
        $this->reset('email');
        $this->reset('clave_role');

        $this->refrescar();
        $this->emit('procesaOk');
        $this->crear = false;
    }

    // Aplica la acción de DELETE al renglón
    public function delete(User $user)
    {
        $user->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    // Hace refresh del componente visual
    public function refrescar()
    {
        $this->render();
    }

    // Clasificción de registros asegún
    public function clasifica($porCual)
    {
        //Log::debug('Ordenando por... ' . $porCual);
        if ($this->sortear == $porCual) {
            if ($this->elOrden == 'asc') {
                $this->elOrden = 'desc';
            } else {
                $this->elOrden = 'asc';
            }
        } else {
            $this->sortear = $porCual;
            $this->elOrden = 'asc';
        }
        $this->refrescar();
    }


    public function render()
    {
        $this->cantidad = User::where(
            "name",
            "like",
            "%{$this->search}%"
        )->count();

        $usuarios = User::where(
            "name",
            "like",
            "%{$this->search}%"
        )->orderBy(
            $this->sortear,
            $this->elOrden
        )->paginate(
            $perPage = $this->deCuantos,
            $columns = ['*'],
            $pageName = 'usuarios'
        );

        return view('livewire.catalogos.usuarios.index')
            ->with(
                [
                    'users' => $usuarios,
                ]
            );
    }
}
