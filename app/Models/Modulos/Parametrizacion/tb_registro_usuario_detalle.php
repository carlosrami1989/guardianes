<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_registro_usuario_detalle extends Model
{
    use HasFactory;
    protected $table = 'tb_registro_usuario_detalle';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
        'id',
        'identificacion',
        'establecimiento',
        'secuencial',
        'codigo',
        'fecha_registro',
        'created_at',
        'updated_at'
    ];

}
