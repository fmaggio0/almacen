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


<form method="POST" action="/movimientos/addingreso" class="form-horizontal">

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">

    		<div class="panel-heading" style="background: #4682B4; color: #FFFFFF;">
    			<h4 class="panel-title"> Ingreso de Stock</h4> 
    		</div>

    		<!--BODY MODAL -->
    		<div class="panel-body">

    			<div class="form-group">
    				<label class="control-label col-sm-2">Tipo de ingreso:</label>
    				<div class="col-sm-4">
                        <select class="tipo_ingreso form-control" style="width: 100%" required="required" name="tipo_ingreso">
                            <option value="Ingreso por facturacion">Ingreso por facturacion</option>
                            <option value="Ajuste de stock">Ajuste de stock</option>
                        </select>
                    </div>
                    <label class="control-label col-sm-2">Tipo de comprobante:</label>
                    <div class="col-sm-4">
                        <select class=" form-control tipo_comprobante" style="width: 100%" name="tipo_comprobante">
                            <option value="Factura">Factura</option>
                            <option value="Remito">Remito</option>
                            <option value="TIcket">Ticket</option>
                        </select>
                    </div>
    			</div>

    			<div class="form-group">
                    <label class="control-label col-sm-2">Nro de Comprobante:</label>
                    <div class="col-sm-4">
                        <input class=" form-control" style="width: 100%" name="nro_comprobante" type="text">
                    </div>
                    <label class="control-label col-sm-2">Fecha de la Factura:</label>
                    <div class="col-sm-4">
                        <input name="fecha" class="form-control" min="2010-01-01" max="2017-03-03" style="width: 100%" type="date" required="">
                    </div>
                </div>

    			<div class="form-group">
    				<label class="control-label col-sm-2">Proveedor:</label>
    				<div class="col-sm-4">
    					<select id="proveedores" class="form-control" style="width: 100%" name="id_proveedor" ></select>
    				</div>
    				<div class="col-sm-2">
    					<button id="add-proveedor" style="float:left" class="btn btn-success" type="button">+</button>
                        <label class="control-label col-sm-2">Descripcion:</label>
    				</div>
                    <div class="col-sm-4">
                        <textarea class="form-control" rows="2" style="width: 100%" name="descripcion" cols="50"></textarea>
                    </div>
    			</div>

    			<fieldset>
                 	<legend>Detalles</legend>
                    <div class="form-group">
    					<label class="control-label col-sm-2">Articulo:</label>
    					<div class="col-sm-4">
    						<select id="articulos" class="form-control" style="width: 100%"></select>
    					</div>
    					<div class="col-sm-2">
    						<button id="add-articulo" style="float:left" class="btn btn-success" type="button">+</button>
                            <label class="control-label" style="float:right">Cantidad:</label>
    					</div>
    					<div class="col-sm-4">
    						<input id="cantidad" class="form-control" placeholder="Stock actual" min="1" data-stock="" type="number">
    					</div>
    				</div>
    				<div class="form-group">
                        <label class="control-label col-sm-2">Precio Unitario:</label>
                        <div class="col-sm-4">
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input type="number" min="0" style="width: 35%" class="form-control currency" id="precio_unitario">
                            </div>
                        </div>
    					<div class="col-sm-2" style="float:right">
    						<button id="agregar" style="float:right" class="btn btn-success" type="button">Agregar</button>
    					</div>
    				</div> 
           		</fieldset>

           	 	<!-- DATATABLE ARTICULOS-->
    	       	<div class="box">
    	            <div class="box-body">
    	                <table id="tabla-articulos-ingresados" class="table table-striped table-bordered"  cellspacing="0" width="100%">
    	                    <thead>
    	                        <tr>
    	                            <th>Nro Item</th>
    	                            <th>Articulo</th>
    	                            <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Importe</th>
    	                            <th>Acciones</th>
    	                        </tr>
    	                    </thead>
                            <tfoot>
                                <tr>    
                                    <th colspan="6" style="text-align:right"></th>
                                </tr>
                            </tfoot>
    	                </table>
    	   			</div>
    			</div>

    		</div>

    		<div class="panel-footer">
                <input name="id_usuario" type="hidden" value="{{Auth::user()->id}}">
                <input class="btn btn btn-primary" type="submit" value="Despachar">
    		</div>

        </div>
    </div>
