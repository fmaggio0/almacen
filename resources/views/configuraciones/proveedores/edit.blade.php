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
    
		<form method="POST" action="/proveedores/editar/post" accept-charset="UTF-8" class="form-horizontal">		
				<div class="panel-body">
					<div class="form-group">
                                <label for="nombre" class="control-label col-sm-4">Nombre:</label>
							<div class="col-sm-8">
                                <input class="form-control" required="required" name="nombre" type="text" value="{{$proveedor->nombre}}">
                            </div>
					</div>
                    <div class="form-group">
                                <label for="direccion" class="control-label col-sm-4">Dirección:</label>
                            <div class="col-sm-8">
                                <input class="form-control autocomplete-calles" required="required" name="direccion" type="text" value="{{$proveedor->direccion}}">
                            </div>
                    </div>
                    <div class="form-group">
                                <label for="cuit" class="control-label col-sm-4">CUIT:</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="cuit" type="text" value="{{$proveedor->cuit}}">
                            </div>
                    </div>
					<div class="form-group">
                                <label for="email" class="control-label col-sm-4">E-Mail:</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="email" type="text" value="{{$proveedor->email}}">
                            </div>
					</div>
                    <div class="form-group">
                                <label for="telefono" class="control-label col-sm-4">Telefono:</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="telefono" type="text" value="{{$proveedor->telefono}}">
                            </div>
                    </div>
                    <div class="form-group">
                                <label for="observaciones" class="control-label col-sm-4">Observaciones:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="observaciones">{{$proveedor->observaciones}}</textarea>
                            </div>
                    </div>
					<div class="form-group">
                                <label for="rubros" class="control-label col-sm-4">Rubro:</label>
                            <div class="col-sm-8">
                                <select name="rubros[]" class="edit-rubros" multiple="multiple" style="width: 100%">
                                    
                                    @if (isset($proveedor->rubros))
                                        @foreach(explode(',', $proveedor->rubros) as $campo_desc)
                                            @if ($campo_desc != "")
                                                <option value="{{$campo_desc}}" selected>{{$campo_desc}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
							</div>
					</div>
				</div>
				<div class="panel-footer">
                    <input type="hidden" name="coordinatesx" id="coorx" value=""></input>
                    <input type="hidden" name="coordinatesy" id="coory" value=""></input>
                    <input type="hidden" name="id_proveedor" value="{{ $proveedor->id_proveedor}}">
                    <input type="submit" name="guardar" class="btn btn-primary" id="editiguardar" value="Guardar">
				</div>
		</form>
        </div>
	</div>
</div>
@stop

@section('js')
<script>
    //select2 rubros
    $.getJSON("/ajax/rubros2", function (json) {
        $(".edit-rubros").select2({
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
</script>
@stop
