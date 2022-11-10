<?php

namespace App\Http\Livewire\Directorios\Contactos;

use App\Models\User;
use App\Models\Owner;
use Livewire\Component;
use App\Models\Contacto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $crear = false;

    protected $listeners = ['refrescar'];

    public $user_ident;
    public $datos_user = null;
    public $ident_owner;
    public $datos_owner = null;
    public $leyenda_top;
    public $owner_nombre;
    public $owner_status;
    public $mostrar_boton;
    public $condicionador;
    public $owner_id;

    public $cvetipos = [];
    public $origenes = [];
    public $categos = [];
    public $generos = [];

    public $clave_tipo;
    public $clave_origen;
    public $categoria_id;
    public $clasificacion;
    public $clave_genero;

    public $datos_catego = null;

    public $nombre_full;
    public $domicilio_full;
    public $telefono_fijo;
    public $telefono_movil;
    public $tiene_watsapp = 0;
    public $correo_electronico;

    public $trampa;
    public $mivariable;


    //--- Preparativos al iniciar la ejecución.-  
    //
    public function mount()
    {
        $this->condicionador = false;
        // Log::debug('Usuario actual... ' . Auth::user()->id);

        $this->datos_user = new User();
        $this->datos_owner = new Owner();

        $this->user_ident = Auth::user()->id;
        $this->datos_user = User::find($this->user_ident);

        // Log::debug('Usuario nombre... ' . $this->datos_user->name);

        $data = DB::table('owners')
                ->where('user_id', $this->user_ident)
                ->first();

        if ($data == null) {
            $this->ident_owner = 0;
            $this->owner_nombre = "¿¿¿¿¿¿¿ x ???????";
        } else {
            $this->ident_owner = $data->id;
            $this->owner_nombre = $data->nombre_titular;
            // Log::debug('Datos de owner... ' . $this->ident_owner . '    ' . $this->owner_nombre);
        }

        if (is_null($this->ident_owner)) {

            // Log::debug('User: ' . $this->user_ident . ' el owner es nulo...');
            $this->mostrar_boton = false;
            $this->condicionador = true;
            $this->leyenda_top = "No se puede procesar...";
            $this->owner_nombre = "*NO ES PROPIETARIO*";
            $this->crear = false;
            session()->flash('nosepuede', 'Función no permitida.');

        } else {

            if ($this->ident_owner < 1) {

                // Log::debug('User: ' . $this->user_ident . ' No es un Owner...');
                $this->mostrar_boton = false;
                $this->condicionador = true;
                $this->leyenda_top = "No se puede procesar...";
                $this->owner_nombre = "-NO ES PROPIETARIO-";
                $this->crear = false;
                session()->flash('nosepuede', 'Función no permitida.');

            } else {
    
                $this->datos_owner = $this->datos_user->owner;
                
                $this->owner_status = $this->datos_owner->esta_vigente;

                if (is_null($this->owner_status)) {
                    $this->owner_status = 0;
                }

                if ($this->owner_status < 1) {

                    // Log::debug('User: ' . $this->user_ident . ' es el Owner: ' . $this->ident_owner . ' pero está INACTIVO!!!');
                    $this->mostrar_boton = false;
                    $this->condicionador = true;
                    $this->leyenda_top = "No se puede procesar...";
                    $this->owner_nombre = "*ESTÁ INACTIVO*";
                    $this->crear = false;
                    session()->flash('nosepuede', 'Función no permitida.');

                } else {

                    // Log::debug('User: ' . $this->user_ident . ' es el Owner: ' . $this->ident_owner . ' activo...');
                    $this->mostrar_boton = true;
                    $this->condicionador = false;
                    $this->leyenda_top = "Procesando con Propietario...";
                    $this->owner_nombre = $this->datos_owner->nombre_titular;

                    $this->agregar();

                }

            }

        }
    }


    //--- Aplica la acción de EVALUAR procesamiento.-
    //
    public function evaluar(){
        if ($this->mostrar_boton == false) {
            $this->dispatchBrowserEvent('ejecuta');
        }
    }


    //--- Agregar los elementos de un nuevo registro.-
    //
    public function agregar()
    {
        $this->resetValidation();

        $this->owner_id = $this->ident_owner;

        $this->clave_tipo = null;
        $this->clave_origen = null;
        $this->clave_genero = null;
        $this->categoria_id = null;
        $this->clasificacion = null;

        $this->nombre_full = '';
        $this->domicilio_full = '';
        $this->telefono_fijo = '';
        $this->telefono_movil = '';
        $this->tiene_watsapp = 0;
        $this->correo_electronico = '';

        $this->crear = true;
    }


    //--- Procesa accion de INSERCIÓN del nuevo registro.-
    //
    public function procesar()
    {
        //Log::debug('Registrando nuevo... ');

        $this->validate([
            'clave_tipo' => 'required|string',
            'clave_origen' => 'required|string',
            'clave_genero' => 'required|string',
            'categoria_id' => 'required|integer|min:1|not_in:0,-1',
            'nombre_full' => 'required|string|min:10|max:60',
            'domicilio_full' => 'required|string|min:10|max:90',
            'telefono_fijo' => 'required|digits:10',
            'telefono_movil' => 'required|digits:10',
            'correo_electronico' => 'email|max:80',
        ]);

        if (!is_null($this->trampa)) {
            Log::debug('Trapped... ');
            return redirect('/');
        }

        $this->clasificacion = '';
        $this->datos_catego = Categoria::find($this->categoria_id);
        $this->clasificacion = $this->datos_catego->clasificacion;

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->nombre_full);
        $this->nombre_full = $this->mivariable;
        $this->mivariable = strtoupper($this->domicilio_full);
        $this->domicilio_full = $this->mivariable;
        $this->mivariable = strtolower($this->correo_electronico);
        $this->correo_electronico = $this->mivariable;

        DB::transaction(function () {
            $nuevo = Contacto::create([
                'owner_id'              => $this->owner_id,
                'esta_vigente'          => 1,
                'clave_tipo'            => $this->clave_tipo,
                'clave_origen'          => $this->clave_origen,
                'categoria_id'          => $this->categoria_id,
                'clasificacion'         => $this->clasificacion,
                'comite_base'           => 'No Aplica',
                'comite_rol'            => 'No Aplica',
                'defensores'            => 'No Aplica',
                'miembro_fundador'      => 0,
                'nombre_full'           => $this->nombre_full,
                'localidad_mpio'        => '',
                'domicilio_full'        => $this->domicilio_full,
                'colonia_catalogada'    => 0,
                'colonia_id'            => 4469,
                'municipio_id'          => 39,
                'telefono_fijo'         => $this->telefono_fijo,
                'telefono_movil'        => $this->telefono_movil,
                'tiene_watsapp'         => $this->tiene_watsapp,
                'direccion_email'       => $this->correo_electronico,
                'tiene_facebook'        => 0,
                'tiene_instagram'       => 0,
                'tiene_telegram'        => 0,
                'tiene_twitter'         => 0,
                'tiene_otra_red'        => 0,
                'clave_genero'          => $this->clave_genero,
                'distrito_fed'          => 0,
                'distrito_local'        => 0,
                'numero_de_ruta'        => 0,
                'numero_seccion'        => 0,
                'seccion_prioritaria'   => 0,
                'anotaciones'           => 'Contacto recién agregado',
                'user_id'               => Auth::user()->id
            ]);
            //Log::debug('on: ' . $nuevo->id);
        }, $deadlockRetries = 5);

        $this->reset('clave_tipo');
        $this->reset('clave_origen');
        $this->reset('clave_genero');
        $this->reset('categoria_id');
        $this->reset('clasificacion');

        $this->reset('nombre_full');
        $this->reset('domicilio_full');
        $this->reset('telefono_fijo');
        $this->reset('telefono_movil');
        $this->reset('tiene_watsapp');
        $this->reset('correo_electronico');

        $this->refrescar();
        $this->emit('procesaOk');
        $this->crear = false;

        return redirect()->route('directorios.contactos.create');
    }


    // Hace refresh del componente visual.-
    //
    public function refrescar()
    {
        $this->render();
    }


    //--- Publicación de la vista.-
    //
    public function render()
    {
        $this->cvetipos = Contacto::CLAVE_TIPO;
        $this->origenes = Contacto::CLAVE_ORIGEN;
        $this->generos = Contacto::CLAVE_GENERO;

        $this->categos = DB::table('categorias')
            ->select('id as cat_id', 'clasificacion as clasif')
            ->get();
        
        return view('livewire.directorios.contactos.create')
        ->with(
            [
                'cvetipos' => $this->cvetipos,
                'origenes' => $this->origenes,
                'categos' => $this->categos,
                'generos' => $this->generos,
            ]
        );
    }
}
