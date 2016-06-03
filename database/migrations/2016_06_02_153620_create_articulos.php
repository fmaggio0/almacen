<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id_articulo');
            $table->string('descripcion');
            $table->string('unidad', 20);
            $table->integer('stock_actual');
            $table->integer('stock_minimo')->nullable();
            $table->string('usuario')->nullable();
            $table->integer('id_rubro')->unsigned()->nullable();
            $table->foreign('id_rubro')->references('id_rubro')->on('rubros');
            $table->integer('id_subrubro')->unsigned()->nullable();
            $table->foreign('id_subrubro')->references('id_subrubro')->on('subrubros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articulos');
    }
}
