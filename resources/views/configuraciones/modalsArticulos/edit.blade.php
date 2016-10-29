<div class="modal fade" id="editar" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="#" class="form-horizontal">		

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" id="close-edit" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Editar articulo</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="articulo" class="control-label col-sm-4">Articulo:</label>
						<div class="col-sm-8">
							<input class="form-control" id="edit-desc" placeholder="Nombre del articulo" required="required" name="descripcion" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-sm-4">Unidad de medida:</label>
						<div class="col-sm-8">
							<select id="edit-unidad" class="form-control" style="width: 100%" required="required" name="unidad">
								<option value="Unidad">Unidad</option>
								<option value="Metro">Metro</option>
								<option value="Litro">Litro</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-sm-4">Rubro:</label>
						<div class="col-sm-8">
							<select id="edit-rubros" class="form-control" style="width: 100%" required="required" name="id_rubro"></select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-sm-4">SubRubro:</label>
						<div class="col-sm-8">
							<select id="edit-subrubros" class="form-control" style="width: 100%" required="required" name="id_subrubro"></select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="control-label col-sm-4">Stock minimo:</label>
						<div class="col-sm-8">
							<input id="edit-stock_minimo" class="form-control" style="width: 100%" name="stock_minimo" type="number">
						</div>
					</div>
				</div>

				<div class="modal-footer">
					{{ csrf_field() }}
					<button class="btn btn-primary" id="enviar-art">Guardar</button>
				</div>
			</form>		
		</div>
	</div>
</div>

<script>
	$.getJSON("/ajax/rubros", function (json) { //para modal edit y add
        $("#edit-rubros").select2({
            data: json,
            language: "es",
        });
    });
    $.getJSON("/ajax/subrubros" , function (json) { //solo modal edit
      $("#edit-subrubros").select2({
            data: json,
            language: "es",

        });
    });
    $('#close-edit').click(function() {
        $('#editar').modal('hide');
    });
    $('#tabla-articulos').on('draw.dt', function () {
	    $('.edit').click(function(){
	        $('#editar').modal();

	        //tomo las variables y las paso al modal edit
	        var unidad = $(this).data('selectunidad');
	        var rubro = $(this).data('selectrubro');
	        var subrubro = $(this).data('selectsubrubro');
	        var desc = $(this).data('desc');
	        var id = $(this).attr('value');
	        var estado = $(this).data('estado');
	        var stock_minimo = $(this).data('stockmin');

	         $("#edit-subrubros").prop("readonly", true); //desabilitar subrubro hasta que se elija rubro **CORREJIR** Si lo desabilito que seria lo corecto, el usuario vera toda la lista de subrubros.

	        $('#edit-rubro').on("select2:select", function(e) { //si elijo un rubro...
	            
	            idrubro = $("#edit-rubro").val(); //tomar id

	            $("#edit-subrubros").select2().empty(); // vaciar select subrubros

	            $.getJSON("/ajax/subrubros/" + idrubro, function (json) { //completar select subrubros con la query que responda al id del rubro
	              $("#edit-subrubros").select2({
	                    data: json,
	                    language: "es",

	                });
	            });

	            $("#edit-subrubros").prop("readonly", false); // habilitar subrubro una vez que se eligio rubro
	        });
	    
	        //Modificar atributos con el item seleccionado

	        $("#edit-desc").val( desc ).trigger("change");
	        $("#edit-unidad").val( unidad ).trigger("change");
	        $("#edit-rubros").val( rubro ).trigger("change");
	        $("#edit-subrubros").val( subrubro ).trigger("change");
	        $("input[name='id_articulo']").val(id);
	        $("#edit-stock_minimo").val(stock_minimo);
	        if (estado == 0)
	        {
	           $("#estado").val(false); 
	           $('#estado').prop('checked', false);
	        }
	        else
	        {
	            $("#estado").val(true);
	            $('#estado').prop('checked', true);
	        }
	    });   
    }); 
    //SUBMIT AJAX-------------------------------------------
    $('#enviar-art').click(function(e){
      e.preventDefault();   
      $.ajaxSetup({
          header:$('meta[name="_token"]').attr('content')
      })
      $.ajax({
        type:"POST",
        url:'/articulos/editar',
        data: {'descripcion':$('#edit-desc').val(), 'unidad':$('#edit-unidad').val(),'id_rubro':$('#edit-rubros').val(),'id_subrubro':$('#edit-subrubros').val(), 'stock_minimo':$('#edit-stock_minimo').val(), '_token': $('input[name=_token]').val()},
        dataType: 'json',
        success: function(data)
        {
            $('#editar').modal('hide');

            if($('#tabla-articulos').length > 0) {
               $('#tabla-articulos').DataTable().ajax.reload();
            }
        }
      })
    });

    /*//focus accesibilidad EDIT
    $('#editar').on('shown.bs.modal', function() {
        $("#descedit").focus();
    });
    $("#selectunidadedit").on("select2:select", function(e) {
        $("#selectrubroedit").select2("open");
    });
    $("#selectrubroedit").on("select2:select", function(e) {
        $("#edit-subrubros").select2("open");
    });*/
</script>