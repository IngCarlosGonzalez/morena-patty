<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'quien_recibe',
        'fecha_visita',
        'hora_visita',
        'tipo_visita',
        'contacto_catalogado',
        'contacto_id',
        'visitante_nombre',
        'visitante_tel_fijo',
        'visitante_tel_movil',
        'visitante_watsapp',
        'visitante_domicilio',
        'visitante_colonia',
        'visitante_municipio',
        'dato_num_seccion',
        'dato_del_comite',
        'dato_de_defensa',
        'participar_comite',
        'participar_defensa',
        'invitar_capacitacion',
        'invitar_a_reuniones',
        'referencia_visita',
        'asunto_visita',
        'quien_atiende',
        'estatus_visita',
        'palabras_clave',
        'observaciones',
        'con_nueva_cita',
        'owner_id',
        'fecha_prox_cita',
        'hora_prox_cita',
        'user_id'
    ];

    public const ESTATUS_VISITA = [
        'Registrada',
        'Atendida',
        'Seguimiento',
        'Terminada',
        'Descartada'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner')->withDefault();
    }

    public function contacto()
    {
        return $this->belongsTo('App\Models\Contacto')->withDefault();
    }
}
