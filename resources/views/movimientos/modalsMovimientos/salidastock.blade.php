<div class="modal fade" id="salidastock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg">

<div class="modal-content">

	{!! Form::open(['route' => 'addsalida', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

		<!--HEADER MODAL -->
		<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
			<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class="modal-title">Salida de stock</h4> 
		</div>

		<!--BODY MODAL -->
		<div class="modal-body">
			<div class="form-group">
					{!! Form::label('tipo_salida', 'Tipo de retiro:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-4">
						{!! Form::select('tipo_retiro', array('Salida de recursos' => 'Salida de recursos', 'Elementos de seguridad' => 'Elementos de seguridad'), null ,array('class'=>'tipo_retiro form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                    !!}
					</div>

					{!! Form::label('usuarioname', Auth::user()->name , array('class' => 'control-label col-sm-6')) !!}
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
						{!! Form::select('subdestino', array('' => ''), null ,array('id' => 'subdestinos', 'class'=>' form-control', 'style' => 'width: 100%', 'disabled' => 'disabled')) 
                        !!}
					</div>
				
			</div>
			<fieldset>
             	<legend>Detalles</legend>
                <div class="form-group">
					{!! Form::label(null, 'Articulo:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-4" id="articulos_error">
						{!! Form::select('', array('' => ''), null ,array('id' => 'articulos', 'class'=>' form-control', 'style' => 'width: 100%', 'tabindex' => '3')) 
                        !!}
					</div>
					{!! Form::label(null, 'Retirado por:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-4" id="empleados_error">
						{!! Form::select('', array('' => ''), null ,array('id' => 'empleados', 'class'=>' form-control', 'style' => 'width: 100%')) 
                        !!}
					</div>
				</div>
				<div class="form-group" id="cantidad_error">
					{!! Form::label(null, 'Cantidad:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-4">
					{!! Form::number('',  null, array('id' => 'cantidad', 'class' => 'form-control', 'placeholder' => 'Stock actual', 'min' => '1', 'data-stock' => '')) !!}
					</div>
					<div class="col-sm-4">
						{!! Form::button('Agregar', array('id' => 'agregar', 'class'=>'btn btn-success')) 
                        !!}
					</div>
				</div> 
       		</fieldset>

       	 	<!-- DATATABLE ARTICULOS-->
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

		</div><!-- fin modal body -->

		<!-- MODAL FOOTER-->
		<div class="modal-footer">
			<input class="btn btn btn-warning" name="pendiente" type="submit" value="Dejar pendiente">
			<input class="btn btn btn-primary" name="despachar" type="submit" value="Despachar">
			{!! Form::close() !!}
		</div>

</div>

</div>

</div>