<div class="modal fade" id="salidastock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg">

<div class="modal-content">

	{!! Form::open(['route' => 'addingreso', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

		<!--HEADER MODAL -->
		<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
			<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class="modal-title"> Ingreso de Stock</h4> 
		</div>

		<!--BODY MODAL -->
		<div class="modal-body">
			<div class="form-group">
				{!! Form::label(null, 'Tipo de ingreso:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::select('tipo_ingreso', array( 'Ingreso por facturacion' => 'Ingreso por facturacion', 'Ajuste de stock' => 'Ajuste de stock',), null ,array('class'=>'tipo_retiro form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                !!}
				</div>
				{!! Form::label(null, 'Tipo de comprobante:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::select('tipo_comprobante', array('Factura' => 'Factura', 'Remito' => 'Remito', 'TIcket' => 'Ticket'), null ,array('class'=>' form-control', 'style' => 'width: 100%')) 
                    !!}
				</div>
					

			</div>
			<div class="form-group">
				{!! Form::label(null, 'Nro de Comprobante:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::text('nro_comprobante', null ,array('class'=>' form-control', 'style' => 'width: 100%')) 
                    !!}
				</div>
				{!! Form::label(null, 'Descripcion:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::textarea('descripcion', null, array('class' => 'form-control', 'rows' => '2', 'style' => 'width: 100%')) 
                    !!}
				</div>
					
				
			</div>
			<div class="form-group">
				{!! Form::label(null, 'Proveedor:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4" id="articulos_error">
					{!! Form::select('', array('' => ''), null ,array('id' => 'proveedor', 'class'=>' form-control', 'style' => 'width: 100%')) 
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
					<div class="col-sm-2">
					{!! Form::button('+', array('id' => 'addarticulo', 'style' =>"float:left", 'class'=>'btn btn-success')) 
                        !!}
					{!! Form::label(null, 'Cantidad:', array('class' => 'control-label','style' =>"float:right")) !!}
					</div>
					<div class="col-sm-4">
					{!! Form::number('',  null, array('id' => 'cantidad', 'class' => 'form-control', 'placeholder' => 'Stock actual', 'min' => '1', 'data-stock' => '')) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2" style="float:right">
						{!! Form::button('Agregar', array('id' => 'agregar', 'style' =>"float:right", 'class'=>'btn btn-success')) 
                        !!}
					</div>
				</div> 
       		</fieldset>

       	 	<!-- DATATABLE ARTICULOS-->
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

		</div><!-- fin modal body -->

		<!-- MODAL FOOTER-->
		<div class="modal-footer">
			{!! Form::submit('Despachar', ['class'=>'btn btn btn-primary']) !!}
			{!! Form::close() !!}
		</div>

</div>

</div>

</div>