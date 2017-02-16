@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE AUTORIZACIONES
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="#" id="addsalida">
        <i class="fa fa-plus"></i> Autorizar movimiento</a>
    </div>
@stop

@section('main-content')
        <div class="box">
            <div class="box-body">
                <table id="tabla-movimientos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Tipo de movimiento</th>
                            <th>Subarea</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('usuario.modalsMovimientosAut.crear_autorizacion')
@stop

@section('js')
    <script>
    $(document).ready( function () {

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
                {data: 'tipo_retiro', name: 'autorizaciones_master.tipo_retiro'},
                {data: 'descripcion_subarea', name: 'subareas.descripcion_subarea'},
                {data: 'updated_at', name: 'autorizaciones_master.updated_at'},
                {data: 'name', name: 'users.name'},
                {data: 'estado', name: 'autorizaciones_master.estado'},
            ],
            "order": [ 4, "desc" ],
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
                    thead += '<th>Empleado solicitante</th>'; 
                    thead += '<th>Cantidad solicitada</th>'; 

                    count = 1;
                    $.each(data, function (i, d) {
                        tbody += '<tr><td>'+ count +'</td><td>' + d.descripcion + '</td><td>' + d.Apellido + ', '+ d.Nombres+ '</td><td>'+ d.cantidad+'</td></tr>';
                        count++;
                    });
                    callback($('<table class="table table-hover">' + thead + tbody + '</table>')).show();
                },
                error: function () {
                    callback($('<div align="center">Ha ocurrido un error. Intente nuevamente y si persigue el error, contactese con informática.</div>')).show();
                }
            });
        }


        //MODAL SALIDA STOCK
        $('#addsalida').click(function(){
            $("#salidastock").modal();
            
        });
        $('.close').click(function() {
            $('#salidastock').modal('hide');
        });

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
                            };
                        });
                        return { results: data };
                    },
                    cache: true
                }
        });

        $("#articulos").select2({
            minimumInputLength: 2,
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
        
        $("#destinos").select2({
            minimumInputLength: 2,
            language: "es",
            placeholder: "Seleccione un destino",
            allowClear: true,
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
    </script>
@stop