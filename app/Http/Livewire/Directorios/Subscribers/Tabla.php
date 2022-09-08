<?php

namespace App\Http\Livewire\Directorios\Subscribers;

use Livewire\Component;
use App\Models\Subscriber;

class Tabla extends Component
{
    public function render()
    {
        $subscribers = Subscriber::all();

        return view('livewire.directorios.subscribers.tabla')
        ->with(
            [
                'subscribers' => $subscribers,
            ]
        );
    }
}
