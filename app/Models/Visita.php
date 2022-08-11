<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
     }

     public function owner(){
        return $this->belongsTo('App\Models\Owner');
     }

     public function contacto(){
        return $this->belongsTo('App\Models\Contacto');
     }
}
