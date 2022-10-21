<?php

namespace App\Http\Livewire\Catalogos\Usuarios;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $usuario;
    public $editando;
    public $registro;

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

    public $folio;
    public $name;
    public $password;
    public $encritada;
    public $email;
    public $clave_role;
    public $trampa;
    public $mivariable;
    public $privilegio;

    public $imagen;
    public $folder;
    public $path;
    public $numerin;
    public $urlfoto;
    public $lafoto;

    // Ejecuta método MOUNT cuando inicia el componente
    public function mount()
    {
        $this->editando = new User();
        $this->registro = new User();
        $this->numerin = rand();
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

        $this->folio = $this->editando->id;
        $this->name = $this->editando->name;
        $this->password = "";
        $this->encriptada = $this->editando->password;
        $this->email = $this->editando->email;
        $this->imagen = "";
        $this->urlfoto = $this->editando->profile_photo_path;
        $this->lafoto = null;

        // la foto actual se va a eliminar
        Log::debug('path foto... ' . $this->urlfoto );

        $privilegio = $this->editando->roles()->first()->name;
        if (is_null($privilegio) ) {
            $privilegio = "*sinrole*";
        }
        if ($privilegio == 'superusuario') {
            $this->clave_role = 1;
        } else {
            $this->clave_role = 0;
        }

        $this->abrir = true;
    }

    // reglas de validación aplicables
    protected $rules = [
        'name' => 'required|string|min:4|max:30',
        'password' => 'required|string|min:8|max:20',
        'email' => 'required|email',
        'imagen' => 'required|image|max:2048',
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

        $this->folder = 'morena-patty/usuarios/';
        $this->path = Storage::disk('digitalocean')->put($this->folder, $this->imagen);
        Log::debug('nueva foto: ' . $this->path . '  ');

        DB::transaction(function () {
            $nuevo = User::create(
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'profile_photo_path' => $this->path,
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
        $this->reset('imagen');

        $this->numerin = rand();

        $this->refrescar();
        $this->emit('procesaOk');
        $this->crear = false;
    }

    // Procesa accion de ACTUALIZAR nuevo registro
    public function cambios()
    {

        Log::debug('Actualizando registro... ' . $this->folio);

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

        if (!empty($this->password)) {
            $this->encriptada = Hash::make($this->password);
        }
        
        if (!is_null($this->urlfoto) ) {
            Storage::disk('digitalocean')->delete($this->urlfoto);
        }

        $this->folder = 'morena-patty/usuarios/';
        $this->path = Storage::disk('digitalocean')->put($this->folder, $this->imagen);
        Log::debug('la foto: ' . $this->path . '  ');

        $this->registro = User::find($this->folio);

        $this->registro->update(
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->encriptada,
                'profile_photo_path' => $this->path,
            ]
        );

        DB::table('model_has_roles')->where('model_id',$this->folio)->delete();

        if ($this->clave_role == 1) {
            $this->registro->assignRole('superusuario');
        } else {
            $this->registro->assignRole('usuariocomun');
        }

        $this->refrescar();
        $this->emit('editadoOk');
        $this->abrir = false;
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
