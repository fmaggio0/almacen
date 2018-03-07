@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INDUMENTARIA
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

    <form method="POST" action="/areas/indumentaria/modificar" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Modificar indumentaria</h4></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Nombres:</label>
                            <div class="col-sm-8">
                                <input class="form-control" style="width: 100%" readonly="true" type="text" value="{{$empleado->nombres}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Apellidos:</label>
                            <div class="col-sm-8">
                                <input class="form-control" style="width: 100%" readonly="true" type="text" value="{{$empleado->apellidos}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Función:</label>
                            <div class="col-sm-8">
                                <input class="form-control" style="width: 100%" readonly="true" type="text" value="{{$empleado->funcion}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Area:</label>
                            <div class="col-sm-8">
                                <input class="form-control" style="width: 100%" readonly="true" type="text" value="{{$area->descripcion_area}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Talle remera:</label>
                            <div class="col-sm-8">
                                <select class="form-control" style="width: 100%" required="required" name="talle_remera">
                                    <option value="XXXL" {{ ( $empleado->talle_remera == 'XXXL' ) ? 'selected' : '' }}>XXXL</option>
                                    <option value="XXL" {{ ( $empleado->talle_remera == 'XXL' ) ? 'selected' : '' }}>XXL</option>
                                    <option value="XL" {{ ( $empleado->talle_remera == 'XL' ) ? 'selected' : '' }}>XL</option>
                                    <option value="L" {{ ( $empleado->talle_remera == 'L' ) ? 'selected' : '' }}>L</option>
                                    <option value="M" {{ ( $empleado->talle_remera == 'M' ) ? 'selected' : '' }}>M</option>
                                    <option value="S" {{ ( $empleado->talle_remera == 'S' ) ? 'selected' : '' }}>S</option>
                                    <option value="XS" {{ ( $empleado->talle_remera == 'XS' ) ? 'selected' : '' }}>XS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Talle camisa:</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="talle_camisa" style="width: 100%" required="required" type="number" min="0" max="60" value="{{$empleado->talle_camisa}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Talle calzado:</label>
                            <div class="col-sm-8">
                                <input class="form-control" style="width: 100%" name="talle_calzado" required="required" type="number" min="0" max="60" value="{{$empleado->talle_calzado}}">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input name="id_empleado" type="hidden" value="{{$empleado->id_empleado}}">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input class="btn btn btn-primary" type="submit" value="Modificar">
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
                            text: item.text+", "+item.nombres,
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
            alert("La cantidad no puede superar el stock disponible.")
        }
        else if(cantidad <= cero)
        {
            alert("La cantidad debe ser mayor que 0.");
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