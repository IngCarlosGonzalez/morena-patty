<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class HacerContacto extends Component
{

    public $trampa;

    public $nombre_full;
    public $telefono_movil;
    public $tiene_watsapp;
    public $colonia_o_sector;
    public $localidad_municipio;
    public $entidad_federativa;
    public $correo_electronico;
    public $texto_del_mensaje;

    public $recaptcha;

    public $mivariable;

    public $showSubscribe = false;
    public $showSuccess = false;

    protected $rules = [
        'nombre_full' => 'required|string|min:10|max:60',
        'telefono_movil' => 'required',
        'recaptcha' => 'required|captcha',
        'correo_electronico' => 'email',
    ];

    public function subscribe()
    {
        Log::debug('>>>>> valor del recaptcha >>>>>' . $this->recaptcha . ' <<<<<');
        $this->validate();

        if (!is_null($this->trampa)) {
            return redirect('/');
        }

        $this->mivariable = '';
        $this->mivariable = strtoupper($this->nombre_full);
        $this->nombre_full = $this->mivariable;
        $this->mivariable = strtoupper($this->colonia_o_sector);
        $this->colonia_o_sector = substr($this->mivariable, 0, 40);
        $this->mivariable = strtoupper($this->localidad_municipio);
        $this->localidad_municipio = substr($this->mivariable, 0, 50);
        $this->mivariable = strtoupper($this->entidad_federativa);
        $this->entidad_federativa = substr($this->mivariable, 0, 30);
        $this->mivariable = strtolower($this->correo_electronico);
        $this->correo_electronico = $this->mivariable;
        $this->mivariable = strtoupper($this->texto_del_mensaje);
        $this->texto_del_mensaje = substr($this->mivariable, 0, 250);
        $this->mivariable = '';

        if (is_null($this->tiene_watsapp)) {
            $this->tiene_watsapp = 0;
        }

        DB::transaction(function () {
            $subscriber = Subscriber::create([
                'nombre_full' => $this->nombre_full,
                'telefono_movil' => $this->telefono_movil,
                'tiene_watsapp' => $this->tiene_watsapp,
                'colonia_o_sector' => $this->colonia_o_sector,
                'localidad_municipio' => $this->localidad_municipio,
                'entidad_federativa' => $this->entidad_federativa,
                'correo_electronico' => $this->correo_electronico,
                'texto_del_mensaje' => $this->texto_del_mensaje,
                'observaciones' => 'RECIÉN AGREGADO POR EL PROSPECTO',
                'paso_a_contacto' =>  0,
                'contacto_id' =>  0,
            ]);
        }, $deadlockRetries = 5);

        $this->reset('nombre_full');
        $this->reset('telefono_movil');
        $this->reset('tiene_watsapp');
        $this->reset('colonia_o_sector');
        $this->reset('localidad_municipio');
        $this->reset('entidad_federativa');
        $this->reset('correo_electronico');
        $this->reset('texto_del_mensaje');

        $this->reset('recaptcha');
        $this->emit('limpieza');

        $this->showSubscribe = false;
        $this->showSuccess = true;

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.hacer-contacto');
    }
}
