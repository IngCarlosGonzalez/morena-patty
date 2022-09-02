<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['delete'];

    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        $this->resetPage();
        $this->emit('deleteOk');
    }

    public function render()
    {
        $subscribers = Subscriber::where('nombre_full', 'like', "%{$this->search}%")->paginate(6);

        return view('livewire.directorios.subscribers.index')
            ->with(
                [
                    'subscribers' => $subscribers,
                ]
            );
    }
}
