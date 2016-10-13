<div class="modal fade" id="crearproveedor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

		{!! Form::open(['route' => 'addarticulos', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" id="cerrarcrearproveedor" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Nuevo proveedor</h4> 
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
                                <select name="rubros" class="completarrubros" multiple="multiple" style="width: 100%" required></select>
							</div>
					</div>
				</div>

				<div class="modal-footer">
					{!! Form::button('Guardar', array('class'=>'send-btn btn btn-primary')) !!}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>

<script>
    //Desabilitar opciones si es ajuste de stock

	//ABRIR Y CERRAR MODAL
		$('#nuevo').click(function(){
            $('#crearproveedor').modal();
        });
         //Cerrar modal agregar articulo
        $("#cerrarcrearproveedor").click(function() {
            $('#crearproveedor').modal('hide');
        });
    //FIN ABRIR Y CERRAR MODAL

    //SUBMIT AJAX-------------------------------------------
    $('.send-btn').click(function(e){
      e.preventDefault();   
      $.ajaxSetup({
          header:$('meta[name="_token"]').attr('content')
      })
      $.ajax({
        type:"POST",
        url:'/proveedores/addproveedor',
        data: {'nombre':$('input[name=nombre').val(), 'direccion':$('input[name=direccion]').val(),'email':$('input[name=email]').val(),'telefono':$('input[name=telefono]').val(), 'observaciones':$('input[name=observaciones]').val(), 'rubros':$('input[name=rubros]').val(),'_token': $('input[name=_token]').val()},
        dataType: 'json',
        success: function(data)
        {
            $('#crearproveedor').modal('hide');
        }
      })
    });

    //select2 rubros
    $.getJSON("/ajax/rubros", function (json) { //para modal edit y add
        $(".completarrubros").select2({
            tags: true,
            data: json,
            language: "es",
            placeholder: "Seleccionar rubros"
        });
    });
</script>