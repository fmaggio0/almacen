@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE AUTORIZAIONES
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

        //Ocultar mensajes de error o success
        $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
            $("ocultar").alert('close');
        });
        
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
                //extra info columnas hidden
                {data: 'id_subarea', name: 'autorizaciones_master.id_subarea', visible: false},

            ],
            "order": [ 4, "asc" ],
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
                    thead += '<th>Stock actual</th>';
                    thead += '<th>Ultima entrega del articulo</th>';
                    thead += '<th>Autorizado</th>';

                    $.each(data, function (i, d) {
                        switch (d.estado) {
                            case 1:
                                estadoformateado = '<label class="label label-success"> SI</label>';
                                break;
                            case 2:
                                estadoformateado = '<label class="label label-danger"> NO</label>';
                                break;
                        }

                        if(!d.ultimo_entregado){
                            d.ultimo_entregado = 'Nunca';
                        }
                        if(d.estado == 0){ 
                            tbody += '<tr>{{ csrf_field() }}<input name="id_usuario" type="hidden" value="{{ Auth::user()->id }}"><input type="hidden" name="id_master" value="'+d.id_master+'"><input type="hidden" name="id_detalles[]" value="'+d.id_detalles+'"><input type="hidden" name="estado[]" class="estado2"><td class="articulo" data-id="'+d.id_articulo+'">' + d.descripcion + '</td><td class="empleado" data-id="'+d.id_empleado+'">' + d.Apellido + ', '+ d.Nombres+ '</td><td class="cantidad">'+ d.cantidad+'</td><td class="stock_actual">'+ d.stock_actual+'</td><td class="ultimo_entregado">'+ d.ultimo_entregado+'</td><td><div class="btn-group" data-toggle="buttons"><label class="btn btn-danger noautorizar_movimiento"><input type="radio" autocomplete="off" checked> No autorizado</label><label class="btn btn-success autorizar_movimiento"><input type="radio" autocomplete="off"> Autorizado</label><label class="btn btn-info editar_movimiento"><input type="radio" class="editar_movimiento" autocomplete="off"> Modificar</label></div></td><td class="estado" required></td></tr>';
                            return estado = 0;

                        }
                        else
                        {
                            tbody += '<tr>{{ csrf_field() }}<input name="id_usuario" type="hidden" value="{{ Auth::user()->id }}"><input type="hidden" name="id_master" value="'+d.id_master+'"><input type="hidden" name="id_detalles[]" value="'+d.id_detalles+'"><input type="hidden" name="estado[]" class="estado2"><td class="articulo" data-id="'+d.id_articulo+'">' + d.descripcion + '</td><td class="empleado" data-id="'+d.id_empleado+'">' + d.Apellido + ', '+ d.Nombres+ '</td><td class="cantidad">'+ d.cantidad+'</td><td class="stock_actual">'+ d.stock_actual+'</td><td class="ultimo_entregado">'+ d.ultimo_entregado+'</td><td class="estado">'+ estadoformateado +'</td></tr>';
                            return estado = 1;
                        }
                    });
                    callback(function(){
                        
                        if(estado == 1){
                            return $('<div class="panel panel-default" style="width: 80%;margin: auto;"><div class="panel-heading"><h3 class="panel-title"><strong>Desglose del movimiento</strong></h3></div><div class="panel-body"><table id="tabla-'+data[0].id_master+'" class="table">' + thead + tbody + '</table></div></div>');
                        }
                        else
                        {
                            return $('<form method="POST" action="/autorizaciones/post" accept-charset="UTF-8" class="form-horizontal"><div class="panel panel-default" style="width: 80%;margin: auto;"><div class="panel-heading"><h3 class="panel-title"><strong>Desglose del movimiento</strong></h3></div><div class="panel-body"><table id="tabla-'+data[0].id_master+'" class="table">' + thead + tbody + '</table></div><div class="panel-footer" style="text-align: right;"><input class="btn btn btn-primary guardar" data-id="'+data[0].id_master+'" type="submit" value="Guardar"></div></div></form>');
                        }
                        
                    }).show();
                },
                error: function () {
                    callback($('<div align="center">Ha ocurrido un error. Intente nuevamente y si persigue el error, contactese con informática.</div>')).show();
                }
            });
        }
        var count = 0;
        $(document).on('click', '.noautorizar_movimiento', function(){
            $fila = $(this).closest("tr");
            $fila.css('text-decoration','line-through');
            $(this).closest("tr").find('td.estado').html("<i class='glyphicon glyphicon-remove'></i>");
            $(this).closest("tr").find('.estado2').val(2);
        });
        $(document).on('click', '.autorizar_movimiento', function(){
            fila = $(this).closest("tr");
            id = $(this).closest('tr').data('id-fila');
            cantidad_td = $(this).closest("tr").find('td.cantidad').html();
            stock_actual = $(this).closest("tr").find('td.stock_actual').html();
            cantidad_input = $(this).closest("tr").find('input.cantidad').val();

            select = $("#articulos-"+id).val();

            if(cantidad_td > 0 || cantidad_input > 0 && select > 0){
                fila.css('text-decoration','');
                $(this).closest("tr").find('td.estado').html("<i class='glyphicon glyphicon-ok'></i>");
                $(this).closest("tr").find('.estado2').val(1);        
            }
            else{
                alert("Ingrese un articulo con su cantidad correctamente.");
            }
        });

        $(document).on('click', '.editar_movimiento', function(){

            $fila = $(this).closest("tr");
            $fila.css('text-decoration','line-through');
            $(this).closest("tr").find('td.estado').html("<i class='glyphicon glyphicon-remove'></i>"); 

            $articulo = $(this).closest("tr").find('td.articulo').html();
            $id_articulo = $(this).closest("tr").find('td.articulo').data("id");
            $empleado = $(this).closest("tr").find('td.empleado').html();
            $id_empleado = $(this).closest("tr").find('td.empleado').data("id");
            $cantidad = $(this).closest("tr").find('td.cantidad').html();
            $ultimo_entregado = $(this).closest("tr").find('td.ultimo_entregado').html();

            $(this).closest("tr").find('label.btn-danger').attr("disabled", true);
            $(this).closest("tr").find('label.btn-success').attr("disabled", true);
            $(this).closest("tr").find('label.btn-info').attr("disabled", true);
            $(this).closest("tr").find('label.btn-info').attr("class", "btn btn-info");

            

            $('<tr data-id-fila="'+count+'" data-id-articulo="'+$id_articulo+'" data-id-empleado="'+$id_empleado+'"><td class="articulo"><select id="articulos-'+count+'" style="width: 100%"></select></td><td>'+$empleado+'</td><td><input class="cantidad form-control" placeholder="Ingrese cantidad" min="1" type="number"></td><td id="stock_actual-'+count+'" class="stock_actual"></td><td id="ultimo_entregado-'+count+'">'+$ultimo_entregado+'</td><td><div class="btn-group" data-toggle="buttons"><label class="btn btn-success autorizar_movimiento"><input type="radio" name="options" id="option2" autocomplete="off"> Autorizar</label><label class="btn btn-danger remove-aut"><input type="radio" name="options" id="option1" autocomplete="off" checked> Eliminar</label></div></td><td class="estado" required></td></tr>').insertAfter($fila);
            Iniciarselectarticulos(count);

            $("#articulos-"+count).select2("trigger", "select", {
                data: { id: $id_articulo, text: $articulo }
            });

            $("#articulos-"+count).on("select2:unselect", function() {
                id = $(this).closest('tr').data('id-fila');
                $("#ultimo_entregado-"+id).html("");
                $("#cantidad-"+id).attr('placeholder', "Stock actual" );
            });

            $("#articulos-"+count).on("select2:selecting", function(e) {
                
                id = $(this).closest('tr').data('id-fila');
                id_articulo = $(this).closest('tr').data('id-articulo');
                id_empleado = $(this).closest('tr').data('id-empleado');
                $("#ultimo_entregado-"+id).html("");

                $("#stock_actual-"+id).html(e.params.args.data.stock+" "+e.params.args.data.unidad+" disponibles");


                $.getJSON("/ajax/ultimoretiroporempleado/"+id_articulo+"/"+id_empleado, function (json) { //para modal edit y add
                    $("#ultimo_entregado-"+id+"").html(json.created_at);
                });
                 
            });

            $(".remove-aut").click(function(){
                $(this).closest("tr").prev().find('label.btn-danger').attr("disabled", false);
                $(this).closest("tr").prev().find('label.btn-danger').attr("class", "btn btn-danger noautorizar_movimiento");
                $(this).closest("tr").prev().find('label.btn-success').attr("disabled", false);
                $(this).closest("tr").prev().find('label.btn-info').attr("disabled", false);
                $(this).closest("tr").prev().find('label.btn-info').attr("class", "btn btn-info editar_movimiento");
                $(this).closest("tr").prev().css('text-decoration', '');
                $(this).closest("tr").prev().find('td.estado').html(""); 
                $(this).closest('tr').remove();
            });


            count++;
        });

        /*$(document).on('click', '.guardar', function(){

            id_tabla = $(this).data('id');

            asad = $("#tabla-"+id_tabla+" input").serialize();

            $.ajax({
                type:"POST",
                url:'/autorizaciones/'+id_tabla,
                data: { asad },
                dataType: 'json',
                success: function(data)
                {
                    if($('#tabla-articulos').length > 0) {
                       $('#tabla-articulos').DataTable().ajax.reload();
                    }
                }
            })
        });*/


        function Iniciarselectarticulos(count)
        {
            if($("#articulos-"+count).length) {
                $("#articulos-"+count).select2({
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