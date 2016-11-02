<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearProveedoresTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id_proveedor');
            $table->string('nombre', 60)->required();
            $table->string('direccion', 60 );
            $table->string('cuit', 60 );
            $table->string('email', 60 );
            $table->string('telefono', 60 );
            $table->string('observaciones', 255 );
            $table->string('rubros', 255 );
            $table->boolean('estado')->default(true);
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
        Schema::drop('proveedores');
    }
}
