<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearDivisionesTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('divisiones', function (Blueprint $table) {
            $table->increments('id_division');
            $table->string('division', 60);
            $table->integer('id_direccion')->unsigned();
            $table->foreign('id_direccion')->references('id_direccion')->on('direcciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('divisiones');
    }
}