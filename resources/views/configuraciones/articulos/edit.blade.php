@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
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

    <form method="POST" action="/articulos/editar/post" accept-charset="UTF-8" class="form-horizontal">

		<div class="panel-body">
			<div class="form-group">
				<label for="articulo" class="control-label col-sm-4">Articulo:</label>
				<div class="col-sm-8">
					<input class="form-control" required="required" name="descripcion" type="text" value="{{$articulo->descripcion}}">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-sm-4">Unidad de medida:</label>
				<div class="col-sm-8">
					<select id="edit-unidad" class="form-control" style="width: 100%" required="required" name="unidad">
						<option value="Unidad" {{ ( $articulo->descripcion == 'Unidad' ) ? 'selected' : '' }}>Unidad</option>
						<option value="Metro" {{ ( $articulo->descripcion == 'Metro' ) ? 'selected' : '' }}>Metro</option>
						<option value="Litro" {{ ( $articulo->descripcion == 'Litro' ) ? 'selected' : '' }}>Litro</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="id_rubro" class="control-label col-sm-4">Rubro:</label>
				<div class="col-sm-8">
					<select id="edit-rubros" class="form-control" style="width: 100%" required="required" name="id_rubro"></select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-sm-4">SubRubro:</label>
				<div class="col-sm-8">
					<select id="edit-subrubros" class="form-control" style="width: 100%" required="required" name="id_subrubro"></select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="control-label col-sm-4">Stock minimo:</label>
				<div class="col-sm-8">
					<input value="{{$articulo->stock_minimo}}" min="0" class="form-control" style="width: 10%" name="stock_minimo" type="number">
				</div>
			</div>
		</div>

		<div class="panel-footer">
			<!-- TEMP -->
			<input id="id_rubro" type="hidden" value="{{$articulo->id_rubro}}">
			<input id="id_subrubro" type="hidden" value="{{$articulo->id_subrubro}}">
			<!-- end -->

			{{ csrf_field() }}
			<input name="id_articulo" type="hidden" value="{{$articulo->id_articulo}}">
			<button class="btn btn-primary">Guardar cambios</button>
		</div>

	</form>		
</div>

@stop

@section('js')
<script>
	$.getJSON("/ajax/rubros", function (json) { //para modal edit y add
        $("#edit-rubros").select2({
            data: json,
            language: "es",
        }).val($("#id_rubro").val()).trigger("change");
    });
    $.getJSON("/ajax/subrubros/"+$("#id_rubro").val() , function (json) { //solo modal edit
      $("#edit-subrubros").select2({
            data: json,
            language: "es",
        }).val($("#id_subrubro").val()).trigger("change");
    });

	$('#edit-rubros').on("select2:select", function(e) {
        $("#edit-subrubros").select2().empty(); // vaciar select subrubros
        $.getJSON("/ajax/subrubros/" + $("#edit-rubros").val(), function (json) { 
          $("#edit-subrubros").select2({
                data: json,
                language: "es",

            });
        });
    });
</script>
@stop