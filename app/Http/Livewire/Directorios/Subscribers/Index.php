<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = [
        'delete',
        'limpiar'
    ];

    public $deCuantos = 6;

    public $cantidad = 0;

    public $deleteOk = false;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->search = '';
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    public function render()
    {
        $this->cantidad = Subscriber::count();

        $subscribers = Subscriber::where(
            'nombre_full',
            'like',
            "%{$this->search}%"
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
