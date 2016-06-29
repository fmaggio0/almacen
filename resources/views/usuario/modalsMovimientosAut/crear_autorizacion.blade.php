<div class="modal fade" id="salidastock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

		{!! Form::open(['route' => 'autorizar', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Autorizacion para retiro en el almacen - {!!Auth::user()->lugar_trabajo !!}</h4> 
				</div>

				@if($errors->has())
		            <div class="alert alert-warning" role="alert">
		               @foreach ($errors->all() as $error)
		                  <div>{{ $error }}</div>
		              @endforeach
		            </div>
       			 @endif </br> 


				<div class="modal-body">
					<div class="form-group">
							{!! Form::label('tipo_salida', 'Tipo de retiro:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('tipo_retiro', array('salidatrabajo' => 'Salida asignada al trabajo', 'retiropersonal' => 'Elementos de seguridad'), null ,array('class'=>'tipo_retiro form-control', 'style' => 'width: 100%', 'required' => 'required')) 
	                            !!}
							</div>
							{!! Form::label('articulo', 'Usuario:' , array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								<h4> {!!Auth::user()->name !!}</h4>
							</div>
							{!! Form::hidden('usuario', Auth::user()->id) !!}

					</div>
					<div class="form-group">
							{!! Form::label(null, 'Destino:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('destino', array('' => ''), null ,array('id' => 'destinos', 'class'=>' form-control', 'style' => 'width: 100%')) 
	                            !!}
							</div>
							{!! Form::label(null, 'Asignar a:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('asignacion', array('' => ''), null ,array('id' => 'asignacion', 'class'=>' form-control', 'style' => 'width: 100%')) 
	                            !!}
							</div>
						
					</div>

					<fieldset>
                     <legend>Articulos solicitados</legend>
                        <div class="form-group">
							{!! Form::label(null, 'Articulo:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('', array('' => ''), null ,array('id' => 'articulos', 'class'=>' form-control', 'style' => 'width: 100%', 'tabindex' => '3')) 
	                            !!}
							</div>
							{!! Form::label(null, 'Retirado por:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('', array('' => ''), null ,array('id' => 'empleados', 'class'=>' form-control', 'style' => 'width: 100%')) 
	                            !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label(null, 'Cantidad:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
							{!! Form::number('',  null, array('id' => 'cantidad', 'class' => 'form-control', 'placeholder' => 'Cantidad solicitada', 'min' => '1')) !!}
							</div>
							<div class="col-sm-4">
								{!! Form::button('Agregar', array('id' => 'agregar', 'class'=>'btn btn-success')) 
	                            !!}
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
           			</div><!-- /.box-body -->
      			</div><!-- /.box -->

      			<script>
      				//FOCUS ACCESIBILIDAD
      				$('#salidastock').on('shown.bs.modal', function() {
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
               	 	});
               	 	//FIN


      				$("#tabla-salidastock").DataTable({
		                language: {
		                    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
		                },
		                "paging":   false,
		            });

      				$("#destinos").on("select2:select", function(e) {
      					$("#subdestinos").attr('disabled', false);
      					var destinoid = $("#destinos :selected").val();
      					$.getJSON("/movimientos/subdestinos/id="+ destinoid, function (json) { //para modal edit y add
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

				</div>

				<div class="modal-footer">
					{{ Form::submit('Guardar', ['class'=>'btn btn btn-primary', 'tabindex' => '1'])}}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>