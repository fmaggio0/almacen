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
        DB::table('areas')->insert(
            array(
                array(
                    'descripcion_area' => 'ARBOLADO'
                ),
                array(
                    'descripcion_area' => 'ESPACIOS VERDES'
                ),
                array(
                    'descripcion_area' => 'TALLER'
                ),
                array(
                    'descripcion_area' => 'ADMINISTRACIÓN'
                ),
                array(
                    'descripcion_area' => 'CONTROL DE VECTORES'
                ),
                array(
                    'descripcion_area' => 'COMPRAS'
                ),
            )
        );
        DB::table('subareas')->insert(
            array(
                array(
                    'id_area' => '2',
                    'descripcion_subarea' => 'PARQUE ESPAÑA ARRIBA'
                ),
                array(
                    'id_area' => '2',
                    'descripcion_subarea' => 'MONUMENTO'
                ),
                array(
                    'id_area' => '2',
                    'descripcion_subarea' => 'CUADRILLA VOLANTE DE ARBOLADO'
                ),
                array(
                    'id_area' => '3',
                    'descripcion_subarea' => 'TALLER HERRERIA'
                ),
                array(
                    'id_area' => '3',
                    'descripcion_subarea' => 'TALLER CARPINTERIA'
                )
            )
        );
        DB::table('empleados')->insert(
            array(
                array(
                    'id_empleado' => 55691,
                    'nombres' => 'FRANCO NICOLAS',
                    'apellidos' => 'MAGGIONI',
                    'id_area' => 2,
                    'funcion' => "ADMINISTRATIVO",
                    'talle_remera' => "XL",
                    'talle_camisa' => 44,
                    'talle_calzado' => 44
                ),
            )
        );
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
    }
}
