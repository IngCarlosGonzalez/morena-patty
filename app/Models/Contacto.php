<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    public function owner(){
        return $this->belongsTo('App\Models\Owner');
     }

     public function user(){
        return $this->belongsTo('App\Models\User');
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
