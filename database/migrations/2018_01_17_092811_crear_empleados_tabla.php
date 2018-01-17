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
            $table->string('nombres', 60)->nullable();
            $table->string('apellidos', 60)->nullable();
            $table->integer('legajo')->nullable();
            $table->integer('dni')->nullable();
            $table->double('total_factura', 15, 2)->nullable();
            $table->date('fecha_factura')->nullable();
            $table->integer('estado')->default(0); 
            $table->integer('id_proveedor')->unsigned()->nullable();
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
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
        Schema::drop('empleados');
    }
}