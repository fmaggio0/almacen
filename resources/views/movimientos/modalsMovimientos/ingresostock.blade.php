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
				{!! Form::label(null, 'Descripcion:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::textarea('descripcion', null, array('class' => 'form-control', 'rows' => '2', 'style' => 'width: 100%')) 
                    !!}
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
					<div class="col-sm-2" style="float:right">
						{!! Form::button('Agregar', array('id' => 'agregar', 'style' =>"float:right", 'class'=>'btn btn-success')) 
                        !!}
					</div>
				</div> 
       		</fieldset>

       	 	<!-- DATATABLE ARTICULOS-->
	       	<div class="box">
	            <div class="box-body">
	                <table id="tabla-articulos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
	                    <thead>
	                        <tr>
	                            <th>Nro Item</th>
	                            <th>Articulo</th>
	                            <th>Cantidad</th>
	                            <th>Acciones</th>
	                        </tr>
	                    </thead>
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

    $("#tabla-articulos").DataTable({
	    language: {
	        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
	    },
	    "paging":   false,
    });	

	//Agregar articulos a datatable
    var contador = 1;
    $("#agregar").on( 'click', function () {
        var articulos = $("#articulos :selected").text();
        var articulosid = $("#articulos :selected").val();
        var cantidad = $("#cantidad").val();

        if(cantidad > 0 && articulos.length != 0 && articulosid.length != 0)
        {
            $("#tabla-articulos").DataTable().row.add( [
                contador,
                articulos+"<input type='hidden' name='articulos[]' value='"+articulosid+"'>",
                cantidad+"<input type='hidden' name='cantidad[]' value='"+cantidad+"'>",
                "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
            ] ).draw( false );
            contador++;
            $("#articulos").select2("val", "");
            $("#cantidad").val("");
            $("#articulos").select2("open");
        }
        else
        {
            alert("No se ha podido agregar el articulo, intente nuevamente.");
        }         
    });

    //Eliminar articulos ingresados en la datatable
    $("#tabla-articulos tbody").on( "click", ".delete", function () {
        $("#tabla-articulos").DataTable()
            .row( $(this).parents("tr") )
            .remove()
            .draw();
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