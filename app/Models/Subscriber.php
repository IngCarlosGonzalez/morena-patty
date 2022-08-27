<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_full',
        'telefono_movil',
        'tiene_watsapp',
        'colonia_o_sector',
        'localidad_municipio',
        'entidad_federativa',
        'correo_electronico',
        'texto_del_mensaje',
        'observaciones',
        'paso_a_contacto',
        'contacto_id'
    ];
}
