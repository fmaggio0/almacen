@extends('layouts.app')

@section('main-content')
	<div class="spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>

					<div>
			           <hr class="separador"/>
			            <h4>
			                <span class="campo-requerido" 
			                    id="marca_ubicacion_requerida"
			                >*</span>
			                Ubicación:
			            </h4>
				       
				       <div id="collapse-address" class="accordion-body">
				            <div class="row" id="row_ubicacion">
					            <div id="divCalle" class="form-group col-sm-4">
					                <label for="calle" class="control-label">Calle</label><input class="form-control" 
			                            id="calle"
			                            name="ubicacion.calle"
			                            type="text"
			                            value=""
			                            readonly="readonly"
			                        />
			                        <input class="form-control" 
			                            id="codigoCalle"
			                            name="ubicacion.codigoCalle"
			                            type="hidden"
			                            value=""
			                        />
					            </div>			            
					            <div id="divaltura" class="form-group col-sm-2">
					                <label for="altura" class="control-label">Altura</label><input class="form-control" 
			                            id="altura"
			                            name="ubicacion.altura"
			                            type="text"
			    		                value=""
			                            readonly="readonly"
			                        />
					            </div>		            	            
					            <div class="form-group col-sm-1">
			                        <label for="bis" class="control-label">Bis</label><br>		                
			                        <input class="form-control" 
			                            id="bis"
			                            name="ubicacion.bis"
			                            type="checkbox"
			                            readonly="readonly"
			                            onclick="return false;"
			                            
			                        />
					            </div>	  		           		            
					            <div class="form-group col-sm-1">
			                        <label for="letra" class="control-label">Letra</label><input class="form-control" 
			                            id="letra"
			                            name="ubicacion.letra"
			                            type="text"
			                            readonly="readonly"
			                        />
					            </div>		            	            
			                </div>
			                <div class="row">
			                    <div class="col-md-5 form-group">
			                        <div class="row">
			                            <div class="col-md-6">
			        		                <label for="coordenadaX" class="control-label">Coordenada X</label><input
			                                    class="form-control" 
			                                    id="coordenadaX"
			                                    name="ubicacion.coordenadaX"
			                                    type="text" 
			                                    value = ""
			                                    readonly="readonly"
			                                />
			        		            </div>
			                            <div class="col-md-6">
			                                <label for="coordenadaY" class="control-label">Coordenada Y</label><input
			                                    class="form-control" 
			                                    id="coordenadaY"
			                                    name="ubicacion.coordenadaY"
			                                    type="text" 
			                                    value = ""
			                                    readonly="readonly"
			                                />
			                            </div>
			                        </div>
				                </div>
				            </div>            	          
				        </div>	  		
				    </div>


					<div class="panel-body">
						<input autocomplete="off" class="form-control ubicaciones-input" id="buscador_ubicacion" placeholder="Buscar ubicación" style="padding-right: 18px;">
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('js')

<script>
	$(document).ready(function(){

	    //alert(URL_BASE_WS_UBICACIONES);
	    
	    /*initObjetosLugarAsociado();	    	    	    
		cambioEstado();*/
		var URL_BASE_WS_UBICACIONES = 'ws.rosario.gov.ar/ubicaciones/public';

		console.log(URL_BASE_WS_UBICACIONES);
		
	    var controlUbicaciones = $("#buscador_ubicacion").ubicaciones(
        {
    	    noReubicar: true,
    	    sinBotonBusqueda: true,
    	    pathImg:'/img',
    	    filtro: {
    	        clase: 'direccion',
    	        extendido: true,
    	        featureUnico: true,
    	        url: 'https://' + URL_BASE_WS_UBICACIONES + '/geojson/direcciones',
    	        callback: function(resultado) 
    	        {            
    	            console.log('Callback input select ...');
    	            console.log(resultado.properties);
    	                	            
    	            $('#calle').val(
    	                resultado.properties.nombreCalle
    	            );
    	            $('#codigoCalle').val(
    	            	resultado.properties.codigoCalle
    	            	? resultado.properties.codigoCalle
    	            	: ''    	                    
    	            );
    	            $('#altura').val(
    	                resultado.properties.altura
    	            );
    	            $('#bis').prop(
    	                'checked',
    	                resultado.properties.bis
    	            );
    	            $('#letra').val(
    	                resultado.properties.letra
    	            );    
    	            $('#coordenadaX').val(
    	                resultado.geometry
    	                ? resultado.geometry.coordinates[0]
    	                : ''
    	            );
    	            $('#coordenadaY').val(
    	                resultado.geometry
    	                ? resultado.geometry.coordinates[1]
    	                : ''
    	            );
    	        }
    	    },
    	});
	});
</script>

@stop