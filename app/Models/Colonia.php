<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    public function contactos()
    {
        return $this->hasMany('App\Models\Contacto');
    }
}
