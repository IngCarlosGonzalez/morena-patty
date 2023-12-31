<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'clasificacion'
    ];

    public function contactos()
    {
        return $this->hasMany('App\Models\Contacto');
    }
}
