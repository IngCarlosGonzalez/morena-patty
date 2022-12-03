<?php

namespace App\Http\Livewire\Directorios\Contactos;

use App\Models\User;
use App\Models\Owner;
use Livewire\Component;
use App\Models\Contacto;
use App\Models\Categoria;
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
    public $cueristri;

    public $iteracion;
    public $paginanum;

    public $rengs = [];

    public $crear = false;
    public $abrir = false;

    protected $listeners = ['delete', 'limpiar', 'editar'];

    public $deCuantos = '6';
    public $search    = '';
    public $estatus   = 2;

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $delTipo   = '';
    public $delOrigen = '';
    public $delaCateg = 0;

    public $likeTipo   = '';
    public $likeOrigen = '';
    public $likeCateg1 = 0;
    public $likeCateg2 = 9999;

    protected $queryString = [
        'search'     => ['except' => ''],
        'deCuantos'  => ['as' => 'pp'],
        'sortear'    => ['as' => 'sx'],
        'elOrden'    => ['as' => 'ad'],
        'likeTipo'   => ['as' => 'kt'],
        'likeOrigen' => ['as' => 'ko'],
        'likeCateg1' => ['as' => 'c1'],
        'likeCateg2' => ['as' => 'c2'],
    ];

    public $parametbu;
    public $parametpp;
    public $parametsx;
    public $parametad;
    public $parametkt;
    public $parametko;
    public $parametc1;
    public $parametc2;

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

    //---atributos livewire para edicion...

    public $clave_tipo;
    public $clave_origen;
    public $categoria_id;
    public $clasificacion;
    public $clave_genero;

    public $nombre_full;
    public $domicilio_full;
    public $telefono_fijo;
    public $telefono_movil;
    public $tiene_watsapp = 0;
    public $direccion_email;



    public $mivariable;


    //--- Ejecuta método MOUNT 
    //
    public function mount()
    {
        // // recibe parametros de sesión con o sin datos...
        // $this->dedonde = session('hacia_coontactos', 'vacio');
        // $this->mandado = session('contacto_editado', 0);
        // $this->paginan = session('contacto_paginan', 0);
        // $this->renglon = session('contacto_renglon', 0);

        // // estos son de prueba quedan pendientes...
        // $this->parametbu = session('contactos_edit_p_bu', '');
        // $this->parametpp = session('contactos_edit_p_pp', 6);
        // $this->parametsx = session('contactos_edit_p_sx', 'id');
        // $this->parametad = session('contactos_edit_p_ad', 'asc');
        // $this->parametkt = session('contactos_edit_p_kt', '');
        // $this->parametko = session('contactos_edit_p_ko', '');
        // $this->parametc1 = session('contactos_edit_p_c1', 0);
        // $this->parametc2 = session('contactos_edit_p_c2', 9999);
        // Log::debug('Abre indice2 desde... ' . $this->dedonde . '  con id: ' . $this->mandado);
        // Log::debug('     arrastra PAGE: ' . $this->paginan . '  y RENG: ' . $this->renglon);
        
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
        // Log::debug('Inicializando listado index2... ');

        // --------------------------------------------------------------

        if ($this->condicionador == true) {
            Log::debug('No tiene permiso en index... ');
            return redirect()->route('directorios.contactos.avisos');
        }

        // --------------------------------------------------------------

        // //--- checa si viene de "edicion" y si trae PAGE redirige a ella.-
        // if ($this->dedonde == 'vacio') {
        //     Log::debug('     no viene de editar');
        // } else {
        //     $rutaorigen = '/directorios/contactos/index2';
        //     $parametros = '';
            
        //     if ($this->paginan > 0) {
        //         if ($parametros == '') {
        //             $parametros = '?rengs=' . $this->paginan;
        //         } else {
        //             $parametros = $parametros . '&rengs=' . $this->paginan;
        //         }
        //     }
            
        //     if ($this->parametbu == '') {
        //         $this->search = '';
        //     } else {
        //         $this->search = $this->parametbu;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?search=' . $this->search;
        //     } else {
        //         $parametros = $parametros . '&search=' . $this->search;
        //     }
            
        //     if ($this->parametpp > 0) {
        //         $this->deCuantos = $this->parametpp;
        //     } else {
        //         $this->deCuantos = 6;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?pp=' . $this->deCuantos;
        //     } else {
        //         $parametros = $parametros . '&pp=' . $this->deCuantos;
        //     }
            
        //     if ($this->parametsx == '') {
        //         $this->sortear = 'id';
        //     } else {
        //         $this->sortear = $this->parametsx;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?sx=' . $this->sortear;
        //     } else {
        //         $parametros = $parametros . '&sx=' . $this->sortear;
        //     }
            
        //     if ($this->parametad == '') {
        //         $this->elOrden = 'asc';
        //     } else {
        //         $this->elOrden = $this->parametad;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?ad=' . $this->elOrden;
        //     } else {
        //         $parametros = $parametros . '&ad=' . $this->elOrden;
        //     }

        //     if ($this->parametkt == '') {
        //         $this->delTipo = '';
        //         $this->likeTipo = '';
        //         $this->parametkt = '%';
        //     } else {
        //         $this->delTipo = $this->parametkt;
        //         $this->likeTipo = $this->parametkt;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?kt=' . $this->parametkt;
        //     } else {
        //         $parametros = $parametros . '&kt=' . $this->parametkt;
        //     }

        //     if ($this->parametko == '') {
        //         $this->delOrigen = '';
        //         $this->likeOrigen = '';
        //         $this->parametko = '%';
        //     } else {
        //         $paso = str_ireplace("+", " ", $this->parametko);
        //         $this->delOrigen = $paso;
        //         $this->likeOrigen = $paso;
        //         $paso = str_ireplace(" ", "+", $this->parametko);
        //         $this->parametko = $paso;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?ko=' . $this->parametko;
        //     } else {
        //         $parametros = $parametros . '&ko=' . $this->parametko;
        //     }

        //     if ($this->parametc1 > 0) {
        //         $this->likeCateg1 = $this->parametc1;
        //     } else {
        //         $this->likeCateg1 = 0;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?c1=' . $this->likeCateg1;
        //     } else {
        //         $parametros = $parametros . '&c1=' . $this->likeCateg1;
        //     }
                        
        //     if ($this->parametc2 > 0) {
        //         $this->delaCateg = $this->parametc2 - 1;
        //         $this->likeCateg2 = $this->parametc2;
        //     } else {
        //         $this->delaCateg = 0;
        //         $this->likeCateg2 = 0;
        //     }
        //     if ($parametros == '') {
        //         $parametros = '?c2=' . $this->likeCateg2;
        //     } else {
        //         $parametros = $parametros . '&c2=' . $this->likeCateg2;
        //     }
            
        //     // resetea contenido de parámetros de sesión...
        //     session(['hacia_coontactos' => 'vacio']);
        //     session(['contacto_editado' => 0]);
        //     session(['contacto_paginan' => 0]);
        //     session(['contacto_renglon' => 0]);
        //     session(['contactos_edit_p_bu' => null]);
        //     session(['contactos_edit_p_pp' => null]);
        //     session(['contactos_edit_p_sx' => null]);
        //     session(['contactos_edit_p_ad' => null]);
        //     session(['contactos_edit_p_kt' => null]);
        //     session(['contactos_edit_p_ko' => null]);
        //     session(['contactos_edit_p_c1' => null]);
        //     session(['contactos_edit_p_c2' => null]);

        //     if ($parametros == '') {
        //         $ubicacion = $rutaorigen;
        //     } else {
        //         $ubicacion = $rutaorigen . $parametros;
        //     }
        //     return redirect()->to($ubicacion);

        // }

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
        // Log::debug('>>> Valor Rengs... ' . $this->valorengs);
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

        Log::debug('Eniado desde idx2 el id... ' . $this->folio);

        // // pruebas para arastrar paraetros...
        // Log::debug('>>> QueryString... ' . $this->cueristri);
        // $this->parametbu = $this->search;
        // $this->parametpp = $this->deCuantos;
        // $this->parametsx = $this->sortear;
        // $this->parametad = $this->elOrden;
        // $this->parametkt = $this->likeTipo;
        // $this->parametko = $this->likeOrigen;
        // $this->parametc1 = $this->likeCateg1;
        // $this->parametc2 = $this->likeCateg2;
        // Log::debug('Activando desde URL... ' . $this->urlactual);
        // Log::debug('Edit id: ' . $this->folio . '  en renglon: ' . $this->iteracion . '  de pagina: ' . $this->paginanum);
        // //-- preparación de variables de sesión.-
        // Log::debug('Redireccionando desde: Index2... ');
        //
        // session(['contactos_edit_from' => 'index2']);
        // session(['contactos_edit_page' => $this->paginanum]);
        // session(['contactos_edit_reng' => $this->iteracion]);
        //
        // session(['contactos_edit_p_bu' => $this->parametbu]);
        // session(['contactos_edit_p_pp' => $this->parametpp]);
        // session(['contactos_edit_p_sx' => $this->parametsx]);
        // session(['contactos_edit_p_ad' => $this->parametad]);
        // session(['contactos_edit_p_kt' => $this->parametkt]);
        // session(['contactos_edit_p_ko' => $this->parametko]);
        // session(['contactos_edit_p_c1' => $this->parametc1]);
        // session(['contactos_edit_p_c2' => $this->parametc2]);
        // Log::debug('   Parametros... PAGE: ' . $this->paginanum . ' RENG: ' . $this->iteracion);
        // Log::debug('   BU: ' . $this->parametbu . ' PP: ' . $this->parametpp . ' SX: ' . $this->parametsx . ' AD: ' . $this->parametad);
        // Log::debug('   KT: ' . $this->parametkt . ' KO: ' . $this->parametko . ' C1: ' . $this->parametc1 . ' C2: ' . $this->parametc2);
        //
        //-- redireccionar hacia ruta EDIT con el parámetro: Objeto Contacto.-
        // return redirect()->route('directorios.contactos.edit', $this->editando);

        //--- opcion preferida... abre modal.-

        $this->resetValidation();

        $this->name = $this->editando->name;



    }


    
    //--- Abandonar la edición...
    //
    public function abortar()
    {
        Log::debug('Proceso abortado desde... ' . $this->dedonde);
        $this->emit('abortado');
        $this->abrir = false;

        // session(['hacia_coontactos' => 'edicion']);
        // session(['contacto_editado' => $this->editando->id]);
        // session(['contacto_paginan' => $this->conpagina]);
        // session(['contacto_renglon' => $this->conrenglo]);
        //
        // if ($this->dedonde == 'index1') {
        //     return redirect()->route('directorios.contactos.index', $this->editando->id);
        // } elseif ($this->dedonde == 'index2') {
        //     return redirect()->route('directorios.contactos.index2', $this->editando->id);
        // } else {
        //     return redirect('/');
        // }
        
    }


    protected $rules = [
        'clave_tipo' => 'required|string',
        'clave_origen' => 'required|string',
        'clave_genero' => 'required|string',
        'categoria_id' => 'required|integer|min:1|not_in:0,-1',
        'nombre_full' => 'required|string|min:10|max:60',
        'domicilio_full' => 'required|string|min:10|max:90',
        'telefono_fijo' => 'required|digits:10',
        'telefono_movil' => 'required|digits:10',
        'tiene_watsapp' => 'required|digits:1',
        'direccion_email' => 'required|email|max:80',
    ];
    

    //--- Procesa accion de ACTUALIZAR el registro
    // 
    public function procesar()
    {
        Log::debug('Actualizando id... ' . $this->folio);
                
        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->validate();

        $this->clasificacion = '';
        $this->datos_catego = Categoria::find($this->categoria_id);
        $this->clasificacion = $this->datos_catego->clasificacion;

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->nombre_full);
        $this->nombre_full = $this->mivariable;
        $this->mivariable = strtoupper($this->domicilio_full);
        $this->domicilio_full = $this->mivariable;
        $this->mivariable = strtolower($this->direccion_email);
        $this->direccion_email = $this->mivariable;

        $this->editando->save();

        $this->emit('procesaOk');

        // Log::debug('   regresa ok desde... ' . $this->dedonde);
        // session(['hacia_coontactos' => 'edicion']);
        // session(['contacto_editado' => $this->folio]);
        // session(['contacto_paginan' => $this->conpagina]);
        // session(['contacto_renglon' => $this->conrenglo]);
        //
        // if ($this->dedonde == 'index1') {
        //     return redirect()->route('directorios.contactos.index', $this->editando->id);
        // } elseif ($this->dedonde == 'index2') {
        //     return redirect()->route('directorios.contactos.index2', $this->editando->id);
        // } else {
        //     return redirect('/');
        // }

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
