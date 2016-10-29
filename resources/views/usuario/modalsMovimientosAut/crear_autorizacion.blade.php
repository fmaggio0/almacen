<div class="modal fade" id="salidastock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			@if($errors->has())
	            <div class="alert alert-warning" role="alert">
	               @foreach ($errors->all() as $error)
	                  <div>{{ $error }}</div>
	              @endforeach
	            </div>
   			 @endif </br> 

			<form method="POST" action="http://localhost:8000/areas/autorizaciones/nueva" accept-charset="UTF-8" class="form-horizontal">

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Autorizacion para retiro en el almacen</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="tipo_salida" class="control-label col-sm-2">Tipo de retiro:</label>	
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
						<label for="" class="control-label col-sm-2">Dependencia:</label>
						<div class="col-sm-4">
							<select id="destinos" class="form-control" style="width: 100%" name="destino"></select>
						</div>
						<label for="" class="control-label col-sm-2">Asignar a:</label>
						<div class="col-sm-4">
							<select id="asignacion" class=" form-control" style="width: 100%" name="asignacion"></select>
						</div>
					</div>
					<fieldset>
                    	<legend>Articulos solicitados</legend>
                        <div class="form-group">
	                       	<label for="" class="control-label col-sm-2">
	                        	Articulo:
	                       	</label>

							<div class="col-sm-4">
								<select id="articulos" class="form-control select2-hidden-accessible" style="width: 100%" tabindex="-1" name="" aria-hidden="true">
								</select>
							</div>
								<label for="" class="control-label col-sm-2">
									Retirado por:
								</label>
							<div class="col-sm-4">
								<select id="empleados" class="form-control" style="width: 100%" name="">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="control-label col-sm-2">
								Cantidad:
							</label>
							<div class="col-sm-4">
								<input id="cantidad" class="form-control" placeholder="Cantidad solicitada" min="1" name="" type="number">
							</div>
							<div class="col-sm-4">
								<button id="agregar" class="btn btn-success" type="button">
									Agregar
								</button>
							</div>
						</div>
               	 	</fieldset>

	               	<div class="box tabla-articulos">
			            <div class="box-body no-padding">
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

				<div class="modal-footer">
					<input id="id_usuario" name="usuario" type="hidden" value="{{ Auth::user()->id }}">	
					{{ csrf_field() }}
					<input class="btn btn btn-primary" type="submit" value="Autorizar">
				</div>
			</form>
		</div>
	</div>
</div>
</div>
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

	$("#destinos").on("select2:select", function(e) {
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
</script>