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

    <form method="POST" action="/proveedores/addproveedor" accept-charset="UTF-8" class="form-horizontal">

    	<div class="panel-body">
    		<div class="form-group">
    				{!! Form::label(null, 'Nombre:', array('class' => 'control-label col-sm-2')) !!}
    				<div class="col-sm-10">
    				{!! Form::text('nombre',  null, array('class' => 'form-control add-nombre',  'required' => 'required')) !!}
    				</div>
    		</div>
            <div class="form-group">
                    {!! Form::label(null, 'Dirección:', array('class' => 'control-label col-sm-2')) !!}
                    <div class="col-sm-10">
                    {!! Form::text('direccion', null, array('class' => 'form-control autocomplete-calles', 'required' => 'required')) !!}
                    </div>
            </div>
            <div class="form-group">
                    {!! Form::label(null, 'CUIT:', array('class' => 'control-label col-sm-2')) !!}
                    <div class="col-sm-10">
                    {!! Form::text('cuit', null, array('class' => 'form-control add-cuit')) !!}
                    </div>
            </div>
    		<div class="form-group">
    				{!! Form::label(null, 'E-Mail:', array('class' => 'control-label col-sm-2')) !!}
    				<div class="col-sm-10">
    				{!! Form::text('email', null, array('class' => 'form-control add-email')) !!}
    				</div>
    		</div>
            <div class="form-group">
                    {!! Form::label(null, 'Telefono:', array('class' => 'control-label col-sm-2')) !!}
                    <div class="col-sm-10">
                        <input value="" min="0" class="form-control" style="width: 20%" name="telefono" type="number">
                    </div>
            </div>
            <div class="form-group">
                    {!! Form::label(null, 'Observaciones:', array('class' => 'control-label col-sm-2')) !!}
                    <div class="col-sm-10">
                    {!! Form::textarea('observaciones', null, array('class' => 'form-control add-observaciones', 'rows' => '2', 'style' => 'width: 100%')) !!}
                    </div>
            </div>
    		<div class="form-group">
    				{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-2')) !!}
    				<div class="col-sm-10">
                        <select name="rubros" class="add-rubros" multiple="multiple" style="width: 100%" required></select>
    				</div>
    		</div>
    	</div>

    	<div class="panel-footer">
            <input type="hidden" name="coordinatesx" id="coorx" value=""></input>
            <input type="hidden" name="coordinatesy" id="coory" value=""></input>
    		<input type="submit" class="btn btn-primary" value="Guardar"></input>
            <input type="reset" name="reset" id="reset" class="btn btn-primary" value="Limpiar"></input>
    	</div>
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
            $(".autocomplete-calles").attr('disabled', true)
        }
    });

    $("#reset").click(function(){
        $(".autocomplete-calles").attr('disabled', false);
        $(".add-rubros").select2().empty();
    });


</script>

@stop