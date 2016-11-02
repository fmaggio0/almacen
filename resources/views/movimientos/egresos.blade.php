@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="#" id="addsalida">
        <i class="fa fa-plus"></i> Nueva salida</a>
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


    <!-- Datatables Salidas Master -->
    <div class="box">
        <div class="box-body">
            <table id="tabla-movimientos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nro documento</th>
                        <th>Tipo de movimiento</th>
                        <th>Area</th>
                        <th>Subarea</th>
                        <th>Fecha que registra</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Incluir Formulario Salida de stock-->
    @include('movimientos.modalsMovimientos.salidastock')
    <!-- Incluir Formulario Editar salida pendiente -->
    @include('movimientos.modalsMovimientos.edit-salidastock')

@stop

@section('js')

    <script>

    $(document).ready( function () {

        //Ocultar mensajes de error o success
        $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
            $("ocultar").alert('close');
        });


        //Script Datatable Salidas Master y detalles
        var table = 
        $("#tabla-movimientos").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/datatables/salidas",
            "error": function () {
                alert("Custom error");
            },
            "columns":[
                {
                    className:"details-control",
                    orderable: false,
                    searchable: false,
                    data: null,
                    defaultContent: ""
                },
                {data: 'id_master', name: 'salidas_master.id_master'},
                {data: 'tipo_retiro', name: 'salidas_master.tipo_retiro'},
                {data: 'descripcion_area', name: 'areas.descripcion_area'},
                {data: 'subarea', name: 'subareas.descripcion_subarea'},
                {data: 'updated_at', name: 'salidas_master.updated_at'},
                {data: 'name', name: 'users.name'},
                {data: 'estado', name: 'salidas_master.estado'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
                //extra info columnas hidden
                {data: 'id_tabla', name: 'salidas_master.id_tabla', visible: false},
                {data: 'id_subarea', name: 'salidas_master.id_subarea', visible: false}
            ],
            "order": [ 5, "desc" ],
            "language":{
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            }
        });
        $("#tabla-movimientos tbody").on("click", "td.details-control", function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var tableId = row.data().id_tabla;
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                format(row.child, tableId);
                tr.addClass('shown');
            }
        });
        function format(callback, $tableId) {
            $.ajax({
                url: "/ajax/salidastabledetails/" + $tableId,
                dataType: "json",
                beforeSend: function(){
                    callback($('<div align="center">Cargando...</div>')).show();
                },
                complete: function (response) {
                    var data = JSON.parse(response.responseText);   
                    var thead = '',  tbody = '';
                    thead += '<th>#</th>';
                    thead += '<th>Articulo</th>'; 
                    thead += '<th>Empleado</th>'; 
                    thead += '<th>Cantidad</th>'; 

                    count = 1;
                    $.each(data, function (i, d) {
                        tbody += '<tr><td>'+ count +'</td><td>' + d.Articulo + '</td><td>' + d.Apellido + ', '+ d.Nombre+ '</td><td>'+ d.Cantidad+'</td></tr>';
                        count++;
                    });
                    callback($('<table class="table table-hover">' + thead + tbody + '</table>')).show();
                },
                error: function () {
                    callback($('<div align="center">Ha ocurrido un error. Intente nuevamente y si persigue el error, contactese con informática.</div>')).show();
                }
            });
        }


        //Activar modal salidas de stock
        $('#addsalida').click(function(){
            $("#salidastock").modal(); 
        });
        

        //Cerrar modal salidas de stock
        $(".close").click(function() {
            $('#salidastock').modal('hide');
        });


        //Plugins select para modal de salida
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