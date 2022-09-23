<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Contacto;
use App\Models\Subscriber;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $subscriber;
    public $editando;
    public $contacto;

    public $abrir = false;

    protected $listeners = ['delete', 'limpiar', 'refrescar', 'ejecutaBulk'];

    public $marcado = 0;
    public $todos = 0;
    public $acual = 0;
    public $ocultar = 0;

    public $deCuantos = 6;
    public $search = '';
    public $estatus = 2;

    public $itemsMarcados = [];

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

    // Ejecuta método MOUNT cuando inicia el componente
    public function mount()
    {
        $this->editando = new Subscriber();
        $this->contacto = new Contacto();
        $this->itemsMarcados = [];
        $this->emit('desmarcar');
    }

    // Controla el cambio de valor de opcion TODOS
    public function updatedTodos()
    {
        if ($this->todos == 1) {
            Log::debug('... Se marcaron todos... ');
            $this->itemsMarcados = [];
            $this->emit('marcarall');
        } else {
            Log::debug('... Todos se desmarcaron... ');
            $this->itemsMarcados = [];
            $this->emit('desmarcar');
        }
    }

    // Controla cambio de valor del FILTRO de OCULTAR
    public function updatedOcultar()
    {
        if ($this->ocultar == 1) {
            Log::debug('... Se ocultan convertidos... ');
            $this->estatus = 1;
            $this->refrescar();
        } else {
            Log::debug('... Se muestran convertidos... ');
            $this->estatus = 2;
            $this->refrescar();
        }
    }

    // Controla el ResetPage al modificar el buscador
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Controla el cambio en array de Items MArcados
    public function updatedItemsMarcados($id)
    {
        Log::debug('... Se marcó el Item... ' . count($id) . ' --- ' . $this->itemsMarcados[count($id) - 1]);
    }

    // Aplica la accion global de ELIMINACIÓN en LOTE
    public function ejecutaBulk()
    {
        Log::debug('... Se activó Bulk Action... ');
        if ($this->todos == 1) {
            Log::debug('... Eliminando todos los registros asegún ... ');
            Subscriber::where(
                "nombre_full",
                "like",
                "%{$this->search}%"
            )->where(
                "paso_a_contacto",
                "<",
                $this->estatus
            )->delete();
            $this->itemsMarcados = [];
            $this->resetPage();
            $this->emit('bulkOk');
            $this->refrescar();
        } else {
            if (!empty($this->itemsMarcados)) {
                Subscriber::whereIn('id', $this->itemsMarcados)->delete();
                $this->itemsMarcados = [];
                $this->resetPage();
                $this->emit('bulkOk');
                $this->refrescar();
            } else {
                $this->itemsMarcados = [];
                $this->resetPage();
                $this->emit('bulkNope');
                $this->refrescar();
            }
        }
    }

    // Aplica la accion de LIMPIAR el buscador
    public function limpiar()
    {
        Log::debug('... Se activó Limpiar Search... ');
        $this->search = '';
    }

    // Aplica la acción de EDITAR o checar el registro
    public function editar(Subscriber $subscriber)
    {
        $this->editando = $subscriber;
        $this->procesado = "Editando ID  " . $this->editando->id;
        $this->abrir = true;
    }

    // Procesa accion de CONVERTIR prospecto en contacto
    public function procesar(Subscriber $subscriber)
    {
        $this->editando = $subscriber;

        if ($this->editando->paso_a_contacto == 1) {
            Log::debug('Esta ya estaba registrado: ' . $this->editando->nombre_full);
        } else {
            $this->procesado = "Procesado ID  " . $this->editando->id;
            Log::debug('Registrando: ' . $this->editando->nombre_full);

            $this->ubicacion = $subscriber->localidad_municipio . ' ' . $subscriber->entidad_federativa;

            DB::transaction(function () {
                $contacto = Contacto::create([
                    'owner_id'              => 2,
                    'esta_vigente'          => 1,
                    'clave_tipo'            => 'General',
                    'clave_origen'          => 'En mi Página',
                    'categoria_id'          => 1,
                    'clasificacion'         => 'GENERAL',
                    'comite_base'           => 'No Aplica',
                    'comite_rol'            => 'No Aplica',
                    'defensores'            => 'No Aplica',
                    'miembro_fundador'      => 0,
                    'nombre_full'           => $this->editando->nombre_full,
                    'localidad_mpio'        => $this->ubicacion,
                    'domicilio_full'        => $this->editando->colonia_o_sector,
                    'colonia_catalogada'    => 0,
                    'colonia_id'            => 4469,
                    'municipio_id'          => 39,
                    'telefono_movil'        => $this->editando->telefono_movil,
                    'tiene_watsapp'         => $this->editando->tiene_watsapp,
                    'direccion_email'       => $this->editando->correo_electronico,
                    'tiene_facebook'        => 0,
                    'tiene_instagram'       => 0,
                    'tiene_telegram'        => 0,
                    'tiene_twitter'         => 0,
                    'tiene_otra_red'        => 0,
                    'clave_genero'          => 'Sin Datos',
                    'distrito_fed'          => 0,
                    'distrito_local'        => 0,
                    'numero_de_ruta'        => 0,
                    'numero_seccion'        => 0,
                    'seccion_prioritaria'   => 0,
                    'anotaciones'           => 'Conversión de Prospecto a Contacto',
                    'user_id'               => Auth::user()->id
                ]);
                $this->contacto->id = $contacto->id;
                Log::debug('Se dió de alta contacto con ID: ' . $contacto->id);
            });

            $this->editando->observaciones = 'Se convirtió en Contacto';
            $this->editando->paso_a_contacto = 1;
            $this->editando->contacto_id = $this->contacto->id;

            $this->editando->save();
            $this->refrescar();
            $this->emit('procesaOk');
            $this->abrir = false;
        }
    }

    // Aplica la acción de DELETE al renglón
    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    // Hace refresh del componente visual
    public function refrescar()
    {
        $this->elAviso = 'recargando ...';
        $this->render();
    }

    // Clasificción de registros asegún
    public function clasifica($porCual)
    {
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

    // Renderiza el componente visual
    public function render()
    {
        $this->cantidad = Subscriber::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
        )->where(
            "paso_a_contacto",
            "<",
            $this->estatus
        )->count();

        $subscribers = Subscriber::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
        )->where(
            "paso_a_contacto",
            "<",
            $this->estatus
        )->orderBy(
            $this->sortear,
            $this->elOrden
        )->paginate(
            $perPage = $this->deCuantos,
            $columns = ['*'],
            $pageName = 'prospectos'
        );

        return view('livewire.directorios.subscribers.index')
            ->with(
                [
                    'subscribers' => $subscribers,
                ]
            );
    }
}
