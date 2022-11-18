<?php

namespace App\Http\Livewire\Directorios\Contactos;

use Livewire\Component;
use App\Models\Contacto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Edit extends Component
{
    public $dedonde;
    public $conpagina;
    public $conrenglo;
    public $mandado;
    
    public Contacto $editando;
    public $folio;

    public $abrir;

    public $cvetipos = [];
    public $origenes = [];
    public $categos = [];
    public $generos = [];

    // public $clave_tipo;
    // public $clave_origen;
    // public $categoria_id;
    // public $clasificacion;
    // public $clave_genero;

    public $datos_catego = null;

    // public $nombre_full;
    // public $domicilio_full;
    // public $telefono_fijo;
    // public $telefono_movil;
    // public $tiene_watsapp = 0;
    // public $correo_electronico;

    public $mivariable;


    //--- Preparativos antes de iniciar la edición.-  
    //
    public function mount($contacto)
    {
        $this->dedonde = session('contactos_edit_from', 'vacio');
        // Log::debug('   Edita desde... ' . $this->dedonde);
        $this->conpagina = session('contactos_edit_page', 0);
        $this->conrenglo = session('contactos_edit_reng', 0);
        // Log::debug('   Reciiendo... PAGE: ' . $this->conpagina . ' RENG: ' . $this->conrenglo);

        $this->editando = $contacto;
        $this->folio = $this->editando->id;
        Log::debug('   Abriendo id... ' . $this->folio);

    }


    //--- Acción al iniciar procesamiento.-
    //
    public function iniciar()
    {
        // Log::debug('   Iniciando edit... ');
        if ($this->dedonde == 'vacio') {
            Log::debug('      no puede procesar... VACIO');
            return redirect('/');
        }
    }


    //--- Abandonar la edición...
    //
    public function abortar()
    {
        Log::debug('Proceso abortado desde... ' . $this->dedonde);
        $this->emit('abortado');

        session(['hacia_coontactos' => 'edicion']);
        session(['contacto_editado' => $this->editando->id]);
        session(['contacto_paginan' => $this->conpagina]);
        session(['contacto_renglon' => $this->conrenglo]);

        if ($this->dedonde == 'index1') {
            return redirect()->route('directorios.contactos.index', $this->editando->id);
        } elseif ($this->dedonde == 'index2') {
            return redirect()->route('directorios.contactos.index2', $this->editando->id);
        } else {
            return redirect('/');
        }
        
    }


    protected $rules = [
        'editando.clave_tipo' => 'required|string',
        'editando.clave_origen' => 'required|string',
        'editando.clave_genero' => 'required|string',
        'editando.categoria_id' => 'required|integer|min:1|not_in:0,-1',
        'editando.nombre_full' => 'required|string|min:10|max:60',
        'editando.domicilio_full' => 'required|string|min:10|max:90',
        'editando.telefono_fijo' => 'required|digits:10',
        'editando.telefono_movil' => 'required|digits:10',
        'editando.tiene_watsapp' => 'required|digits:1',
        'editando.direccion_email' => 'required|email|max:80',
    ];
    
    //--- Procesa accion de ACTUALIZAR el registro
    // 
    public function procesar()
    {
        Log::debug('Actualizando id... ' . $this->folio);

        $this->validate();

        $this->editando->clasificacion = '';
        $this->datos_catego = Categoria::find($this->editando->categoria_id);
        $this->editando->clasificacion = $this->datos_catego->clasificacion;


        $this->mivariable = '';
        $this->mivariable = strtoupper($this->editando->nombre_full);
        $this->editando->nombre_full = $this->mivariable;
        $this->mivariable = strtoupper($this->editando->domicilio_full);
        $this->editando->domicilio_full = $this->mivariable;
        $this->mivariable = strtolower($this->editando->direccion_email);
        $this->editando->direccion_email = $this->mivariable;

        $this->editando->save();
        Log::debug('   regresa ok desde... ' . $this->dedonde);
        $this->emit('procesaOk');

        session(['hacia_coontactos' => 'edicion']);
        session(['contacto_editado' => $this->folio]);
        session(['contacto_paginan' => $this->conpagina]);
        session(['contacto_renglon' => $this->conrenglo]);

        if ($this->dedonde == 'index1') {
            return redirect()->route('directorios.contactos.index', $this->editando->id);
        } elseif ($this->dedonde == 'index2') {
            return redirect()->route('directorios.contactos.index2', $this->editando->id);
        } else {
            return redirect('/');
        }

    }


    //--- Renderizar la vista...
    //
    public function render()
    {
        $this->cvetipos = Contacto::CLAVE_TIPO;
        $this->origenes = Contacto::CLAVE_ORIGEN;
        $this->generos = Contacto::CLAVE_GENERO;

        $this->categos = DB::table('categorias')
            ->select('id as cat_id', 'clasificacion as clasif')
            ->get();
        
        return view('livewire.directorios.contactos.edit')
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
