<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbRegistroUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_registro_usuario_cabecera', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('idIdentificacion');
            $table->string('identificacion');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('mail');
            $table->string('password');
            $table->string('password_verificar');
            $table->boolean('terminos_1');
            $table->boolean('terminos_2');
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
