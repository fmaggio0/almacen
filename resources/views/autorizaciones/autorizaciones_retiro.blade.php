@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE AUTORIZAIONES
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
                            <th>SubArea</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


        @include('autorizaciones.modalsAutorizaciones.edit') 

        @include('usuario.modalsMovimientosAut.detalles') 

        <script>
        $(document).ready( function () {

            //DATATABLE MASTER---------------------------------------------------------------------------------------------

            var template = Handlebars.compile($("#details-template").html());
            var table = $('#tabla-movimientos').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/datatables/autorizaciones",
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
                    {data: 'descripcion_area', name: 'areas.descripcion_area'},
                    {data: 'descripcion_subarea', name: 'subareas.descripcion_subarea'},
                    {data: 'updated_at', name: 'autorizaciones_master.updated_at'},
                    {data: 'name', name: 'users.name'},
                    {data: 'estado', name: 'autorizaciones_master.estado'},
                    {
                        className:      'edit',
                        orderable:      false,
                        searchable:      false,
                        data:           null,
                        defaultContent: "<a href='#' class='btn btn-xs btn-primary edit'><i class='glyphicon glyphicon-edit edit'></i></a>"
                    },
                    //extra info columnas hidden
                    {data: 'id_subarea', name: 'autorizaciones_master.id_subarea', visible: false},

                ],
                "order": [ 5, "desc" ],
                language: {
                    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                }
            });
            //FIN DATATABLE MASTER-----------------------------------------------------------------------------------------

            //EVENTO CLICK EN BOTON MAS------------------------------------------------------------------------------------

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
                    initTable(tableId);
                    tr.addClass('shown');
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            });

            //FIN EVENTO---------------------------------------------------------------------------------------------------

            //FUNCION INICIAR TABLA DETALLES-------------------------------------------------------------------------------

            function initTable(tableId) {
                $(".details-table").attr("id", "post-"+tableId );
                $('#post-' + tableId).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "paging": false,
                    "bFilter": false,
                    "error": function () {
                    alert( 'Custom error' );
                    },
                    "ajax": "/datatables/autorizaciones-detalles/"+ tableId ,
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

            //FIN FUNCION INICIAR TABLA DETALLES---------------------------------------------------------------------------
               
            //MODAL EDIT---------------------------------------------------------------------------------------------------

                //datatable detalles en modal------------------------------------------------------------------------------

                $("#tabla-salidastock").DataTable({
                    language: {
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    },
                    "paging":   false,
                });

                //fin datatable detalles en modal--------------------------------------------------------------------------

                //select2 modal edit---------------------------------------------------------------------------------------

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

                //fin select2 modal edit-----------------------------------------------------------------------------------

                //evento iniciar modal edit--------------------------------------------------------------------------------

                $('#tabla-movimientos tbody').on('click', 'td.edit', function () {


                    var filadata = table.row( this ).data();
                    console.log(filadata);

                    $("#destinos").val(filadata.descripcion_subarea);
                    $("#id_subarea").val(filadata.id_subarea);
                    $("#id_autorizacion").val(filadata.id_master);
                    $("#tipo_retiro").val(filadata.tipo_retiro);

                    $ ("#view_autorizacion").modal();
                    $.getJSON("/autorizaciones/details/"+filadata.id_master, function (json) { //para modal edit y add
                        $("#tabla-salidastock").DataTable().clear();
                        for (var i=0;i<json.length;++i)
                        {
                            $("#tabla-salidastock").DataTable().row.add( [
                            json[i].descripcion+"<input type='hidden' name='articulos1[]' value='"+json[i].id_articulo+"'>",
                             json[i].cantidad+"<input type='hidden' name='cantidad1[]' value='"+json[i].cantidad+"'>",
                            json[i].apellido+", "+json[i].nombre+"<input type='hidden' name='empleados1[]' value='"+json[i].id_empleado+"'>",
                            "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
                            ] ).draw( false );
                        }
                            
                    });

                });

                //fin evento iniciar modal edit----------------------------------------------------------------------------

                //focus accesibilidad--------------------------------------------------------------------------------------

                $('#salidastock').on('shown.bs.modal', function() {
                    $(".tipo_retiro").focus();
                });
                $(".tipo_retiro").blur(function (){
                    $("#destinos").select2("open");
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

                //fin focus accesibilidad----------------------------------------------------------------------------------

                //evento para crear placeholder con cantidad disponible----------------------------------------------------

                $("#articulos").on("select2:select", function(e) { 
                    data=$("#articulos").select2('data')[0];
                    $("#cantidad").attr('placeholder', data.stock+" "+data.unidad+"es disponibles" );
                });

                //fin evento para crear placeholder con cantidad disponible------------------------------------------------

                //evento que no sirve, reutilizable para asignar a determinada tarea segun area----------------------------
                $("#destinos").on("select2:select", function(e) {
                    $("#subdestinos").attr('disabled', false);
                    var destinoid = $("#destinos :selected").val();
                    $.getJSON("/ajax/subareas/"+ destinoid, function (json) { //para modal edit y add
                            $("#subdestinos").select2({
                                data: json,
                                language: "es",
                                placeholder: "IGNORAR POR AHORA... VER QUE HACER",
                                allowClear: true
                            });
                    });
                });

                //evento qe no sirve---------------------------------------------------------------------------------------

                //evento para agregar inputs a tabla segun detalles del formulario-----------------------------------------
                $("#agregar").on( 'click', function () {
                    var articulos = $("#articulos :selected").text();
                    var articulosid = $("#articulos :selected").val();
                    var empleados = $("#empleados :selected").text();
                    var empleadosid = $("#empleados :selected").val();
                    var cantidad = $("#cantidad").val();

                    $("#tabla-salidastock").DataTable().row.add( [
                        articulos+"<input type='hidden' name='articulos1[]' value='"+articulosid+"'>",
                        cantidad+"<input type='hidden' name='cantidad1[]' value='"+cantidad+"'>",
                        empleados+"<input type='hidden' name='empleados1[]' value='"+empleadosid+"'>",

                        "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
                    ] ).draw( false );
                    contador++;

                    $("#articulos").select2("val", "");
                    $("#empleados").select2("val", "");
                    $("#cantidad").val("");
                    $("#articulos").select2("open");
                });

                $("#tabla-salidastock tbody").on( "click", ".delete", function () {
                    $("#tabla-salidastock").DataTable()
                        .row( $(this).parents("tr") )
                        .remove()
                        .draw();
                });

                //fin evento para agregar inputs a tabla segun detalles del formulario--------------------------------------

            //FIN MODAL EDIT-----------------------------------------------------------------------------------------------

            //EVENTO CERRAR MODAL------------------------------------------------------------------------------------------

                $('.close').click(function() {
                    $('#view_autorizacion').modal('hide');
                });

            //FIN EVENTO CERRAR MODAL --------------------------------------------------------------------------------------

        });
        </script>
@endsection