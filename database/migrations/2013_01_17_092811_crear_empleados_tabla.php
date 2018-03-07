<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearEmpleadosTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('id_empleado')->primary();
            $table->string('nombres', 60);
            $table->string('apellidos', 60);
            $table->integer('id_area')->unsigned();
            $table->foreign('id_area')->references('id_area')->on('areas');
            $table->integer('id_subarea')->unsigned()->nullable();
            $table->foreign('id_subarea')->references('id_subarea')->on('subareas');
            $table->string('funcion', 60)->nullable();
            $table->string('talle_remera', 10)->nullable();
            $table->integer('talle_camisa')->nullable();
            $table->integer('talle_calzado')->nullable();
            $table->integer('estado')->default(1);
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
        Schema::drop('empleados');
    }
}