<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSalidasmasterTabla extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_master', function (Blueprint $table) {
            $table->increments('id_master');
            $table->string('tipo_retiro', 60);
            $table->integer('id_destino')->unsigned();
            $table->foreign('id_destino')->references('id_destino')->on('destinos');
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
        Schema::drop('salidas_master');
    }
}