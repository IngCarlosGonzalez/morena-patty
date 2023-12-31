<?php

namespace App\Http\Livewire\Catalogos\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

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

    public $cantidad  = 0;
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
    public $opcional;

    //--- Ejecuta método MOUNT cuando inicia el componente
    //
    public function mount()
    {
        $this->editando = new User();
        $this->registro = new User();
        $this->numerin = rand();
    }

    //--- Controla el ResetPage al modificar el buscador
    //
    public function updatingSearch()
    {
        $this->resetPage();
    }

    //--- Aplica la accion de LIMPIAR el buscador
    //
    public function limpiar()
    {
        $this->search = '';
    }

    //--- Aplica metodo de AGREGAR un nuevo registro
    //
    public function agregar(User $user)
    {
        $this->editando = $user;
        $this->resetValidation();
        $this->crear = true;
    }

    //--- Aplica la acción de EDITAR o checar el registro
    //
    public function editar(User $user)
    {
        $this->editando = $user;
        // Log::debug('Editando id... ' . $this->editando->id );

        $this->numerin = rand();
        $this->resetValidation();

        $this->folio = $this->editando->id;
        $this->name = $this->editando->name;
        $this->password = "aqui nueva password";
        $this->encriptada = $this->editando->password;
        $this->email = $this->editando->email;
        $this->imagen = null;
        $this->urlfoto = $this->editando->profile_photo_path;
        $this->lafoto = null;
        $this->opcional = 0;

        // la foto actual se puede sustituir
        //Log::debug('path foto actual... ' . $this->urlfoto );

        // se arma link a la imagen actual
        if (!is_null($this->urlfoto) ) {
            if (Storage::disk('digitalocean')->exists($this->urlfoto)) {
                $this->lafoto = "https://archivosdoctorsmate.nyc3.digitaloceanspaces.com/" . $this->urlfoto;
                //Log::debug('Se debe mostrar... ' . $this->lafoto);
            }
        }

        $privilegio = $this->editando->roles()->first()->name;

        if (is_null($privilegio) ) {
            $privilegio = "*sinrole*";
        }

        if ($privilegio == 'superusuario') {
            $this->clave_role = 1;
        } elseif ($privilegio == 'usuariocomun') {
            $this->clave_role = 2;
        } elseif ($privilegio == 'usuariomovil') {
            $this->clave_role = 3;
        } else {
            $this->clave_role = 0;
        }

        $this->abrir = true;
    }

    //--- reglas de validación aplicables
    // 
    protected $rules = [
        'name' => 'required|string|min:4|max:30',
        'password' => 'required|string|min:8|max:20',
        'email' => 'required|email|unique:users',
        'imagen' => 'required|image|mimes:jpeg,jpg|max:1024',
        'clave_role' => 'required|digits:1|in:1,2,3',
    ];

    //--- Procesa accion de INSERCIÓN del nuevo registro
    // 
    public function procesar()
    {

        // Log::debug('Registrando nuevo... ');

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

        // procsamiento de foto
        //Log::debug('prepara foto');
        $paquete = new ImageManager();
        $ajustada = $paquete->make($this->imagen)->resize(144, 192)->encode('jpg');

        // $size = $ajustada->filesize();
        // $mime = $ajustada->mime();
        // Log::debug("tamaño img:  " . $size . "   tipo: " . $mime);

        $this->folder = 'morena-patty/usuarios';
        $archivo = $this->folder . "/" . $this->imagen->hashName();
        // Log::debug('nombre archivo: ' . $archivo);

        $this->path = $archivo;

        Storage::disk('digitalocean')->put($archivo, (string) $ajustada, 'public');

        // Log::debug('alta foto: ' . $this->path . ' --- ' );

        DB::transaction(function () {
            $nuevo = User::create(
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'email_verified_at' => now(),
                    'remember_token' => '',
                    'profile_photo_path' => $this->path,
                ]
            );

            if ($this->clave_role == 1) {
                $nuevo->assignRole('superusuario');
            } elseif ($this->clave_role == 2) {
                $nuevo->assignRole('usuariocomun');
            } elseif ($this->clave_role == 3) {
                $nuevo->assignRole('usuariomovil');
            } else {
                Log::debug('Se agrega sin asignar un rol. ');
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

    //--- Procesa accion de ACTUALIZAR nuevo registro
    // 
    public function cambios()
    {
        // Log::debug('Actualizando registro... ' . $this->folio . '   opción: ' . $this->opcional);

        if (is_null($this->opcional)) {
            $this->opcional = 0;
        }

        if ($this->opcional == 0) {
            $this->validate([
                'name' => 'required|string|min:4|max:30',
                'password' => 'required|string|min:8|max:20',
                'email' => 'required|email|unique:users,email,' . $this->folio,
                'imagen' => 'required|image|mimes:jpeg,jpg|max:1024',
                'clave_role' => 'required|digits:1|in:1,2,3',
            ]);
        } else {
            $this->validate([
                'name' => 'required|string|min:4|max:30',
                'password' => 'required|string|min:8|max:20',
                'email' => 'required|email|unique:users,email,' . $this->folio,
                'clave_role' => 'required|digits:1|in:1,2,3',
            ]);
        }
        
        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->name);
        $this->name = $this->mivariable;

        if (is_null($this->clave_role)) {
            $this->clave_role = 0;
        }
        
        // solo se cambia pwd ya encriptada si trae nuevo valor:
        //Log::debug('La password contiene... <' . $this->password . '>.   '); 
        if (!empty($this->password)) {
            //Log::debug('La password tecleada... <' . $this->password . '>.   ');  
            if ($this->password == "aqui nueva password") {
                //Log::debug('No se cambia la password... '); 
            } else {
                //Log::debug('Actualizando con password... ' . $this->password); 
                $this->encriptada = bcrypt($this->password);
            }
        }
        
        if ($this->imagen) {

            // se elimina la foto anterior
            if (!is_null($this->urlfoto) ) {
                if (Storage::disk('digitalocean')->exists($this->urlfoto)) {
                    // Log::debug('Eliminando... ' . $this->urlfoto );
                    Storage::disk('digitalocean')->delete($this->urlfoto);
                }
            }

            //--- procsamiento de nueva foto.-

            $paquete = new ImageManager(['driver' => 'gd']);
            $ajustada = $paquete->make($this->imagen)->resize(144, 192)->encode('jpg');

            // $ajustada = $this->imagen;
            $name = $this->imagen->hashName();

            // $size = $ajustada->filesize();
            // $mime = $ajustada->mime();
            // Log::debug("tamaño cambio:  " . $size . "   tipo: " . $mime);

            $this->folder = 'morena-patty/usuarios';
            $archivo = $this->folder . "/" . $name;
            // Log::debug('nombre archivo: ' . $archivo);

            $this->path = $archivo;

            $retorno = Storage::disk('digitalocean')
                ->put($archivo, $ajustada, 'public');

            if ($retorno) {
                // Log::debug('nueva foto: ' . $this->path . ' --- ' );
            } else {
                // Log::debug('no se pudo grabar la foto --- ' );
            }
            
        } else {

            // deja el mismo path actual, en su caso
            if (!is_null($this->urlfoto) ) {
                $this->path = $this->urlfoto;
            }

        }
                
        //$visibility = Storage::disk('digitalocean')->getVisibility($this->path);
        //Log::debug('sustituye con foto: ' . $this->path . '  ' . $visibility);

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
        } elseif ($this->clave_role == 2) {
            $this->registro->assignRole('usuariocomun');
        } elseif ($this->clave_role == 3) {
            $this->registro->assignRole('usuariomovil');
        } else {
            Log::debug('Se guarda sin asignar un rol. ');
        }

        $this->reset('name');
        $this->reset('password');
        $this->reset('email');
        $this->reset('clave_role');
        $this->reset('imagen');

        $this->numerin = rand();

        $this->refrescar();
        $this->emit('editadoOk');
        $this->abrir = false;
    }

    //--- Aplica la acción de ELIMINACIÓN al renglón
    // 
    public function delete(User $user)
    {
        $this->editando = $user;
        //Log::debug('Eliminando id... ' . $this->editando->id );

        $this->folio = $this->editando->id;
        $this->urlfoto = $this->editando->profile_photo_path;

        // se elimina la imagen actual
        if (!is_null($this->urlfoto) ) {
            if (Storage::disk('digitalocean')->exists($this->urlfoto)) {
                //Log::debug('Eliminando... ' . $this->urlfoto );
                Storage::disk('digitalocean')->delete($this->urlfoto);
            }
        }

        // elimina el role
        DB::table('model_has_roles')->where('model_id',$this->folio)->delete();

        // ahora si... elimina usuario
        $user->delete();

        // refresca y avisa
        $this->resetPage();
        $this->emit('deleteOk');
    }

    //--- Hace refresh del componente visual
    // 
    public function refrescar()
    {
        $this->render();
    }

    //--- Clasificción de registros asegún
    // 
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

    //--- Renderiza componente visual.-
    // 
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
