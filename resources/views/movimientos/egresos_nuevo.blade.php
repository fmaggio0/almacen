@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
    </div>
@stop

@section('main-content')

    <!-- Mensajes de error-->

    @if($errors->has())
        <div class="alert alert-warning" role="alert" id="ocultar">
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        </div>
    @endif 


    <!-- Mensajes de exito-->

     @if (session('status'))
        <div class="alert alert-success" id="ocultar">
            {{ session('status') }}
        </div>
    @endif

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

			<form method="POST" action="/movimientos/addsalida" accept-charset="UTF-8" class="form-horizontal">

				<div class="panel-heading" style="background: #4682B4; color: #FFFFFF;">
					<h4 class="panel-title">Salida de stock</h4> 
				</div>

				<div class="panel-body">

					<div class="form-group">
						<label class="control-label col-sm-2">Tipo de retiro:</label>
						<div class="col-sm-4">
							<select class="tipo_retiro form-control" style="width: 100%" required="required" name="tipo_retiro">
								<option value="Salida de recursos">Salida de recursos</option>
								<option value="Elementos de seguridad">Elementos de seguridad</option>
							</select>
						</div>
						<label for="usuarioname" class="control-label col-sm-6"> {{ Auth::user()->name }} </label>
					</div>
					<div class="form-group">
							<label class="control-label col-sm-2">Destino:</label>
							<div class="col-sm-4">
								<select id="destinos" class="form-control" style="width: 100%" name="destino" aria-hidden="true"></select>
							</div>
							<label class="control-label col-sm-2">Asignar a:</label>
							<div class="col-sm-4">
								<select id="subdestinos" class=" form-control" style="width: 100%" disabled="disabled" name="subdestino"></select>
							</div>
					</div>
					<fieldset>
		             	<legend>Detalles</legend>
		                <div class="form-group">
							<label class="control-label col-sm-2">Articulo:</label>
							<div class="col-sm-4" id="articulos_error">
								<select id="articulos" class="form-control" style="width: 100%" name="articulos" aria-hidden="true"></select>
							</div>
							<label class="control-label col-sm-2">Retirado por:</label>
							<div class="col-sm-4" id="empleados_error">
		                        <select id="empleados" class="form-control" style="width: 100%" name="articulos" aria-hidden="true"></select>
		                        <div style="position: absolute;">
			                        <p class="help-block" id="sector"></p>
			                        <p class="help-block" id="cargo"></p>
		                        </div>
							</div>
						</div>
						<div class="form-group" id="cantidad_error">
							<label class="control-label col-sm-2">Cantidad:</label>
							<div class="col-sm-4">
								<input id="cantidad" class="form-control" placeholder="Stock actual" min="1" data-stock="" name="" type="number">
							</div>
							<div class="col-sm-4">
								<button id="agregar" class="btn btn-success" type="button">Agregar</button>
							</div>
						</div> 
		       		</fieldset>

		       	 	<!-- DATATABLE ARTICULOS-->
			       	<div class="box">
			            <div class="box-body">
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

				</div>

				<div class="panel-footer">
					<input name="usuario" type="hidden" value="{{ Auth::user()->id }}">

					<input class="btn btn btn-warning" name="pendiente" type="submit" value="Dejar pendiente">
					<input class="btn btn btn-primary" name="despachar" type="submit" value="Despachar">
				</div>

			</form>

		</div>
	</div>
</div>

@stop

@section('js')

<script>
    $("#empleados").select2({
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
                        cargo: item.cargo,
                        sector: item.sector
                    };
                });
                return { results: data };
            },
            cache: true
        }
    });
    $("#articulos").select2({
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
    $("#destinos").select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        language: "es",
        placeholder: "Seleccione un destino",
        allowClear: true,
        tokenSeparators: [','],
        ajax:   
        {
            url: "/ajax/subareas",
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
                    };
                });
                return { results: data };
            },
            cache: true
        }
    });  

    //Focus accesibilidad
    $('#salidastock').on('shown.bs.modal', function() {
        $(".tipo_retiro").focus();
    });
    $("#destinos").on("select2:select", function(e) {
        $("#articulos").select2("open");
    });
    $("#articulos").on("select2:select", function(e) {
        $("#empleados").select2("open");
    });
    $("#empleados").on("select2:select", function(e) {
        $("#cantidad").focus();
    });


    //Datatable para modal salidas de stock(Articulos agregados)
    $("#tabla-salidastock").DataTable({
        language: {
            url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
        },
        "paging":   false,
    });


    //Imprimir stock disponible en el placeholder del input cantidad
    $("#articulos").on("select2:select", function(e) { 
        data=$("#articulos").select2('data')[0];
        $("#cantidad").attr('placeholder', data.stock+" "+data.unidad+"es disponibles" );
        $("#cantidad").attr('data-stock', data.stock);
    });

    $("#empleados").on("select2:select", function(e) { 
        data=$("#empleados").select2('data')[0];
        $("#cargo").empty();
        $("#sector").empty();
        $("#cargo").append("Cargo: "+ data.cargo);
        $("#sector").append("Sector: "+ data.sector);
    });



    //Agregar articulos a datatable
    var contador = 1;
    $("#agregar").on( 'click', function () {
        var articulos = $("#articulos :selected").text();
        var articulosid = $("#articulos :selected").val();
        var empleados = $("#empleados :selected").text();
        var empleadosid = $("#empleados :selected").val();
        var cantidad = $("#cantidad").val();
        var stock = $("#cantidad").data('stock');
        var cero = 0;

        //Validaciones antes de agregar articulos a la tabla
        if(cantidad <= stock && cantidad > 0 && empleados.length != 0 && empleadosid.length != 0 && articulos.length != 0 && articulosid.length != 0)
        {
            var stockrestante = stock - cantidad;
            

                
            $("#tabla-salidastock").DataTable().row.add( [
                contador,
                articulos+"<input type='hidden' name='articulos[]' value='"+articulosid+"'>",
                cantidad+"<input type='hidden' name='cantidad[]' value='"+cantidad+"'>",
                empleados+"<input type='hidden' name='empleados[]' value='"+empleadosid+"'>",

                "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
            ] ).draw( false );
            contador++;
            $("#articulos").select2("val", "");
            $("#empleados").select2("val", "");
            $("#cantidad").val("");
            $("#articulos").select2("open");
            $("#cantidad_error").attr('class', 'form-group');
        }
        else if(cantidad > stock)
        {
            $("#cantidad_error").attr('class', 'form-group has-error');
            $("#cantidad").focus();
            $("#cantidad").val("");
        }
        else if(cantidad <= cero)
        {
            $("#cantidad_error").attr('class', 'form-group has-error');
            $("#cantidad").focus();
            $("#cantidad").val("");
        }
        else{
            alert("No se ha podido agregar el articulo, intente nuevamente.")
        }         
    });


    //Eliminar articulos ingresados en la datatable
    $("#tabla-salidastock tbody").on( "click", ".delete", function () {
        $("#tabla-salidastock").DataTable()
            .row( $(this).parents("tr") )
            .remove()
            .draw();
    });
</script>
@stop
