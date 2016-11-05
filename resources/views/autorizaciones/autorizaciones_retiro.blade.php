@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE AUTORIZAIONES
    </div>
@stop

@section('main-content')

    @if($errors->any())
        <div class="alert alert-warning" role="alert">
              <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <div class="box">
        <div class="box-body">
            <table id="tabla-movimientos" class="table table-bordered"  cellspacing="0" width="100%">
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
@stop

@section('js')
    <script>
    $(document).ready( function () {

        //DATATABLE MASTER---------------------------------------------------------------------------------------------

        var table = 
        $('#tabla-movimientos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/datatables/autorizaciones",
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
                {data: 'descripcion_area', name: 'areas.descripcion_area'},
                {data: 'descripcion_subarea', name: 'subareas.descripcion_subarea'},
                {data: 'updated_at', name: 'autorizaciones_master.updated_at'},
                {data: 'name', name: 'users.name'},
                {data: 'estado', name: 'autorizaciones_master.estado'},
                {data: 'action', name: 'action' , orderable: false, searchable: false},
                //extra info columnas hidden
                {data: 'id_subarea', name: 'autorizaciones_master.id_subarea', visible: false},

            ],
            "order": [ 5, "desc" ],
            "language": {
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            },
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(4, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="9" style="background-color: #bdbdbd;">'+group+'</td></tr>'
                        );
     
                        last = group;
                    }
                });
            },
            "error": function () {
                alert( 'Custom error' );
            }
        });
        //FIN DATATABLE MASTER-----------------------------------------------------------------------------------------

        //EVENTO CLICK EN BOTON MAS------------------------------------------------------------------------------------

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
                    thead += '<th>Articulo solicitado</th>'; 
                    thead += '<th>Empleado solicitante</th>'; 
                    thead += '<th>Cantidad solicitada</th>'; 
                    thead += '<th>Ultima entrega del articulo</th>';
                    thead += '<th>Autorizar o modificar</th>';

                    $.each(data, function (i, d) {
                        if(d.ultimo_entregado){
                            tbody += '<tr><td class="articulo" data-id="'+d.id_articulo+'">' + d.descripcion + '</td><td class="empleado">' + d.Apellido + ', '+ d.Nombres+ '</td><td class="cantidad">'+ d.cantidad+'</td><td class="ultimo_entregado">'+ d.ultimo_entregado+'</td><td> <input type="checkbox" name="autorizar" id="autorizar"><a href="#" class="btn btn-xs btn-primary editar_movimiento" style="float: right;"><i class="glyphicon glyphicon-edit edit"></i></a></td></tr>';
                        }
                        else{
                            tbody += '<tr><td>' + d.descripcion + '</td><td>' + d.Apellido + ', '+ d.Nombres+ '</td><td>'+ d.cantidad+'</td><td> Nunca</td><td> <input type="checkbox" name="autorizar"><a href="#" class="btn btn-xs btn-primary editar_movimiento" style="float: right;"><i class="glyphicon glyphicon-edit edit"></i></a></td></tr>';
                        }
                    });
                    callback($('<div class="panel panel-default" style="width: 70%;margin: auto;"><div class="panel-heading"><h3 class="panel-title"><strong>Desglose del movimiento</strong></h3></div><div class="panel-body"><table class="table">' + thead + tbody + '</table></div></div>')).show();
                },
                error: function () {
                    callback($('<div align="center">Ha ocurrido un error. Intente nuevamente y si persigue el error, contactese con informática.</div>')).show();
                }
            });
        }

        $(document).on('click', '.editar_movimiento', function(){

            $fila = $(this).closest("tr");
            $fila.css('text-decoration','line-through'); 

            $articulo = $(this).closest("tr").find('td.articulo').html();
            $id_articulo = $(this).closest("tr").find('td.articulo').data("id");
            $empleado = $(this).closest("tr").find('td.empleado').html();
            $cantidad = $(this).closest("tr").find('td.cantidad').html();
            $ultimo_entregado = $(this).closest("tr").find('td.ultimo_entregado').html();

            $('<tr><td><select class="articulos" style="width: 100%"></select></td><td>'+$empleado+'</td><td><input class="cantidad" class="form-control" placeholder="Stock actual" min="1" type="number"></td><td>'+$ultimo_entregado+'</td><td><input type="checkbox" name="autorizar" id="autorizar"></td></tr>').insertAfter($fila);
            Iniciarselectarticulos();

            $(".articulos").select2("trigger", "select", {
                data: { id: $id_articulo, text: $articulo }
            });
        
            $(".articulos").on("select2:selecting", function() {
                alert("hola");
            });
        });
        function Iniciarselectarticulos()
        {
            if($('.articulos').length) {
                $(".articulos").select2({
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

            }
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

            

            //fin select2 modal edit-----------------------------------------------------------------------------------

            //evento iniciar modal edit--------------------------------------------------------------------------------

            $('#tabla-movimientos').on('draw.dt', function () {

                $('.edit').click( function () {
                    var tr = $(this).closest('tr');
                    var filadata = table.row(tr).data();

                    $("#destinos").val(filadata.descripcion_subarea);
                    $("#id_subarea").val(filadata.id_subarea);
                    $("#id_autorizacion").val(filadata.id_master);
                    $("#tipo_retiro").val(filadata.tipo_retiro);

                    $ ("#view_autorizacion").modal();
                    $.getJSON("/ajax/autorizaciones-detalles-modal/"+filadata.id_master, function (json) { //para modal edit y add
                        $("#tabla-salidastock").DataTable().clear();
                        for (var i=0;i<json.length;++i)
                        {
                            if(json[i].ultimo_entregado){
                                $("#tabla-salidastock").DataTable().row.add( [
                                    json[i].descripcion+"<input type='hidden' name='articulos[]' value='"+json[i].id_articulo+"'>",
                                    json[i].cantidad+"<input type='hidden' name='cantidad[]' value='"+json[i].cantidad+"'>",
                                    json[i].Apellido+", "+json[i].Nombres+"<input type='hidden' name='empleados[]' value='"+json[i].id_empleado+"'>",
                                    json[i].ultimo_entregado,
                                    "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
                                ] ).draw( false );
                            } 
                            else{
                                $("#tabla-salidastock").DataTable().row.add( [
                                    json[i].descripcion+"<input type='hidden' name='articulos[]' value='"+json[i].id_articulo+"'>",
                                    json[i].cantidad+"<input type='hidden' name='cantidad[]' value='"+json[i].cantidad+"'>",
                                    json[i].Apellido+", "+json[i].Nombres+"<input type='hidden' name='empleados[]' value='"+json[i].id_empleado+"'>",
                                    "Nunca",
                                    "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
                                ] ).draw( false );
                            }
                            
                        }
                            
                    });
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
                    articulos+"<input type='hidden' name='articulos[]' value='"+articulosid+"'>",
                    cantidad+"<input type='hidden' name='cantidad[]' value='"+cantidad+"'>",
                    empleados+"<input type='hidden' name='empleados[]' value='"+empleadosid+"'>",

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
@stop