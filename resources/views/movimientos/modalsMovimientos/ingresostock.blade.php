<div class="modal fade" id="ingresostock" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

<div class="modal-dialog modal-lg">

<div class="modal-content">

	{!! Form::open(['route' => 'addingreso', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}

		<!--HEADER MODAL -->
		<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
			<button type="button" class="close" id="cerraringreso" date-dismiss='modal' aria-hidden='true'>&times;</button>
			<h4 class="modal-title"> Ingreso de Stock</h4> 
		</div>

		<!--BODY MODAL -->
		<div class="modal-body">
			<div class="form-group">
				{!! Form::label(null, 'Tipo de ingreso:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::select('tipo_ingreso', array( 'Ingreso por facturacion' => 'Ingreso por facturacion', 'Ajuste de stock' => 'Ajuste de stock',), null ,array('class'=>'tipo_ingreso form-control', 'style' => 'width: 100%', 'required' => 'required')) 
                !!}
				</div>
				{!! Form::label(null, 'Tipo de comprobante:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::select('tipo_comprobante', array('Factura' => 'Factura', 'Remito' => 'Remito', 'TIcket' => 'Ticket'), null ,array('class'=>' form-control tipo_comprobante', 'style' => 'width: 100%')) 
                    !!}
				</div>
					

			</div>
			<div class="form-group">
				{!! Form::label(null, 'Nro de Comprobante:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::text('nro_comprobante', null ,array('class'=>' form-control', 'style' => 'width: 100%')) 
                    !!}
				</div>
				{!! Form::label(null, 'Fecha de la Factura:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
                    <input name="fecha" class="form-control" min="2010-01-01" max="{{ \Carbon\Carbon::now()->toDateString() }}" style="width: 100%"  type="date">
				</div>
					
				
			</div>
			<div class="form-group">
				{!! Form::label(null, 'Proveedor:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::select('id_proveedor', array('' => ''), null ,array('id' => 'proveedores', 'class'=>' form-control', 'style' => 'width: 100%')) 
	                !!}
				</div>
				<div class="col-sm-2">
					{!! Form::button('+', array('id' => 'add-proveedor', 'style' =>"float:left", 'class'=>'btn btn-success')) !!}
                    {!! Form::label(null, 'Descripcion:', array('class' => 'control-label col-sm-2')) !!}
				</div>
                <div class="col-sm-4">
                    {!! Form::textarea('descripcion', null, array('class' => 'form-control', 'rows' => '2', 'style' => 'width: 100%')) 
                    !!}
                </div>
			</div>

			<fieldset>
             	<legend>Detalles</legend>
                <div class="form-group">
					{!! Form::label(null, 'Articulo:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-4">
						{!! Form::select('', array('' => ''), null ,array('id' => 'articulos', 'class'=>' form-control', 'style' => 'width: 100%')) !!}

					</div>
					<div class="col-sm-2">
						{!! Form::button('+', array('id' => 'add-articulo', 'style' =>"float:left", 'class'=>'btn btn-success')) !!}
						{!! Form::label(null, 'Cantidad:', array('class' => 'control-label','style' =>"float:right")) !!}
					</div>
					<div class="col-sm-4">
						{!! Form::number('',  null, array('id' => 'cantidad', 'class' => 'form-control', 'placeholder' => 'Stock actual', 'min' => '1', 'data-stock' => '')) !!}
					</div>
				</div>
				<div class="form-group">
                    {!! Form::label(null, 'Precio Unitario:', array('class' => 'control-label col-sm-2')) !!}
                    <div class="col-sm-4">
                        <div class="input-group"> 
                            <span class="input-group-addon">$</span>
                            <input type="number" min="0" style="width: 35%" class="form-control currency" id="precio_unitario">
                        </div>
                    </div>
					<div class="col-sm-2" style="float:right">
						{!! Form::button('Agregar', array('id' => 'agregar', 'style' =>"float:right", 'class'=>'btn btn-success')) 
                        !!}
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

		</div><!-- fin modal body -->

        {!! Form::hidden('id_usuario', Auth::user()->id) !!}

		<!-- MODAL FOOTER-->
		<div class="modal-footer">
			{!! Form::submit('Despachar', ['class'=>'btn btn btn-primary']) !!}
			{!! Form::close() !!}
		</div>

</div>

</div>

</div>
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

            console.log(total);
 
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
                importe,
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