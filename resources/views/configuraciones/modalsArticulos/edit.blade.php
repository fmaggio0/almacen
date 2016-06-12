<div class="modal fade" id="editar" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		
		{!! Form::open(['route' => 'edit', 'method'=>'POST', 'class' => 'form-horizontal']) !!}		

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Nuevo articulo</h4> 
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
							{!! Form::label('articulo', 'Articulo:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('descripcion',  null, array('class' => 'form-control desc', 'id' => 'descedit', 'placeholder' => 'Nombre del articulo', 'required' => 'required')) !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Unidad de medida:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('unidad', array('Unidad' => 'Unidad', 'Metro' => 'Metro', 'Litro' => 'Litro'), null ,array('id' => 'selectunidadedit', 'class'=>'unidades form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('id_rubro', array('' => 'Seleccione un rubro'), null ,array('id' => 'selectrubroedit', 'class'=>'completarrubros form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'SubRubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('id_subrubro', array('' => 'Seleccione un subrubro'), null ,array('id' => 'selectsubrubroedit','class'=>'completarsubrubros form-control', 'style' => 'width: 100%'))
							!!}
							{!! Form::hidden('usuario', Auth::user()->name ) !!}
							{!! Form::hidden('id_articulo', '') !!}

							</div>
					</div>
				</div>

				<div class="modal-footer">
					{{ Form::submit('Editar', ['class'=>'btn btn btn-primary'])}}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>