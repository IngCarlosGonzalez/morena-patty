<?php

namespace App\Http\Livewire\Catalogos\Owners;

use App\Models\User;
use App\Models\Owner;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $usuario;
    public $editando;
    public $registro;
    public $catalogado;

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
    public $user_id;
    public $user_name;
    public $esta_vigente;
    public $area_o_depto;
    public $nombre_titular;
    public $puesto_titular;
    public $trampa;
    public $mivariable;

    // Ejecuta método MOUNT cuando inicia el componente
    public function mount()
    {
        $this->editando = new Owner();
        $this->registro = new Owner();
        $this->catalogado = new User();
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
    public function agregar(Owner $owner)
    {
        $this->editando = $owner;
        $this->resetValidation();
        $this->esta_vigente = 1;
        $this->crear = true;
    }


    // Aplica la acción de EDITAR o checar el registro
    public function editar(Owner $owner)
    {
        $this->editando = $owner;
        Log::debug('Editando id... ' . $this->editando->id );

        $this->resetValidation();

        $this->folio          = $this->editando->id;
        $this->user_id        = $this->editando->user_id;
        $this->esta_vigente   = $this->editando->esta_vigente;
        $this->area_o_depto   = $this->editando->area_o_depto;
        $this->nombre_titular = $this->editando->nombre_titular;
        $this->puesto_titular = $this->editando->puesto_titular;

        $this->catalogado = User::find($this->user_id);
        $this->user_name = $this->catalogado->name;

        $this->abrir = true;
    }

    // Controla el Reset de campos al cerrar el modal de EDITAR
    public function updatedAbrir()
    {
        if (!$this->abrir) {
            $this->reset('user_id');
            $this->reset('esta_vigente');
            $this->reset('area_o_depto');
            $this->reset('nombre_titular');
            $this->reset('puesto_titular');
            $this->reset('user_name');
        }
    }

    // Procesa accion de INSERCIÓN del nuevo registro
    public function procesar()
    {
        // Log::debug('Registrando nuevo... ');

        $this->validate([
            'user_id' => 'required|integer|min:1|not_in:0,-1',
            'area_o_depto' => 'required|string|min:6|max:40',
            'nombre_titular' => 'required|string|min:6|max:40',
            'puesto_titular' => 'required|string|min:6|max:40',
        ]);

        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->area_o_depto);
        $this->area_o_depto = $this->mivariable;
        $this->mivariable = strtoupper($this->nombre_titular);
        $this->nombre_titular = $this->mivariable;
        $this->mivariable = strtoupper($this->puesto_titular);
        $this->puesto_titular = $this->mivariable;

        if (is_null($this->esta_vigente)) {
            $this->esta_vigente = 0;
        }

        DB::transaction(function () {
            Owner::create(
                [
                    'user_id'        => $this->user_id,
                    'esta_vigente'   => $this->esta_vigente,
                    'area_o_depto'   => $this->area_o_depto,
                    'nombre_titular' => $this->nombre_titular,
                    'puesto_titular' => $this->puesto_titular,
                ]
            );
        });

        $this->reset('user_id');
        $this->reset('esta_vigente');
        $this->reset('area_o_depto');
        $this->reset('nombre_titular');
        $this->reset('puesto_titular');

        $this->refrescar();
        $this->emit('procesaOk');
        $this->crear = false;
    }


    // Procesa accion de ACTUALIZAR nuevo registro
    public function cambios()
    {
        Log::debug('Actualizando registro... ' . $this->folio);

        $this->validate([
            'area_o_depto' => 'required|string|min:6|max:40',
            'nombre_titular' => 'required|string|min:6|max:40',
            'puesto_titular' => 'required|string|min:6|max:40',
        ]);
        
        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable     = strtoupper($this->area_o_depto);
        $this->area_o_depto   = $this->mivariable;
        $this->mivariable     = strtoupper($this->nombre_titular);
        $this->nombre_titular = $this->mivariable;
        $this->mivariable     = strtoupper($this->puesto_titular);
        $this->puesto_titular = $this->mivariable;

        if (is_null($this->esta_vigente)) {
            $this->esta_vigente = 0;
        }

        $this->registro = Owner::find($this->folio);

        $this->registro->update(
            [
                'user_id'        => $this->user_id,
                'esta_vigente'   => $this->esta_vigente,
                'area_o_depto'   => $this->area_o_depto,
                'nombre_titular' => $this->nombre_titular,
                'puesto_titular' => $this->puesto_titular,
            ]
        );

        $this->reset('user_id');
        $this->reset('esta_vigente');
        $this->reset('area_o_depto');
        $this->reset('nombre_titular');
        $this->reset('puesto_titular');

        $this->reset('user_name');

        $this->refrescar();
        $this->emit('editadoOk');
        $this->abrir = false;
    }


    // Aplica la acción de ELIMINACIÓN al renglón
    public function delete(Owner $owner)
    {
        $this->editando = $owner;
        //Log::debug('Eliminando id... ' . $this->editando->id );

        $this->folio = $this->editando->id;

        // elimina el registro
        $owner->delete();

        // refresca y avisa
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
        $libres = DB::table('users')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('owners')
                      ->whereColumn('owners.user_id', 'users.id');
            })
            ->select('id as ident', 'name as nombre')
            ->get();

        $this->cantidad = Owner::where(
            "nombre_titular",
            "like",
            "%{$this->search}%"
        )->count();

        $acuales = Owner::where(
            "nombre_titular",
            "like",
            "%{$this->search}%"
        )->orderBy(
            $this->sortear,
            $this->elOrden
        )->paginate(
            $perPage = $this->deCuantos,
            $columns = ['*'],
            $pageName = 'owners'
        );

        return view('livewire.catalogos.owners.index')
            ->with(
                [
                    'acuales' => $acuales,
                    'libres' => $libres,
                ]
            );
    }
}
