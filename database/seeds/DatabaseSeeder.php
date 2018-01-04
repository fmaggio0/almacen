<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            array(
	            array(
                    'name' => 'developer',
                    'email' => 'developer@rosario.gov.ar',
                    'password' => bcrypt("CIL123"),
                    'id_empleado' => 55691
	            ),
	        )
    	);
    	DB::table('roles')->insert(
            array(
	            array(
                    'name' => 'developers',
                    'display_name' => 'developers',
                    'description' => 'programadores'
	            ),
	        )
    	);
    	DB::table('role_user')->insert(
            array(
	            array(
                    'user_id' => 1,
                    'role_id' => 1
	            ),
	        )
    	);
    	DB::table('rubros')->insert(
            array(
	            array(
                    'descripcion' => 'FERROSOS'
	            ),
	            array(
                    'descripcion' => 'ART. LIMPIEZA'
	            ),
	            array(
                    'descripcion' => 'ART. LIBRERIA'
	            ),
	            array(
                    'descripcion' => 'ART. INFORMATICA'
	            ),
	        )
    	);
    	DB::table('subrubros')->insert(
            array(
	            array(
	            	'id_rubro' => '1',
                    'descripcion' => 'BULONES'
	            ),
	            array(
                    'id_rubro' => '1',
                    'descripcion' => 'CAÑOS DE ALUMINIO'
	            ),
	            array(
                    'id_rubro' => '1',
                    'descripcion' => 'TORNILLOS'
	            ),
	            array(
                    'id_rubro' => '2',
                    'descripcion' => 'LIQUIDOS'
	            ),
	        )
    	);
    	DB::table('areas')->insert(
            array(
	            array(
                    'descripcion_area' => 'Arbolado'
	            ),
	            array(
                    'descripcion_area' => 'Espacios Verdes'
	            ),
	            array(
                    'descripcion_area' => 'Taller'
	            ),
	            array(
                    'descripcion_area' => 'Administracion'
	            ),
	            array(
                    'descripcion_area' => 'Control de Vectores'
	            ),
	            array(
                    'descripcion_area' => 'Compras'
	            ),
	        )
    	);
    	DB::table('subareas')->insert(
            array(
	            array(
	            	'id_area' => '2',
                    'descripcion_subarea' => 'Parque España Arriba'
	            ),
	            array(
	            	'id_area' => '2',
                    'descripcion_subarea' => 'Monumento'
	            ),
	            array(
	            	'id_area' => '2',
                    'descripcion_subarea' => 'Cuadrilla de arbolado'
	            ),
	            array(
	            	'id_area' => '3',
                    'descripcion_subarea' => 'Taller Herreria'
	            ),
	            array(
	            	'id_area' => '3',
                    'descripcion_subarea' => 'Taller Herreria'
	            )
	        )
    	);
    }
}
