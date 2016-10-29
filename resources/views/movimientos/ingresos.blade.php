@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION INGRESO DE STOCK
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="#" id="addsalida">
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
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Incluir Formulario -->
    @include('movimientos.modalsMovimientos.ingresostock')

    <!-- Crear nuevo articulo -->
    @include('configuraciones.modalsArticulos.create')
    <!-- Crear nuevo proveedor -->
    @include('configuraciones.modalsProveedores.create')

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
                {data: 'updated_at', name: 'ingresos_master.updated_at'},
                {data: 'name', name: 'users.name'},
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
                    var data = JSON.parse(response.responseText);   
                    var thead = '',  tbody = '';
                    thead += '<th>#</th>';
                    thead += '<th>Articulo</th>'; 
                    thead += '<th>Cantidad ingresada</th>'; 

                    count = 1;
                    $.each(data, function (i, d) {
                        tbody += '<tr><td>'+ count +'</td><td>' + d.Articulo + '</td><td>'+ d.Cantidad+'</td></tr>';
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
            $("#ingresostock").modal(); 
        });

        //Cerrar modal ingreso de stock
        $("#cerraringreso").click(function() {
            $('#ingresostock').modal('hide');
        });

        //Datatable para modal salidas de stock(Articulos agregados)

    });
    </script>
@endsection