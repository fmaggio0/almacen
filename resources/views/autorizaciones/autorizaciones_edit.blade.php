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

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <form method="POST" action="/areas/autorizaciones/store" accept-charset="UTF-8" class="form-horizontal">

                <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;">
                    <h4 class="panel-title">Autorizacion para retiro en el almacen</h4> 
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Area:</label>   
                        <div class="col-sm-3">
                            <p class="form-control-static"> {{ $master->descripcion_area }}</p>
                        </div>
                        <label for="usuario" class="control-label col-sm-3">Subarea:</label>               
                        <div class="col-sm-3">
                            <p class="form-control-static"> {{ $master->descripcion_subarea }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Fecha de solicitud:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static">{{ $master->updated_at }}</p>
                        </div>
                        <label class="control-label col-sm-3">Usuario:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static">{{ $master->name }}</p>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <table id="tabla-modificar-aut" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Articulo solicitado</th>
                                        <th>Tipo</th>
                                        <th>Empleado</th>
                                        <th>Cantidad solicitada</th>
                                        <th>Stock actual</th>
                                        <th>Ultima entrega</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <thbody>
                                    <thbody>
                                        @foreach ($details as $detail)
                                            <tr>
                                                <input type='hidden' name='id_detalle[]' value='{{ $detail->id_detalles }}'>
                                                <input type='hidden' name='estado[]' class="estado" value='viejo'>
                                                <input type='hidden' name='empleados[]' value='{{ $detail->id_empleado}}'>
                                                <input type='hidden' name='cantidad[]' value='{{ $detail->cantidad }}'>
                                                <input type='hidden' name='articulos[]' value='{{ $detail->id_articulo}}'>

                                                <td class="articulo" data-id="{{$detail->id_articulo}}"> {{ $detail->descripcion}} </td>
                                                <td class="tipo"> {{ $detail->tipo }} </td>
                                                <td class="empleado" data-id="{{ $detail->id_empleado }}"> {{ $detail->apellidos }}, {{ $detail->nombres }} </td>
                                                <td class="cantidad"> {{ $detail->cantidad }} </td>
                                                <td class="stock_actual"> {{ $detail->stock_actual }} </td>
                                                <td class="ultimo_entregado"> {{ $detail->ultimo_entregado }} </td>

                                                <td> <div class="form-group">
                                                        <button class='btn btn-xs btn-success ok'><i class='glyphicon glyphicon-check'></i></button>
                                                        <button class='btn btn-xs btn-info edit'><i class='glyphicon glyphicon-edit'></i></button>
                                                        <button class='btn btn-xs btn-danger delete'><i class='glyphicon glyphicon-trash'></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </thbody>
                                </thbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <input id="id_usuario" name="usuario" type="hidden" value="{{ Auth::user()->id }}"> 
                    {{ csrf_field() }}
                    <input class="btn btn btn-primary" type="submit" value="Autorizar">
                </div>
            </form>
        </div>
    </div>
</div>

@stop
@section('js')

<script>
    var count_fila = 0;

    $('#tabla-modificar-aut').on('click', '.ok', function(e) {
        e.preventDefault();
        var row = $(this).closest("tr");
        if(Number(row.find('.cantidad').html()) <= Number(row.find('.stock_actual').html()) || Number(row.find('.cantidad_input').val()) <= Number(row.find('.stock_actual').html()) ){ 
            row.attr("style", "background-color:#9eff92;");
            row.find('.estado').val("ok");
        }
        else{
            alert("El stock debe ser igual o mayor a lo solicitado, modifique el pedido.");
        }
    });

    $('#tabla-modificar-aut').on('click', '.edit', function(e) {
        e.preventDefault();
        var fila = $(this).closest("tr");
        fila.attr("style", "background-color:#f9f9f9;text-decoration: line-through;");
        fila.find('.estado').val("edit");

        fila.find(".btn").attr("disabled", "disabled");

        articulo = fila.find('td.articulo').html();
        id_articulo = fila.find('td.articulo').data("id");
        empleado = fila.find('td.empleado').html();
        tipo = fila.find('td.tipo').html();
        id_empleado = fila.find('td.empleado').data("id");
        cantidad = fila.find('td.cantidad').html();
        stock_actual = fila.find('td.stock_actual').html();
        ultimo_entregado = fila.find('td.ultimo_entregado').html();

        /*  $(this).closest("tr").find('label.btn-danger').attr("disabled", true);
            $(this).closest("tr").find('label.btn-success').attr("disabled", true);
            $(this).closest("tr").find('label.btn-info').attr("disabled", true);
            $(this).closest("tr").find('label.btn-info').attr("class", "btn btn-info");
        */
        

        $('<tr class="add_row" data-id-fila="'+count_fila+'" data-id-articulo="'+id_articulo+'" data-id-empleado="'+id_empleado+'"><td class="articulo"><select id="articulos-'+count_fila+'" style="width: 100%"></select></td><td>'+tipo+'</td><td>'+empleado+'</td><td><input class="cantidad_input form-control" placeholder="Ingrese cantidad" min="1" type="number"></td><td id="stock_actual-'+count_fila+'" class="stock_actual">'+stock_actual+'</td><td id="ultimo_entregado-'+count_fila+'">'+ultimo_entregado+'</td><td><button class="btn btn-xs btn-success ok"><i class="glyphicon glyphicon-check"></i></button><button class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i></button></td></tr>').insertAfter(fila);
        Iniciarselectarticulos(count_fila);

        $("#articulos-"+count_fila).select2("trigger", "select", {
            data: { id: id_articulo, text: articulo }
        });

        $("#articulos-"+count_fila).on("select2:unselect", function() {
            id = $(this).closest('tr').data('id-fila');
            $("#ultimo_entregado-"+id).html("");
            $("#cantidad-"+id).attr('placeholder', "Stock actual" );
        });

        $("#articulos-"+count_fila).on("select2:selecting", function(e) {
            
            id = $(this).closest('tr').data('id-fila');
            id_articulo = $(this).closest('tr').data('id-articulo');
            id_empleado = $(this).closest('tr').data('id-empleado');
            $("#ultimo_entregado-"+id).html("");

            $("#stock_actual-"+id).html(e.params.args.data.stock);

            $.getJSON("/ajax/ultimoretiroporempleado/"+id_articulo+"/"+id_empleado, function (json) { //para modal edit y add
                $("#ultimo_entregado-"+id+"").html(json.created_at);
            });
        });        
    });

    function Iniciarselectarticulos(count_fila)
    {
        if($("#articulos-"+count_fila).length) {
            $("#articulos-"+count_fila).select2({
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

    $('#tabla-modificar-aut').on('click', '.delete', function(e) {
        e.preventDefault();
        var row = $(this).closest("tr");

        if(row.hasClass('add_row')){
            row.prev().attr("style", "text-decoration: initial;");
            row.prev().find('.estado').val("");
            row.prev().find('.btn').removeAttr("disabled");
            row.remove();
        } else{
            row.attr("style", "background-color:#ff9393;");
            row.find('.estado').val("no");
        }
    }); 

</script>

@stop