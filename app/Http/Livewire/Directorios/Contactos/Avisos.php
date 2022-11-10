<?php

namespace App\Http\Livewire\Directorios\Contactos;

use Livewire\Component;

class Avisos extends Component
{
    public $contenido;
    
    //--- Ejecuta método MOUNT 
    //
    public function mount() 
    {
        $this->contenido = "Si requieres ésta función dile a Patty González...";
    }

    //--- Ejecuta método INICIALIZA 
    //
    public function inicializa()
    {
        $this->dispatchBrowserEvent('notif_d_c_i_2');
    }

    public function render()
    {
        return view('livewire.directorios.contactos.avisos');
    }
}
