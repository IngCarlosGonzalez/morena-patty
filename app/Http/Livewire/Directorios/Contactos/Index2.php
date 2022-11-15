<?php

namespace App\Http\Livewire\Directorios\Contactos;

use App\Models\User;
use App\Models\Owner;
use Livewire\Component;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Index2 extends Component
{
    use WithPagination;

    public $dedonde;
    public $mandado;
    public $paginan;
    public $renglon;
    
    public $editando;
    public $registro;

    public $urlactual;
    public $valorengs;

    public $iteracion;
    public $paginanum;

    public $rengs = [];

    public $crear = false;
    public $abrir = false;

    protected $listeners = ['delete', 'limpiar', 'editar'];

    public $deCuantos = '6';
    public $search    = '';
    public $estatus   = 2;

    protected $queryString = [
        'search' => ['except' => ''],
        'deCuantos' => ['except' => '6'],
    ];

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $delTipo   = '';
    public $delOrigen = '';
    public $delaCateg = 0;

    public $likeTipo   = '';
    public $likeOrigen = '';
    public $likeCateg1 = 0;
    public $likeCateg2 = 9999;
    
    public $cvetipos = [];
    public $origenes = [];
    public $categos  = [];
    public $generos  = [];

    public $elAviso   = '';
    public $procesado = '';

    public $cantidad  = 0;
    public $renglones = 0;

    public $folio = 0;
    
    public $user_ident;
    public $datos_user = null;
    public $ident_owner;
    public $datos_owner = null;
    public $leyenda_top;
    public $owner_nombre;
    public $owner_status;
    public $mostrar_boton;
    public $condicionador;
    public $notifica_rech;


    //--- Ejecuta método MOUNT 
    //
    public function mount()
    {
        // recibe parametros de sesión con o sin datos...
        $this->dedonde = session('hacia_coontactos', 'vacio');
        $this->mandado = session('contacto_editado', 0);
        $this->paginan = session('contacto_paginan', 0);
        $this->renglon = session('contacto_renglon', 0);
        Log::debug('Abre indice2 desde... ' . $this->dedonde . '  con id: ' . $this->mandado);
        Log::debug('     arrastra PAGE: ' . $this->paginan . '  y RENG: ' . $this->renglon);

        // resetea contenido de parámetros de sesión...
        session(['hacia_coontactos' => 'vacio']);
        session(['contacto_editado' => 0]);
        session(['contacto_paginan' => 0]);
        session(['contacto_renglon' => 0]);

        // Log::debug('Usuario actual... ' . Auth::user()->id);
        $this->editando = new Contacto();
        $this->registro = new Contacto();
        $this->likeTipo   = '%';
        $this->likeOrigen = '%';
        $this->likeCateg1 =  0;
        $this->likeCateg2 =  9999;

        //--- desde aqui checa que el user sea un owner 
        $this->condicionador = false;
        
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
            $this->condicionador = true;
            $this->notifica_rech = 'El dato de owner es nulo.';

        } else {

            if ($this->ident_owner < 1) {

                // Log::debug('User: ' . $this->user_ident . ' No es un Owner...');
                $this->condicionador = true;
                $this->notifica_rech = 'El usuario no es un owner.';

            } else {
    
                $this->datos_owner = $this->datos_user->owner;
                
                $this->owner_status = $this->datos_owner->esta_vigente;

                if (is_null($this->owner_status)) {
                    $this->owner_status = 0;
                }

                if ($this->owner_status < 1) {

                    // Log::debug('User: ' . $this->user_ident . ' es el Owner: ' . $this->ident_owner . ' pero está INACTIVO!!!');
                    $this->condicionador = true;
                    $this->notifica_rech = 'El owner no se encuentra activo.';

                } else {

                    // Log::debug('User: ' . $this->user_ident . ' es el Owner: ' . $this->ident_owner . ' activo...');
                    $this->condicionador = false;
                    session()->flash('msgindex2', 'El owner si está activo.');

                }

            }

        }

    }

    //--- Ejecuta método INICIALIZA 
    //
    public function inicializa()
    {
        Log::debug('Inicializando listado index2... ');

        if ($this->condicionador == true) {
            // Log::debug('Redireccionando... ');
            return redirect()->route('directorios.contactos.avisos');
        }
        
        // checa si viene de "edicion" y si trae PAGE redirige a ella.-
        if ($this->dedonde == 'vacio') {
            Log::debug('      no viene de editar');
        } else {
            if ($this->paginan > 0) {
                $ubicacion = '/directorios/contactos/index2?rengs=' . $this->paginan;
                return redirect()->to($ubicacion);
            } else {
                $ubicacion = '/directorios/contactos/index2';
                return redirect()->to($ubicacion);
            }
        }

        // Pendiente ver como reposicionarse en el ID del RENG...

    }


    //--- Activa el ResetPage al modificar el buscador
    //
    public function updatingSearch()
    {
        $this->resetPage();
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

    //--- rastreo del atributo publico updatedValorengs
    //
    public function updatedValorengs()
    {
        Log::debug('>>> Valor Rengs... ' . $this->valorengs);
    }

    //--- Redirige hacia EDICIÓN del renglón actual...
    //
    public function editar(Contacto $contacto, $acualreng, Request $request)
    {
        $this->editando = $contacto;
        $this->iteracion = $acualreng;
        $this->urlactual = $request->fullUrl();

        $this->folio = $this->editando->id;
        $this->paginanum = $this->valorengs;

        Log::debug('Activandel desde URL... ' . $this->urlactual);
        Log::debug('Edit id: ' . $this->folio . '  en renglon: ' . $this->iteracion . '  de pagina: ' . $this->paginanum);

        //-- preparación de variables de sesión.-
        Log::debug('Redireccionando desde: Index2... ');
        session(['contactos_edit_from' => 'index2']);
        session(['contactos_edit_page' => $this->paginanum]);
        session(['contactos_edit_reng' => $this->iteracion]);
        Log::debug('   Parametros... PAGE: ' . $this->paginanum . ' RENG: ' . $this->iteracion);

        //-- redireccionar hacia ruta EDIT con el parámetro: Objeto Contacto.-
        return redirect()->route('directorios.contactos.edit', $this->editando);

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

    //--- Renderiza la vista
    //
    public function render()
    {
        $this->cvetipos = Contacto::CLAVE_TIPO;
        $this->origenes = Contacto::CLAVE_ORIGEN;
        $this->generos  = Contacto::CLAVE_GENERO;

        $this->categos = DB::table('categorias')
            ->select('id as cat_id', 'clasificacion as clasif')
            ->get();
        
        //--- Contabiliza registros mostrables... 
        $this->cantidad = Contacto::where(
            "owner_id",
            "=",
            $this->ident_owner
        )->where(
            "nombre_full",
            "like",
            "%{$this->search}%"
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
            "owner_id",
            "=",
            $this->ident_owner
        )->where(
            "nombre_full",
            "like",
            "%{$this->search}%"
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
        )->withQueryString();

        //Log::debug('Leidos... ' . $this->rengs->count());

        return view('livewire.directorios.contactos.index2', [
            'rengs' => $this->rengs,
            'cvetipos' => $this->cvetipos,
            'origenes' => $this->origenes,
            'categos' => $this->categos,
            'generos' => $this->generos,
        ]);
    }
}
