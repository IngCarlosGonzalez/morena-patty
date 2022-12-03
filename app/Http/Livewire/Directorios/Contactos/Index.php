<?php

namespace App\Http\Livewire\Directorios\Contactos;

use Livewire\Component;
use App\Models\Contacto;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $dedonde;
    public $mandado;

    public $editando;
    public $registro;

    public $rengs = [];

    public $crear = false;
    public $abrir = false;

    protected $listeners = ['delete', 'limpiar', 'editar'];

    public $deCuantos = 6;
    public $search    = '';
    public $estatus   = 2;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $delPropie = 0;
    public $delTipo   = '';
    public $delOrigen = '';
    public $delaCateg = 0;

    public $likeTipo   = '';
    public $likeOrigen = '';
    public $likeCateg1 = 0;
    public $likeCateg2 = 9999;
    public $likePropi1 = 0;
    public $likePropi2 = 9999;
    
    public $propiets = [];
    public $cvetipos = [];
    public $origenes = [];
    public $categos  = [];
    public $generos  = [];

    public $elAviso   = '';
    public $procesado = '';

    public $cantidad  = 0;
    public $renglones = 0;

    public $folio = 0;


    //--- Ejecuta método MOUNT 
    //
    public function mount()
    {
        // recibe parametros de sesión con o sin datos...
        // $this->dedonde = session('hacia_coontactos', 'vacio');
        // $this->mandado = session('contacto_editado', 0);
        // Log::debug('Abre indice1 desde... ' . $this->dedonde . '  con id: ' . $this->mandado);
        // resetea contenido de parámetros de sesión...
        // session(['hacia_coontactos' => 'vacio']);
        // session(['contacto_editado' => 0]);

        $this->editando = new Contacto();
        $this->registro = new Contacto();
        $this->likeTipo   = '%';
        $this->likeOrigen = '%';
        $this->likeCateg1 =  0;
        $this->likeCateg2 =  9999;
    }


    //--- Ejecuta método INICIALIZA 
    //
    public function inicializa()
    {
        Log::debug('...... ');
    }

    //--- Activa el ResetPage al modificar el buscador
    //
    public function updatingSearch()
    {
        $this->resetPage();
    }

    //--- Preparacion para select con Propietario...
    //
    public function updatedDelPropie()
    {
        // Log::debug('seleccionar owner... ' . $this->delPropie);
        if ($this->delPropie == 0) {
            $this->likePropi1 =  0;
            $this->likePropi2 =  9999;
        } else {
            $this->likePropi1 = $this->delPropie - 1;
            $this->likePropi2 = $this->delPropie + 1;
        }
    }

    //--- Preparacion para select con Tipo...
    //
    public function updatedDelTipo()
    {
        // Log::debug('seleccionar tipo... ' . $this->delTipo);
        if ($this->delTipo == '') {
            $this->likeTipo = '%';
        } else {
            $this->likeTipo = $this->delTipo;
        }
    }

    //--- Preparacion para select con Origen...
    //
    public function updatedDelOrigen()
    {
        // Log::debug('seleccionar otigen... ' . $this->delOrigen);
        if ($this->delOrigen == '') {
            $this->likeOrigen = '%';
        } else {
            $this->likeOrigen = $this->delOrigen;
        }
    }

    //--- Preparacion para select con Categoria...
    //
    public function updatedDelaCateg()
    {
        // Log::debug('seleccionar categ... ' . $this->delaCateg);
        if ($this->delaCateg == 0) {
            $this->likeCateg1 =  0;
            $this->likeCateg2 =  9999;
        } else {
            $this->likeCateg1 = $this->delaCateg - 1;
            $this->likeCateg2 = $this->delaCateg + 1;
        }
    }

    //--- Aplica la accion de LIMPIAR el buscador
    //
    public function limpiar()
    {
        $this->search = '';
    }

    //--- Redirige hacia EDICIÓN del renglón actual...
    //
    public function editar(Contacto $contacto)
    {
        $this->editando = $contacto;

        $this->folio = $this->editando->id;

        Log::debug('Eniado desde idx1 el id... ' . $this->folio);

        //-- redireccionar hacia ruta EDIT con el parámetro: Objeto Contacto
        // Log::debug('Redireccionando desde Index1... ');
        // session(['contactos_edit_from' => 'index1']);
        // return redirect()->route('directorios.contactos.edit', [$this->editando]);

        //--- opcion preferida... abre modal.-



    }





    
    //--- Aplica la acción de ELIMINACIÓN al renglón
    //
    public function delete(Contacto $contacto)
    {
        $this->editando = $contacto;

        $this->folio = $this->editando->id;
        // Log::debug('Eliminando id... ' . $this->folio);

        $contacto->delete();

        // refresca y avisa
        $this->resetPage();
        $this->emit('deleteOk');
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
    }


    //--- Renderiza la vista ...
    //
    public function render()
    {
        $this->propiets = DB::table('owners')
        ->select('id as own_id', 'nombre_titular as nombre')
        ->get();
    
        $this->cvetipos = Contacto::CLAVE_TIPO;
        $this->origenes = Contacto::CLAVE_ORIGEN;
        $this->generos  = Contacto::CLAVE_GENERO;

        $this->categos = DB::table('categorias')
            ->select('id as cat_id', 'clasificacion as clasif')
            ->get();
        
        $this->cantidad = Contacto::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
        )->where(
            "owner_id",
            ">",
            $this->likePropi1
        )->where(
            "owner_id",
            "<",
            $this->likePropi2
        )->where(
            "clave_tipo",
            "like",
            $this->likeTipo
        )->where(
            "clave_origen",
            "like",
            $this->likeOrigen
        )->where(
            "categoria_id",
            ">",
            $this->likeCateg1
        )->where(
            "categoria_id",
            "<",
            $this->likeCateg2
        )->count();

        //Log::debug('Contador... ' . $this->cantidad);

        $this->rengs = Contacto::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
        )->where(
            "owner_id",
            ">",
            $this->likePropi1
        )->where(
            "owner_id",
            "<",
            $this->likePropi2
        )->where(
            "clave_tipo",
            "like",
            $this->likeTipo
        )->where(
            "clave_origen",
            "like",
            $this->likeOrigen
        )->where(
            "categoria_id",
            ">",
            $this->likeCateg1
        )->where(
            "categoria_id",
            "<",
            $this->likeCateg2
        )->orderBy(
            $this->sortear,
            $this->elOrden
        )->paginate(
            $perPage = $this->deCuantos,
            $columns = ['*'],
            $pageName = 'rengs'
        );

        //Log::debug('Leidos... ' . $this->rengs->count());

        return view('livewire.directorios.contactos.index', [
            'rengs' => $this->rengs,
            'cvetipos' => $this->cvetipos,
            'origenes' => $this->origenes,
            'categos' => $this->categos,
            'generos' => $this->generos,
        ]);
    }
}
