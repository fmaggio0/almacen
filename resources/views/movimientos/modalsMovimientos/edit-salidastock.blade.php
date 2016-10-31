<div class="modal fade" id="salidas-modal-edit" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form method="POST" action="/movimientos/addsalida" accept-charset="UTF-8" class="form-horizontal">

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Despachar autorización</h4> 
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Tipo de retiro:</label>
						<div class="col-sm-4">
							<input class="form-control" style="width: 100%" required="required" id="edit-tipo_retiro" readonly="true" name="edit-tipo_retiro" type="text">
						</div>
						<label class="control-label col-sm-6">{{Auth::user()->name}}</label>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Destino:</label>
						<div class="col-sm-4">
							<input readonly="true" class="form-control" id="edit-destinos" style="width: 100%" name="desc_subarea" type="text">
						</div>
						<label class="control-label col-sm-2">Asignado a:</label>
						<div class="col-sm-4">
							<select id="subdestinos" class=" form-control" style="width: 100%" disabled="disabled" name="subdestino"><option value="" selected="selected">Sin asignacion</option></select>
						</div>
					</div>

					<fieldset>
                     	<legend>Detalles</legend>
                        <div class="form-group">
							<label class="control-label col-sm-2">Articulo:</label>
							<div class="col-sm-4">
								<select id="edit-articulos" class="form-control" style="width: 100%"></select>
							</div>
							<label class="control-label col-sm-2">Retirado por:</label>
							<div class="col-sm-4">
								<select id="edit-empleados" class="form-control" style="width: 100%"></select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Cantidad:</label>
							<div class="col-sm-4">
								<input id="edit-cantidad" class="form-control" placeholder="Stock actual" min="1" type="number">
							</div>
							<div class="col-sm-4">
								<button id="agregar" class="btn btn-success" type="button">Agregar</button>
							</div>
						</div> 
               	 	</fieldset>

	               	<div class="box">
			            <div class="box-body">
			                <table id="tabla-salidas-modal-edit" class="table table-striped table-bordered"  cellspacing="0" width="100%">
			                    <thead>
			                        <tr>
			                            <th>Articulo</th>
			                            <th>Cantidad</th>
			                            <th>Retirado por</th>
			                            <th>Acciones</th>
			                        </tr>
			                    </thead>
			                </table>
	           			</div>
	      			</div>

				</div>

				<div class="modal-footer">
					<input name="usuario" type="hidden" value="{{Auth::user()->id}}">
					<input id="edit-id_salida" name="id_autorizacion" type="hidden">
					<input class="btn btn btn-primary" tabindex="1" type="submit" value="Despachar">
				</div>

			</form>

		</div>
	</div>
</div>

@section('js-modals')
<script>
	$("#tabla-salidas-modal-edit").DataTable({
	    language: {
	        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
	    },
	    "paging":   false,
	});
    $('#tabla-movimientos').on('draw.dt', function () {
        $('.edit').click( function () {

            var tr = $(this).closest('tr');
            var filadata = $("#tabla-movimientos").DataTable().row(tr).data();

            $("#edit-destinos").val(filadata.subarea);
            $("#edit-id_subarea").val(filadata.id_subarea);
            $("#edit-id_salida").val(filadata.id_tabla);
            $("#edit-tipo_retiro").val(filadata.tipo_retiro);

            $ ("#salidas-modal-edit").modal();
            $.getJSON("/datatables/salidas-modal-edit/"+filadata.id_tabla, function (json) { //para modal edit y add
                $("#tabla-salidas-modal-edit").DataTable().clear();
                for (var i=0;i<json.length;++i)
                {
                    $("#tabla-salidas-modal-edit").DataTable().row.add( [
                    json[i].descripcion+"<input type='hidden' name='articulos[]' value='"+json[i].id_articulo+"'>",
                     json[i].cantidad+"<input type='hidden' name='cantidad[]' value='"+json[i].cantidad+"'>",
                    json[i].Apellido+", "+json[i].Nombres+"<input type='hidden' name='empleados[]' value='"+json[i].id_empleado+"'>",
                    "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
                    ] ).draw( false );
                }
                    
            });
        });

        $("#edit-empleados").select2({
            minimumInputLength: 2,
            minimumResultsForSearch: 10,
            language: "es",
            placeholder: "Seleccione un empleado",
            allowClear: true,
            tokenSeparators: [','],
            ajax:   
                {
                    url: "/ajax/empleados",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function (data) {
                         data = data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text+", "+item.nombre,
                            };
                        });
                        return { results: data };
                    },
                    cache: true
                }
        });

        $("#edit-articulos").select2({
            minimumInputLength: 2,
            minimumResultsForSearch: 10,
            language: "es",
            placeholder: "Seleccione un articulo",
            allowClear: true,
            tokenSeparators: [','],
            ajax:   
                {
                    url: "/ajax/articulos",
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            term: params.term
                        }
                    },
                    processResults: function (data) {
                         data = data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                stock: item.stock_actual,
                                unidad: item.unidad

                            };
                        });
                        return { results: data };
                    },
                    cache: true
                }
        });
    });
    $("#tabla-salidas-modal-edit tbody").on( "click", ".delete", function () {
        $("#tabla-salidas-modal-edit").DataTable()
            .row( $(this).parents("tr") )
            .remove()
            .draw();
    });
</script>
@stop