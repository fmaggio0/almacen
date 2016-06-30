@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

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
        <div class="box tabla-articulos">
            <div class="box-body no-padding">
                <table id="tabla-movimientos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Tipo de movimiento</th>
                            <th>Area</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Tipo de movimiento</th>
                            <th>Area</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        <tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('usuario.modalsMovimientosAut.crear_autorizacion')
        @include('usuario.modalsMovimientosAut.detalles') 

        <script>
       $(document).ready( function () {

        //DAtatables 

            var template = Handlebars.compile($("#details-template").html());
            var table = $('#tabla-movimientos').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/usuario/tabla",
                "error": function () {
                    alert( 'Custom error' );
                  },
                "columns":[
                    {
                        className:      'details-control',
                        orderable:      false,
                        searchable:      false,
                        data:           null,
                        defaultContent: '+'
                    },
                    {data: 'id_master', name: 'autorizaciones_master.id_master'},
                    {data: 'tipo_retiro', name: 'autorizaciones_master.tipo_retiro'},
                    {data: 'descripcion_subarea', name: 'subareas.descripcion_subarea'},
                    {data: 'updated_at', name: 'autorizaciones_master.updated_at'},
                    {data: 'name', name: 'users.name'},
                    {data: 'estado', name: 'autorizaciones_master.estado'},
                    {data: 'action', name: 'action' , orderable: false, searchable: false},
                ],

                language: {
                    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                }
            });

            // Add event listener for opening and closing details
            $('#tabla-movimientos tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var tableId = row.data().id_master;
                
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('shown');
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            });

            function initTable(tableId, data) {
                $(".details-table").attr("id", "post-"+tableId );
                $('#post-' + tableId).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "paging": false,
                    "bFilter": false,
                    "error": function () {
                    alert( 'Custom error' );
                    },
                    "ajax": "/usuario/tabladetalles/id="+ tableId ,
                    columns: [
                        {data: 'descripcion', name: 'articulos.descripcion'},
                        {data: 'nombre', name: 'empleados.nombre'},
                        {data: 'cantidad', name: 'autorizaciones_detalles.cantidad'}
                    ],
                    language: {
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }

                })
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
                        url: "/movimientos/empleados",
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
                minimumResultsForSearch: 10,
                language: "es",
                placeholder: "Seleccione un articulo",
                allowClear: true,
                tokenSeparators: [','],
                ajax:   
                    {
                        url: "/movimientos/articulos",
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
            

            var iduser = $("#id_usuario").val();
            $("#destinos").select2({
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                language: "es",
                placeholder: "Seleccione un destino",
                allowClear: true,
                tokenSeparators: [','],
                ajax:   
                    {
                        url: "/usuario/subareas/id="+iduser,
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
@endsection