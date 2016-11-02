<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CrearAutorizacionesdetallesTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaciones_detalles', function (Blueprint $table) {

            $db = DB::connection('personal')->getDatabaseName();

            $table->increments('id_detalles');
            $table->integer('id_master')->unsigned();
            $table->foreign('id_master')->references('id_master')->on('autorizaciones_master');
            $table->integer('id_articulo')->unsigned();
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            $table->integer('id_empleado');
            $table->integer('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autorizaciones_detalles');
    }
}