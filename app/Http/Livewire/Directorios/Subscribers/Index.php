<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $subscriber;
    public $editando;

    public $abrir = false;

    protected $listeners = ['delete', 'limpiar', 'refrescar'];

    public $marcado = 0;
    public $todos = 0;
    public $acual = 0;

    public $deCuantos = 6;
    public $search = '';

    public $itemsMarcados = [];

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $this->editando = new Subscriber();
        $this->itemsMarcados = [];
        $this->emit('desmarcar');
    }

    public function updatedTodos()
    {
        if ($this->todos == 1) {
            $this->emit('marcarall');
        } else {
            $this->emit('desmarcar');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->elAviso = 'limpiando ...';
        $this->search = '';
    }

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $elAviso = '';

    public $procesado = '';

    public $cantidad = 0;
    public $renglones = 0;

    public function editar(Subscriber $subscriber)
    {
        $this->editando = $subscriber;
        $this->procesado = "Editando ID  " . $this->editando->id;
        $this->abrir = true;
    }

    public function procesar(Subscriber $subscriber)
    {
        $this->editando = $subscriber;
        $this->procesado = "Procesado ID  " . $this->editando->id;
        $this->editando->paso_a_contacto = 1;
        $this->editando->save();
        $this->refrescar();
        $this->emit('procesaOk');
        $this->abrir = false;
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    public function bulkdelete()
    {
        if (!empty($this->itemsMarcados)) {
            Subscriber::whereIn('id', $this->itemsMarcados)->update(['paso_a_contacto' => 0]);
            $this->itemsMarcados = [];
        }
    }

    public function refrescar()
    {
        $this->elAviso = 'recargando ...';
        $this->render();
    }

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

    public function render()
    {
        $this->cantidad = Subscriber::count();

        $subscribers = Subscriber::where(
            "nombre_full",
            "like",
            "%{$this->search}%"
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
