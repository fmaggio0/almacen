@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INFORMES DE EMPLEADOS
    </div>
@stop

@section('main-content')
	<div class="spark-screen">
		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							<div class="col-sm-6">
		                        <select id="empleados" class="form-control" style="width: 100%" name="articulos" aria-hidden="true"></select>
							</div>
							<div class="col-sm-4">
		                        <p class="help-block" id="area"></p>
                                <p class="help-block" id="subarea"></p>
		                        <p class="help-block" id="funcion"></p>
	                        </div>
                        </div>
					</div>
					<div class="panel-footer">
						<a href="/empleados" id="buscar">
						    <button class="btn btn btn-primary">Buscar</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('js')

<script>
    $("#empleados").select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        language: "es",
        placeholder: "Buscar un empleado",
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
                        funcion: item.funcion,
                        area: item.descripcion_area,
                        subarea: item.descripcion_subarea
                    };
                });
                return { results: data };
            },
            cache: true
        }
    });

    $("#empleados").on("select2:select", function(e) { 
        data=$("#empleados").select2('data')[0];

        $("#area").empty().append("AREA: "+ data.area);
        $("#subarea").empty().append("SUBAREA: "+ data.subarea);
        $("#funcion").empty().append("FUNCIÓN: "+ data.funcion);

        $("#buscar").attr('href', "/informes/empleados/"+data.id);
    });
</script>

@stop