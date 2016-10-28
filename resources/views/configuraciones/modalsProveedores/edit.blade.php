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
							{!! Form::text('nombre',  null, array('class' => 'form-control edit-nombre',  'required' => 'required')) !!}
							</div>
					</div>
                    <div class="form-group">
                            {!! Form::label(null, 'Dirección:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::text('direccion', null, array('class' => 'form-control edit-direccion', 'required' => 'required')) !!}
                            </div>
                    </div>
					<div class="form-group">
							{!! Form::label(null, 'E-Mail:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('email', null, array('class' => 'form-control edit-email')) !!}
							</div>
					</div>
                    <div class="form-group">
                            {!! Form::label(null, 'Telefono:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::text('telefono', null, array('class' => 'form-control edit-telefono')) !!}
                            </div>
                    </div>
                    <div class="form-group">
                            {!! Form::label(null, 'Observaciones:', array('class' => 'control-label col-sm-4')) !!}
                            <div class="col-sm-8">
                            {!! Form::textarea('observaciones', null, array('class' => 'form-control edit-observaciones', 'rows' => '2', 'style' => 'width: 100%')) !!}
                            </div>
                    </div>
					<div class="form-group">
							{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
                                <select name="rubros" class="edit-rubros" multiple="multiple" style="width: 100%"></select>
							</div>
					</div>
					
					{!! Form::hidden('id_proveedor', '', array('class' => 'edit-id_proveedor')) !!}
					{!! Form::hidden('id_usuario', Auth::user()->id , array('class' => 'edit-id_usuario')) !!}

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
        url:'/proveedores/edit',
        data: {'nombre':$('.edit-nombre').val(), 'direccion':$('.edit-direccion').val(),'email':$('.edit-email').val(),'telefono':$('.edit-telefono').val(), 'observaciones':$('.edit-observaciones').val(), 'rubros' : $('.edit-rubros').select2().val().join(", "), 'id_proveedor':$('.edit-id_proveedor').val(), 'id_usuario':$('.edit-id_usuario').val(),'_token': $('input[name=_token]').val()},
        dataType: 'json',
        success: function(data)
        {
            $('#editarproveedor').modal('hide');
            if($('#tabla-proveedores').length > 0) {
               $('#tabla-proveedores').DataTable().ajax.reload();
            }
        }
      })
    });
    //select2 rubros
    $.getJSON("/ajax/rubros2", function (json) {
        $(".edit-rubros").select2({
            data: json,
            language: "es",
            placeholder: "Seleccionar rubros"
        });
    });
</script>