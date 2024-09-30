<?php

namespace App\Models\Modulos\Parametrizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_data_estacion extends Model
{
    use HasFactory;
    protected $table = 'tb_data_estaciones';
    /**
     * @var string
     */
    public $timestamps = false;
    protected $fillable = [
       'id',
    'id_api',
    'identificacion',
    'nombre',
    'ruc',
    'establecimiento',
    'secuencial',
    'codigo',
    'created_at',
    'updated_at'
    ];

    public function scopeDatosEstacion($query)
    {
        $des_estacion = tb_estaciones::select('descripcion')
                ->whereColumn('ruc', 'ruc')
                ->whereColumn('establecimiento', 'establecimiento')
            ->limit(1);
		//cirujano
		 

 
        $query->addSelect([
            'des_estacion' => $des_estacion,
           
            
        ]);
    }

    // public function Items()
    // {
    //     return $this->hasMany(tb_items::class, 'id_descripcion', 'id');
    // }
}
