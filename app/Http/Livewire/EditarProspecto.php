<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;

class EditarProspecto extends Component
{
    public $abrir = false;

    public $subscriber;

    public $procesado = '';

    public function mount(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function procesar()
    {
        $this->procesado = "Procesado ID  " . $this->subscriber->id;
        $this->subscriber->paso_a_contacto = 1;
        $this->subscriber->save();
        $this->emitUp('refrescar');
        $this->emit('procesaOk');
        $this->abrir = false;
    }

    public function render()
    {
        return view('livewire.editar-prospecto');
    }
}
