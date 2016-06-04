<div class="modal fade" id="creararticulo" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		{!! Form::open(['method' => 'POST', 'action' => 'ArticulosController@store', 'class' => 'form-horizontal' ]) !!}

				<div class="modals-header">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Nuevo articulo</h4> 
				</div>

				<div class="modals-body">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">Articulo</div>
							{!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Nombre del articulo' ]) !!}
						</div>
					</div>



				</div>

				<div class="modals-footer">
					<a href="#" id="" class="btn btn-cyan submitbutton"><i class="fa fa-flash"></i>&nbps;{{ $submitTextButton }}</a>
					{!! Form::close() !!}
					<div class="sucess margin-top-20">
						@include('errors.errors')
					</div>
				</div>
		</div>
	</div>
</div>