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
            $table->increments('id_empleado');
            $table->string('nombre', 60);
            $table->string('apellido', 60);
            $table->string('area', 60);
            $table->boolean('responsable')->default(false);  
            $table->integer('responsable_area')->unsigned()->nullable();
            $table->foreign('responsable_area')->references('id_empleado')->on('empleados');
            $table->integer('dni')->nullable();
            $table->integer('legajo')->nullable();
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
