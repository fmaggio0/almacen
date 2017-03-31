@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INFORMES DE EMPLEADOS
    </div>
@stop

{{  Request::segment(2) }}

@section('main-content')
	<div class="spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Home</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-sm-2">Retirado por:</label>
							<div class="col-sm-4">
		                        <select id="empleados" class="form-control" style="width: 100%" name="articulos" aria-hidden="true"></select>
							</div>
							<div class="col-sm-4">
		                        <p class="help-block" id="sector"></p>
		                        <p class="help-block" id="cargo"></p>
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
                        cargo: item.cargo,
                        sector: item.sector
                    };
                });
                return { results: data };
            },
            cache: true
        }
    });

    $("#empleados").on("select2:select", function(e) { 
        data=$("#empleados").select2('data')[0];
        $("#cargo").empty();
        $("#sector").empty();
        $("#cargo").append("Cargo: "+ data.cargo);
        $("#sector").append("Sector: "+ data.sector);
        $("#buscar").attr('href', "/empleados/"+data.id);
    });
</script>

@stop