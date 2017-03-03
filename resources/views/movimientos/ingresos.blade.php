@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION INGRESO DE STOCK
    </div>
    <div class="boton_titulo">
        <a class="btn btn-success" href="/ingresos/nuevo" id="addsalida">
        <i class="fa fa-plus"></i> Nuevo ingreso</a>
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
            <table id="tabla-ingresostock" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nro documento</th>
                        <th>Tipo de ingreso</th>
                        <th>Tipo de comprobante</th>
                        <th>Nro de comprobante</th>
                        <th>Descripcion</th>
                        <th>Proveedor</th>
                        <th>Fecha de la factura</th>
                        <th>Fecha de registro</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

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
        $("#tabla-ingresostock").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/datatables/ingresos",
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
                {data: 'id_master', name: 'ingresos_master.id_master'},
                {data: 'tipo_ingreso', name: 'ingresos_master.tipo_ingreso'},
                {data: 'tipo_comprobante', name: 'ingresos_master.tipo_comprobante'},
                {data: 'nro_comprobante', name: 'ingresos_master.nro_comprobante'},
                {data: 'descripcion', name: 'ingresos_master.descripcion'},
                {data: 'proveedor', name: 'proveedores.nombre'},
                {data: 'fecha_factura', name: 'ingresos_master.fecha_factura'},
                {data: 'created_at', name: 'ingresos_master.created_at'},
                {data: 'estado', name: 'ingresos_master.estado'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
                //Add column extra para obtener el id de la salida en limpio
                {data: 'id_tabla', name: 'ingresos_master.id_master', visible: false},
            ],
            "order": [ 7, "desc" ],
            "language":{
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            }
        });
        $("#tabla-ingresostock tbody").on("click", "td.details-control", function () {
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
                url: "/ajax/ingresostabledetails/" + $tableId,
                dataType: "json",
                beforeSend: function(){
                    callback($('<div align="center">Cargando...</div>')).show();
                },
                complete: function (response) {


                    //METER IF PARA LOS AJUSTE DE STOCK

                    var data = JSON.parse(response.responseText);

                    if(data[0].master[0].tipo_ingreso == "Ajuste de stock"){
                        var thead = '',  tbody = '';
                        thead += '<th>#</th>';
                        thead += '<th>Articulo</th>'; 
                        thead += '<th>Cantidad ingresada</th>'; 

                        count = 1;
                        $.each(data[0].detalles, function (i, d) {
                            var importe = d.Cantidad * d.precio_unitario;
                            tbody += '<tr><td>'+ count +'</td><td>' + d.Articulo + '</td><td>'+ d.Cantidad+'</td></tr>';
                            count++;
                        });
                        callback($('<div class="panel panel-default" style="width: 70%;margin: auto;"><div class="panel-heading"><h3 class="panel-title"><strong>Desglose del movimiento</strong></h3></div><div class="panel-body"><table class="table">' + thead + tbody + '</table></div></div>')).show();
                    }
                    else{
                        var thead = '',  tbody = '';
                        thead += '<th>#</th>';
                        thead += '<th>Articulo</th>'; 
                        thead += '<th>Cantidad ingresada</th>'; 
                        thead += '<th>Precio unitario</th>';
                        thead += '<th>Importe</th>';  

                        count = 1;
                        $.each(data[0].detalles, function (i, d) {
                            var importe = d.Cantidad * d.precio_unitario;
                            tbody += '<tr><td>'+ count +'</td><td>' + d.Articulo + '</td><td>'+ d.Cantidad+'</td><td> $ '+ d.precio_unitario+'</td><td> $ '+ importe+'</td></tr>';
                            count++;
                        });
                        callback($('<div class="panel panel-default" style="width: 70%;margin: auto;"><div class="panel-heading"><h3 class="panel-title"><strong>Desglose del movimiento</strong></h3></div><div class="panel-body"><table class="table">' + thead + tbody + '<tr class="thick-line"><td></td><td></td><td></td><td><strong>Total:</strong></td><td>$ '+data[0].master[0].total_factura+'</td></tr></table></div></div>')).show();
                    }
                },
                error: function () {
                    callback($('<div align="center">Ha ocurrido un error. Intente nuevamente y si persigue el error, contactese con informática.</div>')).show();
                }
            });
        }
    });
    </script>
@stop