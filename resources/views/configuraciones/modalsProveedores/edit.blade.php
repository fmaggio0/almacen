<div class="modal fade" id="editarproveedor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		
		{!! Form::open(['route' => 'editproveedor', 'method'=>'POST', 'class' => 'form-horizontal', 'id' => 'editform']) !!}		

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Editar proveedor</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
							{!! Form::label(null, 'Nombre:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('nombre',  null, array('class' => 'form-control',  'required' => 'required')) !!}
							</div>
					</div>
                    <div class="form-group">
                            {!! Form::label(null, 'Dirección:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::text('direccion', null, array('class' => 'form-control', 'required' => 'required')) !!}
                            </div>
                    </div>
					<div class="form-group">
							{!! Form::label(null, 'E-Mail:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('email', null, array('class' => 'form-control')) !!}
							</div>
					</div>
                    <div class="form-group">
                            {!! Form::label(null, 'Telefono:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::text('telefono', null, array('class' => 'form-control')) !!}
                            </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label(null, 'Observaciones:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::textarea('observaciones', null, array('class' => 'form-control', 'rows' => '2', 'style' => 'width: 100%')) !!}
                            </div>
                    </div>
					<div class="form-group">
							{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
                                <select name="rubros" class="completarrubros" multiple="multiple" style="width: 100%"></select>
							</div>
					</div>
					
					{!! Form::hidden('id_proveedor', '') !!}
					{!! Form::hidden('id_usuario', Auth::user()->id ) !!}

				</div>

				<div class="modal-footer">
					{!! Form::button('Guardar', array('class'=>'btn btn-primary', 'id' => 'editguardar')) !!}
					{!! Form::close() !!}
				</div>
		</div>

	</div>
</div>
<script>
	//SUBMIT AJAX-------------------------------------------
    $('#editguardar').click(function(e){
      e.preventDefault();   
      $.ajax({
        type:"POST",
        url:'/proveedores/addproveedor',
        data: {'nombre':$('input[name=nombre').val(), 'direccion':$('input[name=direccion]').val(),'email':$('input[name=email]').val(),'telefono':$('input[name=telefono]').val(), 'observaciones':$('input[name=observaciones]').val(), 'rubros' : 'hola', 'id_proveedor':$('input[name=id_proveedor]').val(), 'id_usuario':$('input[name=id_usuario]').val(),'_token': $('input[name=_token]').val()},
        dataType: 'json',
        success: function(data)
        {
            $('#editarproveedor').modal('hide');
            $('#proveedores').DataTable().ajax.reload();
        }
        error: function(){
        	alert("error");
        }
      })
    });
</script>