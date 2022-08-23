<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'fecha_de_cita',
        'hora_de_cita',
        'tipo_de_cita',
        'origen_de_cita',
        'clase_de_cita',
        'prioridad_cita',
        'contacto_catalogado',
        'contacto_id',
        'persona_nombre',
        'persona_tel_fijo',
        'persona_tel_movil',
        'persona_watsapp',
        'asunto_de_la_cita',
        'referencia_cita',
        'cita_confirmada',
        'confirma_notas',
        'cita_cancelada',
        'cancela_notas',
        'cita_reprogramada',
        'reprograma_notas',
        'nueva_fecha',
        'nueva_hora',
        'cita_efectuada',
        'notas_finales_cita',
        'user_id'
    ];

    public const TIPO_DE_CITA = [
        'Primera Vez',
        'Seguimiento',
        'Excepcional'
    ];

    public const ORIGEN_DE_CITA = [
        'Area Atención',
        'Citas Propias',
        'Otros Canales'
    ];

    public const CLASE_DE_CITA = [
        'Asesoría',
        'Personal',
        'Oficial',
        'Apoyo',
        'Otra'
    ];

    public const PRIORIDAD_CITA = [
        'Normal',
        'Especial',
        'Urgencia'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    public function contacto()
    {
        return $this->belongsTo('App\Models\Contacto')->withDefault();
    }
}
