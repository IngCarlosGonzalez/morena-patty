<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;

class Show extends Component
{
    public $prospecto;

    public function render(Subscriber $id)
    {
        $this->prospecto = Subscriber::findOrFail($id);

        return view('livewire.directorios.subscribers.show', ['prospecto' => $this->prospecto]);
    }
}
