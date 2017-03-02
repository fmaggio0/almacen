@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
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

    <form method="POST" action="/egresos/modificar-egreso" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Despachar autorización</h4></div>
                    <div class="panel-body">

            

                            <div class="form-group">
                                <label class="control-label col-sm-2">Tipo de retiro:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" style="width: 100%" required="required" id="edit-tipo_retiro" readonly="true" name="tipo_retiro" type="text" value="{{$master->tipo_retiro}}">
                                </div>
                                <label class="control-label col-sm-6">{{Auth::user()->name}}</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Destino:</label>
                                <div class="col-sm-4">
                                    <input readonly="true" class="form-control" id="edit-destinos" style="width: 100%" name="desc_subarea" type="text" value="{{ $master->descripcion_subarea }}">
                                    <input name="destino" type="hidden" value="{{ $master->id_subarea }}">
                                </div>
                                <label class="control-label col-sm-2">Asignado a:</label>
                                <div class="col-sm-4">
                                    <select id="subdestinos" class=" form-control" style="width: 100%" disabled="disabled" name="subdestino"><option value="" selected="selected">Sin asignacion</option></select>
                                </div>
                            </div>

                            <fieldset>
                                <legend>Detalles</legend>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Articulo:</label>
                                    <div class="col-sm-4">
                                        <select id="edit-articulos" class="form-control" style="width: 100%"></select>
                                    </div>
                                    <label class="control-label col-sm-2">Retirado por:</label>
                                    <div class="col-sm-4">
                                        <select id="edit-empleados" class="form-control" style="width: 100%"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Cantidad:</label>
                                    <div class="col-sm-4">
                                        <input id="edit-cantidad" class="form-control" placeholder="Stock actual" min="1" type="number">
                                    </div>
                                    <div class="col-sm-4">
                                        <button id="agregar" class="btn btn-success" type="button">Agregar</button>
                                    </div>
                                </div> 
                            </fieldset>

                            <div class="box">
                                <div class="box-body">
                                    <table id="tabla-modificar-egreso" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Articulo</th>
                                                <th>Cantidad</th>
                                                <th>Retirado por</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <thbody>
                                            @foreach ($detalles as $detalle)
                                                <tr>
                                                    <input type='hidden' name='id_detalle[]' value='{{ $detalle->id_detalles }}'>
                                                    <input type='hidden' name='estado[]' value='viejo'>
                                                    <td> {{ $detalle->descripcion}} <input type='hidden' name='articulos[]' value='{{ $detalle->id_articulo}}'></td>
                                                    <td> {{ $detalle->cantidad}} <input type='hidden' name='cantidad[]' value='{{ $detalle->cantidad}}'></td>
                                                    <td> {{ $detalle->Apellido }}, {{ $detalle->Nombres }} <input type='hidden' name='empleados[]' value='{{ $detalle->id_empleado}}'></td>
                                                    <td> <a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a> </td>
                                                </tr>
                                            @endforeach
                                        </thbody>
                                    </table>
                                </div>
                            </div>
                      
                    </div>
                    <div class="panel-footer">
                        <input name="id_master" type="hidden" value="{{$master->id_master}}">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input id="edit-id_salida" name="id_autorizacion" type="hidden">
                        <input class="btn btn btn-primary" tabindex="1" type="submit" value="Despachar">
                    </div>
                </div>
            </div>
        </div>
    </form>

@stop

@section('js')

<script>    

    $("#tabla-modificar-egreso").DataTable({
        language: {
            url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
        },
        "paging":   false,
    });

    $("#edit-empleados").select2({
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

    $("#edit-articulos").select2({
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

    //Imprimir stock disponible en el placeholder del input cantidad
    $("#edit-articulos").on("select2:select", function(e) { 
        data=$("#edit-articulos").select2('data')[0];
        $("#edit-cantidad").attr('placeholder', data.stock+" "+data.unidad+"es disponibles" );
        $("#edit-cantidad").attr('data-stock', data.stock);
    });

    //Agregar articulos a datatable
    var contador = 1;
    $("#agregar").on( 'click', function () {
        var articulos = $("#edit-articulos :selected").text();
        var articulosid = $("#edit-articulos :selected").val();
        var empleados = $("#edit-empleados :selected").text();
        var empleadosid = $("#edit-empleados :selected").val();
        var cantidad = $("#edit-cantidad").val();
        var stock = $("#edit-cantidad").data('stock');
        var cero = 0;

        //Validaciones antes de agregar articulos a la tabla
        if(cantidad <= stock && cantidad > 0 && empleados.length != 0 && empleadosid.length != 0 && articulos.length != 0 && articulosid.length != 0)
        {
            var stockrestante = stock - cantidad;
        
            $("#tabla-modificar-egreso").DataTable().row.add( [
                "<input type='hidden' name='id_detalle[]' value='null'><input type='hidden' name='estado[]' value='nuevo'>"+articulos+"<input type='hidden' name='articulos[]' value='"+articulosid+"'>",
                cantidad+"<input type='hidden' name='cantidad[]' value='"+cantidad+"'>",
                empleados+"<input type='hidden' name='empleados[]' value='"+empleadosid+"'>",

                "<a class='btn botrojo btn-xs' href='#'><i class='glyphicon glyphicon-trash delete'></i></a>"
            ] ).draw( false );
            contador++;
            $("#edit-articulos").select2("val", "");
            $("#edit-empleados").select2("val", "");
            $("#edit-cantidad").val("");
            $("#edit-articulos").select2("open");
            $("#cantidad_error").attr('class', 'form-group');
        }
        else if(cantidad > stock)
        {
            $("#cantidad_error").attr('class', 'form-group has-error');
            $("#edit-cantidad").focus();
            $("#edit-cantidad").val("");
        }
        else if(cantidad <= cero)
        {
            $("#cantidad_error").attr('class', 'form-group has-error');
            $("#edit-cantidad").focus();
            $("#edit-cantidad").val("");
        }
        else{
            alert("No se ha podido agregar el articulo, intente nuevamente.")
        }      
    });

    $("#tabla-modificar-egreso tbody").on( "click", ".delete", function () {
        $("#tabla-modificar-egreso").DataTable()
            .row( $(this).parents("tr") )
            .remove()
            .draw();
    });
</script>

@stop