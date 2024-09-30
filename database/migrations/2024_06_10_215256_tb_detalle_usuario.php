<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbDetalleUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        Schema::create('tb_registro_usuario_detalle', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('identificacion');
            $table->string('establecimiento');
            $table->string('secuencial');
            $table->dateTime('codigo'); 
            $table->dateTime('fecha_registro');                   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
