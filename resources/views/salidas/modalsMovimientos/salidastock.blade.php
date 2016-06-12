<div class="modal fade" id="salidastock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

		{!! Form::open(['route' => 'addarticulos', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Salida de stock</h4> 
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
							{!! Form::label('articulo', 'Tipo de retiro:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('id_rubro', array('retiropersonal' => 'Salida por retiro personal', 'retirodestruccion' => 'Salida por destruccion', 'salidatrabajo' => 'Salida asignada a trabajo'), null ,array('class'=>'completarrubros form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                            !!}
							</div>

							{!! Form::label('articulo', 'Despachante: ndalmas0', array('class' => 'control-label col-sm-6')) !!}

					</div>
					<div class="form-group">
							{!! Form::label(null, 'Destino:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('destino', array('' => 'Buscar destino'), null ,array('id' => 'destino', 'class'=>' form-control', 'style' => 'width: 100%', 'required' => 'required')) 
	                            !!}
							</div>
							{!! Form::label(null, 'Resposable:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('responsable', array('' => 'Buscar responsable'), null ,array('id' => 'responsable', 'class'=>' form-control', 'style' => 'width: 100%', 'required' => 'required')) 
	                            !!}
							</div>
						
					</div>

					<fieldset>
                     <legend>Detalles</legend>
                        <div class="form-group">
							{!! Form::label(null, 'Articulo:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('articulo', array('' => 'Buscar articulo'), null ,array('id' => 'articulo', 'class'=>' form-control', 'style' => 'width: 100%', 'required' => 'required')) 
	                            !!}
							</div>
							{!! Form::label(null, 'Retirado por:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('retiradopor', array('' => 'Buscar personal'), null ,array('id' => 'retiradopor', 'class'=>' form-control', 'style' => 'width: 100%', 'required' => 'required')) 
	                            !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label(null, 'Stock actual: 4', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-2">
							{!! Form::text('cantidad',  null, array('class' => 'form-control', 'placeholder' => 'Cantidad', 'required' => 'required')) !!}
							</div>
							
						</div>
                        
               	 </fieldset>

               	<div class="box tabla-articulos">
		            <div class="box-body no-padding">
		                <table id="tabla-salidastock" class="table table-striped table-bordered"  cellspacing="0" width="100%">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
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
      				$('#tabla-salidastock').DataTable({
		                language: {
		                    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
		                },
		                "paging":   false,
		            });
      			</script>

				</div>

				<div class="modal-footer">
					{{ Form::submit('Guardar', ['class'=>'btn btn btn-primary'])}}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>