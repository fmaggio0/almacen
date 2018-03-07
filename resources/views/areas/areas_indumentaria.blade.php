@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INDUMENTARIA
    </div>
@stop

@section('main-content')
    <!-- Mensajes de exito-->
    @if (session('status'))
        <div class="alert alert-success" id="ocultar">
            {{ session('status') }}
        </div>
    @endif
    <div class="box">
        <div class="box-body">
            <table id="tabla-movimientos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Area</th>
                        <th>Funcion</th>
                        <th>Talle remera</th>
                        <th>Talle camisa</th>
                        <th>Talle calzado</th>
                        <th>Ultima vez modificado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
@stop

@section('js')
    <script>
    $(document).ready( function () {

    //Ocultar mensajes de error o success
    $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
        $("ocultar").alert('close');
    });
    
    //DAtatables 

        var table = $('#tabla-movimientos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/datatables/indumentaria",
            "error": function () {
                alert( 'Custom error' );
              },
            "columns":[
                {data: 'nombres', name: 'empleados.nombres'},
                {data: 'apellidos', name: 'empleados.apellidos'},
                {data: 'descripcion_area', name: 'areas.descripcion_area'},
                {data: 'funcion', name: 'empleados.funcion'},
                {data: 'talle_remera', name: 'empleados.talle_remera'},
                {data: 'talle_camisa', name: 'empleados.talle_camisa'},
                {data: 'talle_calzado', name: 'empleados.talle_calzado'},
                {data: 'updated_at', name: 'empleados.updated_at'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},   
            ],
            "order": [ 1, "desc" ],
            language: {
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            }
        });

    });
    </script>
@stop