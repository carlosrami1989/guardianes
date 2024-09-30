<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbDataEstaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_data_estaciones', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_api');
            $table->string('identificacion');
            $table->string('nombre');
            $table->string('ruc');
            $table->string('establecimiento');
            $table->string('secuencial');
            $table->dateTime('codigo');                   
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
