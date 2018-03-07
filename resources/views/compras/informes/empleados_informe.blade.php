@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INFORMES DE EMPLEADOS
    </div>
@stop

@section('main-content')

    
    <!-- Datatables Salidas Master -->
    <div class="box">
        <div class="box-header" style="background: #4682B4; color: #FFFFFF;"><p class="panel-title">INFORME DE SALIDAS DEL EMPLEADO: <b>{{ $empleados->apellidos }}, {{ $empleados->nombres }}</b></p></div>
        <div class="box-body">
            <table id="tabla-empleados" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nro documento</th>
                        <th>Articulo</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Nombre y apellido</th>
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
        "ajax": "/datatables/empleado/"+ {{ $empleados->id_empleado }},
        "error": function () {
            alert("Custom error");
        },
        "columns":[
            {data: 'id_master', name: 'salidas_detalles.id_master'},
            {data: 'descripcion', name: 'articulos.descripcion'},
            {data: 'tipo', name: 'articulos.tipo'},
            {data: 'cantidad', name: 'salidas_detalles.cantidad'},
            {data: 'updated_at', name: 'salidas_master.updated_at'},
            {data: 'full_name', name: 'full_name', orderable: false, searchable: false, visible: false},
        ],
        "order": [ 4, "desc" ],
        "language":{
            url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
        }
    });
});
</script>

@stop