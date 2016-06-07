<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		{!! Form::open(['method' => 'POST', 'action' => 'ArticulosController@eliminar', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Nuevo articulo</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
							{!! Form::label('articulo', 'Articulo:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('articulo',  null, array('class' => 'form-control', 'placeholder' => 'Nombre del articulo')) !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Unidad de medida:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('unidades', array('Unidad' => 'Unidad', 'Metro' => 'Metro', 'Litro' => 'Litro'), null ,array('class'=>'unidades form-control', 'style' => 'width: 100%')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('unidad', array('' => 'Seleccione un rubro'), null ,array('class'=>'rubros form-control', 'style' => 'width: 100%')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'SubRubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('unidad', array('' => 'Seleccione un subrubro'), null ,array('class'=>'subrubros form-control', 'style' => 'width: 100%'))
							!!}
							</div>
					</div>
				</div>

				<div class="modal-footer">
					<a href="#" id="" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</a>
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>