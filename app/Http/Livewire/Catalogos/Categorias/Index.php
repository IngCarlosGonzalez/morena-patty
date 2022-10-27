<?php

namespace App\Http\Livewire\Catalogos\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

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

    public $cantidad = 0;
    public $renglones = 0;
    public $ubicacion = '';

    public $folio;
    public $clasificacion;
    public $trampa;
    public $mivariable;

    // Ejecuta método MOUNT cuando inicia el componente
    public function mount()
    {
        $this->editando = new Categoria();
        $this->registro = new Categoria();
        $this->catalogado = new Categoria();
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
    public function agregar(Categoria $catego)
    {
        $this->editando = $catego;
        $this->resetValidation();
        $this->crear = true;
    }


    // Aplica la acción de EDITAR o checar el registro
    public function editar(Categoria $owner)
    {
        $this->editando = $owner;
        // Log::debug('Editando id... ' . $this->editando->id );

        $this->resetValidation();

        $this->folio          = $this->editando->id;
        $this->clasificacion = $this->editando->clasificacion;

        $this->abrir = true;
    }


    // Controla el Reset de campos al cerrar el modal de EDITAR
    public function updatedAbrir()
    {
        if (!$this->abrir) {
            $this->reset('clasificacion');
        }
    }


    // Procesa accion de INSERCIÓN del nuevo registro
    public function procesar()
    {
        // Log::debug('Registrando nuevo... ');

        $this->validate([
            'clasificacion' => 'required|string|min:3|max:20',
        ]);

        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->clasificacion);
        $this->clasificacion = $this->mivariable;

        DB::transaction(function () {
            Categoria::create(
                [
                    'clasificacion' => $this->clasificacion,
                ]
            );
        });

        $this->reset('clasificacion');

        $this->refrescar();
        $this->emit('procesaOk');
        $this->crear = false;
    }


    // Procesa accion de ACTUALIZAR el registro
    public function cambios()
    {
        // Log::debug('Actualizando registro... ' . $this->folio);

        $this->validate([
            'clasificacion' => 'required|string|min:3|max:20',
        ]);
        
        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable     = strtoupper($this->clasificacion);
        $this->clasificacion  = $this->mivariable;

        $this->registro = Categoria::find($this->folio);

        $this->registro->update(
            [
                'clasificacion' => $this->clasificacion,
            ]
        );

        $this->reset('clasificacion');

        $this->refrescar();
        $this->emit('editadoOk');
        $this->abrir = false;
    }


    // Aplica la acción de ELIMINACIÓN al renglón
    public function delete(Categoria $catego)
    {
        $this->editando = $catego;
        Log::debug('Eliminando id... ' . $this->editando->id );

        $this->folio = $this->editando->id;

        // elimina el registro
        $catego->delete();

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
        $this->cantidad = Categoria::where(
            "clasificacion",
            "like",
            "%{$this->search}%"
        )->count();

        $acuales = Categoria::where(
            "clasificacion",
            "like",
            "%{$this->search}%"
        )->orderBy(
            $this->sortear,
            $this->elOrden
        )->paginate(
            $perPage = $this->deCuantos,
            $columns = ['*'],
            $pageName = 'categorias'
        );

        return view('livewire.catalogos.categorias.index')
        ->with(
            [
                'acuales' => $acuales,
            ]
        );
    }
}
