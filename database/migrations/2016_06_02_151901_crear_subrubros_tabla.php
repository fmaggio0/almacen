<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSubrubrosTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subrubros', function (Blueprint $table) {
            $table->increments('id_subrubro');
            $table->integer('id_rubro')->unsigned();
            $table->foreign('id_rubro')->references('id_rubro')->on('rubros');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subrubros');
    }
}
