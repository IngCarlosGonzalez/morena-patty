<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
     }

     public function contactos()
     {
         return $this->hasMany('App\Models\Contacto');
     }

     public function visitas()
     {
         return $this->hasMany('App\Models\Visita');
     }

     public function agendas()
     {
         return $this->hasMany('App\Models\Agenda');
     }
}
