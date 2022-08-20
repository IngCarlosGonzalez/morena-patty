<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto_id',
        'tipo_documento',
        'referencia_doc',
        'formato_archivo',
        'path_documento'
    ];

    public const TIPO_DOCUMENTO = [
        'Foto Rostro',
        'INE Frente',
        'INE Reverso',
        'Afiliacion',
        'Comprobante',
        'Formato Acta',
        'Otros Anexos'
    ];

    public const FORMATO_ARCHIVO = [
        'DOC',
        'DOCX',
        'XLS',
        'XLSX',
        'PDF',
        'JPG',
        'PNG',
        'GIF',
        'PPT',
        'PPTX',
        'TXT',
        'OTRO'
    ];

    public function contacto()
    {
        return $this->belongsTo('App\Models\Contacto')->withDefault();
    }
}
