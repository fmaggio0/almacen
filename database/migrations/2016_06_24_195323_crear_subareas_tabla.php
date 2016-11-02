<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSubareasTabla extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subareas', function (Blueprint $table) {
            $table->increments('id_subarea');
            $table->integer('id_area')->unsigned();
            $table->foreign('id_area')->references('id_area')->on('areas');
            $table->string('descripcion_subarea', 60);
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