<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_registro_usuario_cabecera extends Model
{
    use HasFactory;
    protected $table = 'tb_registro_usuario_cabecera';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
      'id',
    'idIdentificacion',
    'identificacion',
    'nombre',
    'telefono',
    'mail',
    'password',
    'password_verificar',
    'terminos_1',
    'terminos_2',
    'fecha_registro',
    'created_at',
    'updated_at'
    ];

    // public function Items()
    // {
    //     return $this->hasMany(tb_items::class, 'id_descripcion', 'id');
    // }
}
