<div class="modal fade" id="view_autorizacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

		{!! Form::open(['route' => 'addsalida', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Despachar autorización</h4> 
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
								{!! Form::text('tipo_retiro', null ,array('class'=>'tipo_retiro form-control', 'style' => 'width: 100%', 'required' => 'required', 'id' => 'tipo_retiro', 'readonly' => 'true')) 
                            !!}
							</div>

							{!! Form::label('articulo', Auth::user()->name , array('class' => 'control-label col-sm-6')) !!}
							{!! Form::hidden('usuario', Auth::user()->id) !!}
							{!! Form::hidden('id_autorizacion', '', array('id' => 'id_autorizacion')) !!}

					</div>
					<div class="form-group">
							{!! Form::label(null, 'Destino:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::text('desc_subarea', null, array( 'readonly' => 'true', 'class'=>' form-control', 'id' => 'destinos', 'style' => 'width: 100%' ))
	                            !!}
	                            {!! Form::hidden('destino', '', array('id' => 'id_subarea')) !!}
							</div>
							{!! Form::label(null, 'Asignado a:', array('class' => 'control-label col-sm-2')) !!}
							<div class="col-sm-4">
								{!! Form::select('subdestino', array('' => 'Sin asignacion'), null ,array('id' => 'subdestinos', 'class'=>' form-control', 'style' => 'width: 100%', 'disabled' => 'disabled')) 
	                            !!}
							</div>
						
					</div>

					<fieldset>
                     <legend>Detalles</legend>
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
							{!! Form::number('',  null, array('id' => 'cantidad', 'class' => 'form-control', 'placeholder' => 'Stock actual', 'min' => '1')) !!}
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
		                            <th>Articulo</th>
		                            <th>Cantidad</th>
		                            <th>Retirado por</th>
		                            <th>Acciones</th>
		                        </tr>
		                    </thead>
		                </table>
           			</div><!-- /.box-body -->
      			</div><!-- /.box -->
				</div>

				<div class="modal-footer">
					{{ Form::submit('Guardar', ['class'=>'btn btn btn-primary', 'tabindex' => '1'])}}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>