</div>

</form>

<!-- Crear nuevo articulo -->
@include('configuraciones.modalsArticulos.create')
<!-- Crear nuevo proveedor -->
@include('configuraciones.modalsProveedores.create')

@stop

@section('js')

<script>
	$("#add-proveedor").click(function(){
        $("#crearproveedor").modal(); 
    });

	$("#add-articulo").click(function(){
        $("#creararticulo").modal();
    });

    $("#close-add-articulo").click(function(){
        $("#creararticulo").modal("hide");
    });

    $("#close-add-proveedor").click(function(){
        $("#crearproveedor").modal("hide");
    });

	//BLOQUEAR INPUTS SI SE SELECCIONA AJUSTE DE STOCK
	$(".tipo_ingreso").change(function() {
    	if ($(this).val() == "Ajuste de stock") 
	    {
	        $(".tipo_comprobante").attr("disabled",true);
	        $("input[name=nro_comprobante]").attr("disabled", true);
	        $("#proveedores").attr("disabled", true);
	        $("#add-proveedor").attr("disabled", true);
	    }
	    else
	    {
	    	$(".tipo_comprobante").attr("disabled",false);
	        $("input[name=nro_comprobante]").attr("disabled",false);
	        $("#proveedores").attr("disabled", false);
	        $("#add-proveedor").attr("disabled", false);

	    }
	});

    $("#tabla-articulos-ingresados").DataTable({
	    language: {
	        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
	    },
	    "paging":   false,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 5 ).footer() ).html(
                "Total: $"+total+"<input type='hidden' name='total_factura' value='"+total+"'>"
            );
        }
    });	

	//Agregar articulos a datatable
    var contador = 1;
    $("#agregar").on( 'click', function () {
        var articulos = $("#articulos :selected").text();
        var articulosid = $("#articulos :selected").val();
        var cantidad = $("#cantidad").val();
        var precio_unitario = $("#precio_unitario").val();
        var importe = cantidad * precio_unitario;


        if(cantidad > 0 && articulos.length != 0 && articulosid.length != 0)
        {
            $("#tabla-articulos-ingresados").DataTable().row.add( [
                contador,
                articulos+"<input type='hidden' name='articulos[]' value='"+articulosid+"'>",
                cantidad+"<input type='hidden' name='cantidad[]' value='"+cantidad+"'>",
                precio_unitario + "<input type='hidden' name='precio_unitario[]' value='"+precio_unitario+"'>",
                "$ "+importe,
                "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
            ] ).draw( false );
            contador++;
            $("#articulos").select2("val", "");
            $("#cantidad").val("");
            $("#precio_unitario").val("");
            $("#articulos").select2("open");
        }
        else
        {
            alert("No se ha podido agregar el articulo, intente nuevamente.");
        }         
    });

    //Eliminar articulos ingresados en la datatable
    $("#tabla-articulos-ingresados tbody").on( "click", ".delete", function () {
        $("#tabla-articulos-ingresados").DataTable()
            .row( $(this).parents("tr") )
            .remove()
            .draw();
    });

    //Imprimir stock disponible en el placeholder del input cantidad
    $("#articulos").on("select2:select", function(e) { 
        data=$("#articulos").select2('data')[0];
        $("#cantidad").attr('placeholder', data.stock+" "+data.unidad+"es disponibles" );
        $("#cantidad").attr('data-stock', data.stock);     
    });

    //Plugins select para modal de salida
    $("#articulos").select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        language: "es",
        placeholder: "Seleccione un articulo",
        allowClear: true,
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

    $("#proveedores").select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        language: "es",
        placeholder: "Seleccione un proveedor",
        allowClear: true,
        ajax:   
        {
            url: "/ajax/proveedores",
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
</script>

@stop