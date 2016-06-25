<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSubdestinosTabla extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdestinos', function (Blueprint $table) {
            $table->increments('id_subdestino');
            $table->integer('id_destino')->unsigned();
            $table->foreign('id_destino')->references('id_destino')->on('destinos');
            $table->string('descripcion_subdestino', 60);
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
        Schema::drop('subdestinos');
    }
}