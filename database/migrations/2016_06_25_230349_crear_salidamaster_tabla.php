<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSalidamasterTabla extends Migration
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
            $table->integer('estado')->default(0);
            $table->string('origen', 60);  
            $table->integer('id_subarea')->unsigned();
            $table->foreign('id_subarea')->references('id_subarea')->on('subareas');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
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