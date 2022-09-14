<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = [
        'delete' => 'deleteRegis',
        'limpiar' => 'limpiarBusca',
        'porfisRefresh' => 'refrescar'
    ];

    public $deCuantos = 6;

    public $cantidad = 0;

    public $deleteOk = false;

    public $search = '';

    public $sortear = 'id';
    public $elOrden = 'asc';

    public $elAviso = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiarBusca()
    {
        $this->search = '';
    }

    public function deleteRegis(Subscriber $subscriber)
    {
        $subscriber->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    public function refrescar()
    {
        $this->elAviso = 'recargando...';
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
            'nombre_full',
            'like',
            '%' . $this->search . '%'
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
