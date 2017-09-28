@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="/egresos/nuevo">
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
    });
    </script>
@stop