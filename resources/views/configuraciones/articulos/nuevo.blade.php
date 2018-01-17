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

    <form method="POST" action="/articulos/addarticulo" accept-charset="UTF-8" class="form-horizontal">

		<div class="panel-body">
			<div class="form-group">
					   <label for="articulo" class="control-label col-sm-2">Articulo:</label>
                    <div class="col-sm-10">
					   <input name="descripcion" value="" placeholder="Nombre del articulo" required="required" class="form-control" type="text">
                    </div>
			</div>
			<div class="form-group">
					   <label for="unidad" class="control-label col-sm-2">Unidad de medida:</label>
                    <div class="col-sm-10">
                        <select name="unidad" class="form-control" style="width: 100%" required="required">
                            <option value="Unidad">Unidad</option>
                            <option value="Metro">Metro</option>
                            <option value="Litro">Litro</option>
                        </select>
					</div>
			</div>
			<div class="form-group">
					   <label for="id_rubro" class="control-label col-sm-2">Rubro:</label>
                    <div class="col-sm-10">
                        <select name="id_rubro" class="completarrubros form-control" style="width: 100%">
                            <option value="">Seleccionar un rubro</option>
                        </select>
					</div>
			</div>
			<div class="form-group">
					   <label for="id_subrubro" class=" control-label col-sm-2">SubRubro:</label>
                    <div class="col-sm-10">
                        <select name="id_subrubro" class="subrubros form-control" style="width: 100%">
                            <option value="">Seleccione un subrubro</option>
                        </select>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
			</div>
		</div>

		<div class="panel-footer">
            <input type="submit" class="btn btn-primary" value="Guardar"></input>
		</div>
    </form>
</div>

@stop

@section('js')
    <script>
        //Desabilitar opciones si es ajuste de stock

    	//SELECT2---------------------------------------------
                //select2 Unidades de medida
            $(".unidades").select2({
                language: "es",
            });
            //select2 rubros
            $.getJSON("/ajax/rubros", function (json) { //para modal edit y add
                $(".completarrubros").select2({
                    data: json,
                    language: "es",
                });
            });
        //FIN SELECT2-------------------------------------------
        
        //FIN SELECT2 SUBFAMILIA
             $(".subrubros").prop("disabled", true);
             $('.completarrubros').on("select2:select", function(e) { 
                id = $(".completarrubros").val();
                $(".subrubros").select2();
                $(".subrubros").select2().empty();
                $.getJSON("/ajax/subrubros/" + id, function (json) {
                  $(".subrubros").select2({
                        data: json,
                        language: "es",

                    });
                });
                $(".subrubros").prop("disabled", false);
            });
        //FIN SELECT2 FAMILIA-SUBFAMILIA-----------------------

    </script>
@stop