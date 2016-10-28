<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearSalidadetallesTabla extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_detalles', function (Blueprint $table) {

            $databaseName = DB::connection('personal')->getDatabaseName();

            $table->increments('id_detalles');
            $table->integer('id_master')->unsigned();
            $table->foreign('id_master')->references('id_master')->on('salidas_master');
            $table->integer('id_articulo')->unsigned();
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            $table->integer('id_empleado')->unsigned();
            $table->foreign('id_empleado')->references('Nro_Legajo')->on($databaseName.'.tpersonal');
            $table->integer('cantidad');
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
        Schema::drop('salidas_detalles');
    }
}