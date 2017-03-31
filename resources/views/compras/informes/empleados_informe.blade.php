@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INFORMES DE EMPLEADOS
    </div>
@stop

@section('main-content')

    
    <!-- Datatables Salidas Master -->
    <div class="box">
        <div class="box-body">
            <table id="tabla-empleados" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nro documento</th>
                        <th>Tipo de movimiento</th>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Nombre y apellido</th>
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

    //Script Datatable Salidas Master y detalles
    var table = 
    $("#tabla-empleados").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/datatables/empleado/"+ {{ $id }},
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
            {data: 'id_master', name: 'salidas_detalles.id_master'},
            {data: 'tipo_retiro', name: 'salidas_master.tipo_retiro'},
            {data: 'descripcion', name: 'articulos.descripcion'},
            {data: 'cantidad', name: 'salidas_detalles.cantidad'},
            {data: 'updated_at', name: 'salidas_master.updated_at'},
            {data: 'full_name', name: 'full_name', orderable: false, searchable: false, visible: false},
            {data: 'action', name: 'action' , orderable: false, searchable: false},
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(6, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="9" style="background-color: #bdbdbd;">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            });
        },
        "order": [ 5, "desc" ],
        "language":{
            url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
        }
    });
   /* $("#tabla-movimientos tbody").on("click", "td.details-control", function () {
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
    }*/
});
</script>

@stop