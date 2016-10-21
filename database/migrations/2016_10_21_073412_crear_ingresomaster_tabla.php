<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearIngresomasterTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_master', function (Blueprint $table) {
            $table->increments('id_master');
            $table->string('tipo_ingreso', 60);
            $table->string('tipo_comprobante', 60)->nullable();
            $table->string('nro_comprobante', 60)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->integer('estado')->default(0); 
            $table->integer('id_proveedor')->unsigned();
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
        Schema::drop('ingresos_master');
    }
}