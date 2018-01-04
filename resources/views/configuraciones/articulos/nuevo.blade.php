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
					{!! Form::label('articulo', 'Articulo:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-10">
					{!! Form::text('descripcion',  null, array('class' => 'form-control desc', 'placeholder' => 'Nombre del articulo', 'required' => 'required', 'tabindex' => '1')) !!}
					</div>
			</div>
			<div class="form-group">
					{!! Form::label(null, 'Unidad de medida:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-10">
					{!! Form::select('unidad', array('Unidad' => 'Unidad', 'Metro' => 'Metro', 'Litro' => 'Litro'), null ,array('class'=>'unidades form-control', 'style' => 'width: 100%', 'required' => 'required', 'tabindex' => '2')) 
                    !!}
					</div>
			</div>
			<div class="form-group">
					{!! Form::label(null, 'Rubro:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-10">
					{!! Form::select('id_rubro', array('' => 'Seleccione un rubro'), null ,array('class'=>'completarrubros form-control', 'style' => 'width: 100%', 'required' => 'required', 'tabindex' => '3')) 
                    !!}
					</div>
			</div>
			<div class="form-group">
					{!! Form::label(null, 'SubRubro:', array('class' => 'control-label col-sm-2')) !!}
					<div class="col-sm-10">
					{!! Form::select('id_subrubro', array('' => 'Seleccione un subrubro'), null ,array('class'=>'subrubros form-control', 'style' => 'width: 100%', 'tabindex' => '3'))
					!!}
					{!! Form::token(); !!}

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