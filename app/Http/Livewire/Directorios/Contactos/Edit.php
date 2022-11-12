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
    public $mandado;

    public $editando;

    public $abrir;

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

    public $mivariable;


    //--- Preparativos antes de iniciar la edición.-  
    //
    public function mount($contacto)
    {
        $this->dedonde = session('contactos_edit', 'vacio');
        Log::debug('   Edita desde... ' . $this->dedonde);
        $this->editando = new Contacto();
        $this->editando = $contacto;
        Log::debug('   Abriendo id... ' . $this->editando->id);
    }


    //--- Acción al iniciar procesamiento.-
    //
    public function iniciar()
    {
        Log::debug('   iniciando... ');
    }


    //--- Abandonar la edición...v
    //
    public function abortar()
    {
        Log::debug('   aborta desde... ' . $this->dedonde);
        $this->emit('abortado');

        session(['hacia_coontactos' => 'edicion']);
        session(['contacto_editado' => $this->editando->id]);

        if ($this->dedonde == 'index1') {
            return redirect()->route('directorios.contactos.index', $this->editando->id);
        } elseif ($this->dedonde == 'index2') {
            return redirect()->route('directorios.contactos.index2', $this->editando->id);
        } else {
            return redirect('/');
        }
        
    }

    
    //--- Procesa accion de ACTUALIZAR el registro
    // 
    public function procesar()
    {
        Log::debug('Actualizando id... ' . $this->folio);

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

        Log::debug('   regresa ok desde... ' . $this->dedonde);
        $this->emit('procesaOk');

        session(['hacia_coontactos' => 'edicion']);
        session(['contacto_editado' => $this->folio]);

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
