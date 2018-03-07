@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE PROVEEDORES
    </div>
@stop

@section('main-content')
<div class="panel panel-default">
    <!-- Mensajes de exito-->
    @if (session('status'))
        <div class="alert alert-success" id="ocultar">
            {{ session('status') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="/proveedores/addproveedor" accept-charset="UTF-8" class="form-horizontal">

    	<div class="panel-body">
    		<div class="form-group">
    				<label for="nombre" class="control-label col-sm-2">Nombre:</label>
                    <div class="col-sm-10">
    				<input class="form-control" required="required" name="nombre" type="text" placeholder="Nombre">
                    </div>
    		</div>
            <div class="form-group">
                    <label for="direccion" class="control-label col-sm-2">Dirección:</label>
                    <div class="col-sm-10">
                        <input class="form-control autocomplete-calles" required="required" name="direccion" type="text" value="" placeholder="Dirección">
                    </div>
            </div>
            <div class="form-group">
                    <label for="cuit" class="control-label col-sm-2">CUIT:</label>
                    <div class="col-sm-10">
                    <input class="form-control" name="cuit" type="text" placeholder="CUIT">
                    </div>
            </div>
    		<div class="form-group">
    				<label for="email" class="control-label col-sm-2">E-Mail:</label>
                    <div class="col-sm-10">
    				<input class="form-control" name="email" type="text" placeholder="E-Mail">
                    </div>
    		</div>
            <div class="form-group">
                    <label for="telefono" class="control-label col-sm-2">Telefono:</label>
                    <div class="col-sm-10">
                        <input value="" min="0" class="form-control" style="width: 20%" name="telefono" type="number" placeholder="Telefono">
                    </div>
            </div>
            <div class="form-group">
                    <label for="observaciones" class="control-label col-sm-2">Observaciones:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="observaciones" placeholder="Observaciones"></textarea>
                    </div>
            </div>
    		<div class="form-group">
    				{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-2')) !!}
    				<div class="col-sm-10">
                        <select name="rubros[]" class="add-rubros" multiple="multiple" style="width: 100%"></select>
    				</div>
    		</div>
    	</div>

    	<div class="panel-footer">
            <input type="hidden" name="coordinatesx" id="coorx" value=""></input>
            <input type="hidden" name="coordinatesy" id="coory" value=""></input>
    		<input type="submit" class="btn btn-primary" value="Guardar"></input>
            <input type="reset" name="reset" id="reset" class="btn btn-primary" value="Limpiar"></input>
    	</div>
    </form>
</div>

@stop

@section('js')

<script>
    $.getJSON("/ajax/rubros2", function (json) {
        $(".add-rubros").select2({
            data: json,
            language: "es",
            placeholder: "Seleccionar rubros"
        });
    });
    $(".autocomplete-calles").autocomplete({
       source: function( request, response ) {
            $.getJSON("http://ws.rosario.gov.ar/ubicaciones/public/geojson/ubicaciones/all/all/"+request.term,function(data){
                

                array = new Array();
                $.each( data.features, function( key, value ) {
                    if(value.properties.subtipo == 'DIRECCIÓN'){
                        array.push({label: value.properties.name, value: value.properties.name, codcalle: value.properties.codigoCalle, x: value.geometry.coordinates[0], y: value.geometry.coordinates[1] });
                    }
                });
                response(array);
            });
        },
        minLength: 2,
        open: function(){
            $(this).autocomplete('widget').css('z-index', 9000);
            return false;
        },
        select: function (event, ui) {
            $(this).attr('data-codcalle', ui.item.codcalle);
            $("#coorx").val(ui.item.x);
            $("#coory").val(ui.item.y);
            $(".autocomplete-calles").attr('readOnly', true)
        }
    });

    $("#reset").click(function(){
        $(".autocomplete-calles").attr('readOnly', false);
        $(".add-rubros").select2().empty();
    });


</script>

@stop