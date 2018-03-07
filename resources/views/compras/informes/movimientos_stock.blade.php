@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        INFORMES DE EMPLEADOS
    </div>
@stop

@section('main-content')

<div class="row">
    
	@foreach ($datos as $key => $items)
	<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="panel-title">{{ $key }}</h4></div>
            <div class="panel-body">
            	<table class="table table-striped table-bordered" cellspacing="0" width="100%">
            		<thead>
                    	<tr>
	                        <th>Articulo</th>
	                        <th>Stock actual</th>
	                        <th>Stock minimo</th>
	                        <th>Ingresos ultimos 30 días</th>
	                        <th>Salidas ultimos 30 días</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	@foreach ($items as $item)
	                	<tr>
		                	<td>{{ $item->descripcion }}</td>
		                	<td>{{ $item->stock_actual }}</td>
		                	<td>{{ $item->stock_minimo }}</td>
		                	<td> @if(!empty($item->cantidad_ingresos) > 0) <span class="label label-success"><b>+</b> {{ $item->cantidad_ingresos }}<span>@endif</td>
		                	<td> @if(!empty($item->cantidad_salidas) > 0) <span class="label label-danger"><b>-</b> {{ $item->cantidad_salidas }}<span>@endif</td>
		                </tr>
	                	@endforeach
	                </tbody>
	            </table>
            </div>
        </div> 
    </div>
	@endforeach
 	
</div>
@stop

@section('js')

<script>

</script>

@stop