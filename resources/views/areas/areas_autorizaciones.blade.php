@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE AUTORIZACIONES
    </div>
    <div class="boton_titulo">
        <a class="btn btn-success" href="/areas/autorizaciones/nueva" id="addsalida">
        <i class="fa fa-plus"></i> Autorizar movimiento</a>
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
                        <th></th>
                        <th>ID</th>
                        <th>Subarea</th>
                        <th>Fecha que registra</th>
                        <th>Usuario</th>
                        <th>Estado</th>
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
            "ajax": "/datatables/autorizar",
            "error": function () {
                alert( 'Custom error' );
              },
            "columns":[
                {
                    className:      'details-control',
                    orderable:      false,
                    searchable:      false,
                    data:           null,
                    defaultContent: ''
                },
                {data: 'id_master', name: 'autorizaciones_master.id_master'},
                {data: 'descripcion_subarea', name: 'subareas.descripcion_subarea'},
                {data: 'updated_at', name: 'autorizaciones_master.updated_at'},
                {data: 'name', name: 'users.name'},
                {data: 'estado', name: 'autorizaciones_master.estado'},
            ],
            "order": [ 3, "desc" ],
            language: {
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            }
        });

        $("#tabla-movimientos tbody").on("click", "td.details-control", function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var tableId = row.data().id_master;
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                format(row.child, tableId);
                tr.addClass('shown');
            }
        });
        //FIN EVENTO---------------------------------------------------------------------------------------------------

        //FUNCION INICIAR TABLA DETALLES-------------------------------------------------------------------------------

        function format(callback, $tableId) {
            $.ajax({
                url: "/ajax/autorizacionestabledetails/" + $tableId,
                dataType: "json",
                beforeSend: function(){
                    callback($('<div align="center">Cargando...</div>')).show();
                },
                complete: function (response) {
                    var data = JSON.parse(response.responseText);   
                    var thead = '',  tbody = '';
                    thead += '<th>#</th>';
                    thead += '<th>Articulo solicitado</th>';
                    thead += '<th>Tipo</th>';  
                    thead += '<th>Empleado solicitante</th>'; 
                    thead += '<th>Cantidad solicitada</th>'; 
                    thead += '<th>Estado</th>'; 

                    count = 1;
                    $.each(data, function (i, d) {
                        switch(d.estado) {
                            case 0:
                                d.estado = "<span class='label label-warning'>Pendiente</span>";
                                break;
                            case 1:
                                d.estado = "<span class='label label-success'>Autorizado</span>";
                                break;
                            case 2:
                                d.estado = "<span class='label label-danger'>Rechazado</span>";
                                break;
                        }
                        tbody += '<tr><td>'+ count +'</td><td>' + d.descripcion + '</td><td>' + d.tipo + '</td><td>' + d.apellidos + ', '+ d.nombres+ '</td><td>'+ d.cantidad+'</td><td>'+ d.estado+'</td></tr>';
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