<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'esta_vigente',
        'clave_tipo',
        'clave_origen',
        'categoria_id',
        'clasificacion',
        'numero_afiliacion',
        'fecha_afiliacion',
        'comite_base',
        'comite_rol',
        'defensores',
        'partido_area',
        'partido_puesto',
        'miembro_fundador',
        'titulo_cargo',
        'gestor_titulo',
        'razon_social',
        'nombre_full',
        'ap_paterno',
        'ap_materno',
        'nombre_uno',
        'nombre_dos',
        'localidad_mpio',
        'domicilio_full',
        'domicilio_calle',
        'domicilio_numext',
        'domicilio_numint',
        'domicilio_colonia',
        'domicilio_codpost',
        'domicilio_coordenadas',
        'colonia_catalogada',
        'colonia_id',
        'municipio_id',
        'telefono_fijo',
        'telefono_movil',
        'tiene_watsapp',
        'direccion_email',
        'tiene_facebook',
        'tiene_instagram',
        'tiene_telegram',
        'tiene_twitter',
        'tiene_otra_red',
        'contacto_facebook',
        'contacto_instagram',
        'contacto_telegram',
        'contacto_twitter',
        'contacto_otra_red',
        'fecha_nacimiento',
        'dato_de_la_curp',
        'clave_de_elector',
        'num_credencial_ine',
        'numero_ocr_ine',
        'vigencia_credencial',
        'distrito_fed',
        'distrito_local',
        'numero_de_ruta',
        'numero_seccion',
        'seccion_prioritaria',
        'anotaciones',
        'user_id'
    ];

    public const CLAVE_TIPO = [
        'Personal',
        'Oficial',
        'General',
        'Otros'
    ];

    public const CLAVE_ORIGEN = [
        'En la Oficina',
        'En Terrirorio',
        'Redes Sociales',
        'Otros'
    ];

    public const COMITE_BASE = [
        'No Aplica',
        'Enlace Num 1',
        'Enlace Num 2',
        'Otros'
    ];

    public const COMITE_ROL = [
        'No Aplica',
        'Coordinador',
        'Es Activista',
        'Defensor Voto',
        'Movilizador',
        'Integrante',
        'Otros'
    ];

    public const DEFENSORES = [
        'No Aplica',
        'Es Coordinador',
        'Representante Legal',
        'Rep Casilla Propiet',
        'Rep Casilla Suplente',
        'Otros'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }

    public function colonia()
    {
        return $this->belongsTo('App\Models\Colonia')->withDefault();
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\Municipio')->withDefault();
    }

    public function documentos()
    {
        return $this->hasMany('App\Models\Documento');
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
