<div class="modal fade" id="creararticulo" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

		{!! Form::open(['route' => 'addarticulos', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" id="cerrarcreararticulo" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Nuevo articulo</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
							{!! Form::label('articulo', 'Articulo:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::text('descripcion',  null, array('class' => 'form-control desc', 'placeholder' => 'Nombre del articulo', 'required' => 'required')) !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Unidad de medida:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('unidad', array('Unidad' => 'Unidad', 'Metro' => 'Metro', 'Litro' => 'Litro'), null ,array('class'=>'unidades form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('id_rubro', array('' => 'Seleccione un rubro'), null ,array('class'=>'completarrubros form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                            !!}
							</div>
					</div>
					<div class="form-group">
							{!! Form::label(null, 'SubRubro:', array('class' => 'control-label col-sm-4')) !!}
							<div class="col-sm-8">
							{!! Form::select('id_subrubro', array('' => 'Seleccione un subrubro'), null ,array('class'=>'subrubros form-control', 'style' => 'width: 100%'))
							!!}
							{!! Form::token(); !!}
							{!! Form::hidden('id_usuario', Auth::user()->id ) !!}

							</div>
					</div>
				</div>

				<div class="modal-footer">
					{{ Form::submit('Guardar', ['id' => 'submitarticulo', 'class'=>'btn btn btn-primary'])}}
					{!! Form::close() !!}
				</div>
		</div>
	</div>
</div>

<script>
	//ABRIR Y CERRAR MODAL
		$('#nuevo').click(function(){
            $('#creararticulo').modal();
        });
         //Cerrar modal agregar articulo
        $("#cerrarcreararticulo").click(function() {
            $('#creararticulo').modal('hide');
        });
    //FIN ABRIR Y CERRAR MODAL
	//SELECT2---------------------------------------------
            //select2 Unidades de medida
        $(".unidades").select2({
            language: "es",
        });
        //select2 rubros
        $.getJSON("/ajax/rubros", function (json) { //para modal edit y add
            $(".completarrubros").select2({
                data: json,
                language: "es",
            });
        });
        //select2 subrubros
        $.getJSON("/ajax/subrubros" , function (json) { //solo modal edit
          $(".completarsubrubros").select2({
                data: json,
                language: "es",

            });
        });
    //FIN SELECT2-------------------------------------------
    //FIN SELECT2 SUBFAMILIA
         $(".subrubros").prop("disabled", true);
         $('.completarrubros').on("select2:select", function(e) { 
            id = $(".completarrubros").val();
            $(".subrubros").select2();
            $(".subrubros").select2().empty();
            $.getJSON("ajax/subrubros/" + id, function (json) {
              $(".subrubros").select2({
                    data: json,
                    language: "es",

                });
            });
            $(".subrubros").prop("disabled", false);
        });
    //FIN SELECT2 FAMILIA-SUBFAMILIA------------------------
    //SUBMIT AJAX-------------------------------------------
    $('#submitarticulo').on('submit', function(e) {
        e.preventDefault(); 
          var name = $('.desc').val();
          var message = $('.unidades').val();
          var postid = $('.completarrubros').val();
          /*var postid = $('.subrubros').val();*/
          $.ajax({
                type: "POST",
                url: host+'/articulos/addarticulo',
                data: {name:name, message:message, post_id:postid}
               /* success: function( msg ) {
                alert( msg );
                }*/
            });
       });
</script>