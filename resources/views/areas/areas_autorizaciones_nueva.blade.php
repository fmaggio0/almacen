@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
    </div>
@stop

@section('main-content')

    <!-- Mensajes de error-->
    @if($errors->has())
        <div class="alert alert-warning" role="alert" id="ocultar">
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        </div>
    @endif 

    <!-- Mensajes de exito-->
     @if (session('status'))
        <div class="alert alert-success" id="ocultar">
            {{ session('status') }}
        </div>
    @endif

<div class="row">
	<div class="col-md-10 col-md-offset-1">
    	<div class="panel panel-default">
			<form method="POST" action="/areas/autorizaciones/store" accept-charset="UTF-8" class="form-horizontal">

				<div class="panel-heading" style="background: #4682B4; color: #FFFFFF;">
					<h4 class="panel-title">Autorizacion para retiro en el almacen</h4> 
				</div>

				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Tipo de retiro:</label>	
						<div class="col-sm-4">
							<select class="tipo_retiro form-control" style="width: 100%" required="required" name="tipo_retiro">
								<option value="Autorizacion de recursos">Autorizar recursos</option>
								<option value="Autorizacion de elementos de seguridad">Autorizar elementos de seguridad</option>
							</select>
						</div>
						<label for="usuario" class="control-label col-sm-2">Usuario:</label>				
						<div class="col-sm-4">
							<h4>{{ Auth::user()->name }}</h4>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Dependencia:</label>
						<div class="col-sm-4">
							<select id="destinos" class="form-control" style="width: 100%" name="destino"></select>
						</div>
						<label class="control-label col-sm-2">Asignar a:</label>
						<div class="col-sm-4">
							<select id="asignacion" class=" form-control" style="width: 100%" name="asignacion" disabled="true"></select>
						</div>
					</div>
					<fieldset>
                    	<legend>Articulos solicitados</legend>
                        <div class="form-group">
	                       	<label class="control-label col-sm-2">Articulo:</label>
							<div class="col-sm-4">
								<select id="articulos" class="form-control" style="width: 100%"></select>
							</div>
								<label class="control-label col-sm-2">Retirado por:</label>
							<div class="col-sm-4">
								<select id="empleados" class="form-control" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Cantidad:</label>
							<div class="col-sm-4">
								<input id="cantidad" class="form-control" placeholder="Cantidad solicitada" min="1" name="" type="number">
							</div>
							<div class="col-sm-4">
								<button id="agregar" class="btn btn-success" type="button">Agregar</button>
							</div>
						</div>
               	 	</fieldset>

	               	<div class="box">
			            <div class="box-body">
			                <table id="tabla-salidastock" class="table table-striped table-bordered"  cellspacing="0" width="100%">
			                    <thead>
			                        <tr>
			                            <th>Nro Item</th>
			                            <th>Articulo</th>
			                            <th>Cantidad</th>
			                            <th>Retirado por</th>
			                            <th>Acciones</th>
			                        </tr>
			                    </thead>
			                </table>
	           			</div>
	      			</div>
				</div>

				<div class="panel-footer">
                    <input name="origen" type="hidden" value="salida_autorizacion">
                    <input id="id_area" name="id_area" type="hidden" value="{{ $id_area }}"> 
					<input id="id_usuario" name="usuario" type="hidden" value="{{ Auth::user()->id }}">	
					{{ csrf_field() }}
					<input class="btn btn btn-primary" type="submit" value="Autorizar">
				</div>
			</form>
		</div>
	</div>
</div>

@stop
@section('js')

<script>
	//FOCUS ACCESIBILIDAD
	/*$('#salidastock').on('shown.bs.modal', function() {
	$(".tipo_retiro").focus();
 	});
 	$(".tipo_retiro").blur(function (){
 		$("#destinos").select2("open");
 	});
 	$("#destinos").on("select2:select", function(e) {
 		$("#articulos").select2("open");
 	});
 	$("#articulos").on("select2:select", function(e) {
 		$("#empleados").select2("open");
 	});
 	$("#empleados").on("select2:select", function(e) {
 		$("#cantidad").focus();
 	});*/

	$("#tabla-salidastock").DataTable({
		language: {
		    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
		},
		"paging":   false,
	});

	var contador = 1;
	$("#agregar").on( 'click', function () {
	 	var articulos = $("#articulos :selected").text();
	 	var articulosid = $("#articulos :selected").val();
	 	var empleados = $("#empleados :selected").text();
	 	var empleadosid = $("#empleados :selected").val();
	 	var cantidad = $("#cantidad").val();
	    $("#tabla-salidastock").DataTable().row.add( [
	        contador,
	        articulos+"<input type='hidden' name='articulos1[]' value='"+articulosid+"'>",
	        cantidad+"<input type='hidden' name='cantidad1[]' value='"+cantidad+"'>",
	        empleados+"<input type='hidden' name='empleados1[]' value='"+empleadosid+"'>",
	        "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
	    ] ).draw( false );
	    contador++;
    	$("#articulos").select2("val", "");
	 	$("#empleados").select2("val", "");
	 	$("#cantidad").val("");
	 	$("#articulos").select2("open");
	});

	$("#tabla-salidastock tbody").on( "click", ".delete", function () {
	    $("#tabla-salidastock").DataTable()
	        .row( $(this).parents("tr") )
	        .remove()
	        .draw();
	});

	$("#empleados").select2({
            minimumInputLength: 2,
            minimumResultsForSearch: 10,
            language: "es",
            placeholder: "Seleccione un empleado",
            allowClear: true,
            tokenSeparators: [','],
            ajax:   
                {
                    url: "/ajax/empleados",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function (data) {
                         data = data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text+", "+item.nombres,
                            };
                        });
                        return { results: data };
                    },
                    cache: true
                }
        });

    $("#articulos").select2({
        minimumInputLength: 2,
        language: "es",
        placeholder: "Seleccione un articulo",
        allowClear: true,
        ajax:   
            {
                url: "/ajax/articulos",
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data) {
                     data = data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text,
                            stock: item.stock_actual,
                            unidad: item.unidad

                        };
                    });
                    return { results: data };
                },
                cache: true
            }
    });
        
    $("#destinos").select2({
        minimumInputLength: 2,
        language: "es",
        placeholder: "Seleccione un destino",
        allowClear: true,
        ajax:   
            {
                url: "/ajax/subareas/"+$("#id_area").val()+"/",
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data) {
                     data = data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text,
                        };
                    });
                    return { results: data };
                },
                cache: true
            }
    });  

    /*$("#destinos").on("select2:select", function(e) {
		$("#subdestinos").attr('disabled', false);
		var destinoid = $("#destinos :selected").val();
		$.getJSON("/ajax/subareas/"+ destinoid, function (json) { //para modal edit y add
            $("#subdestinos").select2({
                data: json,
                language: "es",
                placeholder: "IGNORAR POR AHORA... VER QUE HACER",
                allowClear: true
            });
   		});
	});*/
</script>

@stop