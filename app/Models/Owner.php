<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'esta_vigente',
        'area_o_depto',
        'nombre_titular',
        'puesto_titular'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
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
