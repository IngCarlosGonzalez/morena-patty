<?php

namespace App\Http\Livewire\Directorios\Contactos;

use App\Models\Contacto;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $editando;
    public $registro;

    public $rengs = [];

    public $crear = false;
    public $abrir = false;

    protected $listeners = ['delete', 'limpiar'];

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

    public $folio;

    //--- Ejecuta método MOUNT 
    //
    public function mount()
    {
        $this->editando = new Contacto();
        $this->registro = new Contacto();
    }

    //--- Activa el ResetPage al modificar el buscador
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

    //--- Aplica la acción de ELIMINACIÓN al renglón
    //
    public function delete(Contacto $contacto)
    {
        $this->editando = $contacto;

        $this->folio = $this->editando->id;
        Log::debug('Eliminando id... ' . $this->folio);

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
        $this->cantidad = Contacto::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
        )->count();

        //Log::debug('Contador... ' . $this->cantidad);

        $this->rengs = Contacto::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
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
        ]);
    }
}
