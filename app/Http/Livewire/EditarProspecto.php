<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditarProspecto extends Component
{
    public $abrir = false;

    public $subscriber;

    public $procesado = '';

    public function procesar()
    {
        $this->procesado = "Procesado ID  " . $this->subscriber->id;
        $this->subscriber->paso_a_contacto = 1;
        $this->subscriber->save();
        $this->emit('procesaOk');
        $this->emitUp('porfisRefresh');
        $this->abrir = false;
    }

    public function render()
    {
        return view('livewire.editar-prospecto');
    }
}
