@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')

    <div class="panel panel-primary">
        <div class="panel-heading">
			<h4 class="modal-title"> Nuevo empleado</h4> 
		</div>

        <div class="panel-body">

        {!! Form::open(['route' => 'addingreso', 'method' => 'POST', 'class' => 'form-horizontal' ]) !!}
        	
			<div class="form-group">

				{!! Form::label(null, 'Nombre/s:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::text('nombres', null ,array('class'=>' form-control', 'style' => 'width: 100%')) !!}
				</div>
				{!! Form::label(null, 'Apellido/s:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::text('apellidos', null ,array('class'=>' form-control', 'style' => 'width: 100%')) !!}
				</div>		

			</div>
			<div class="form-group">

				{!! Form::label(null, 'Legajo:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::number('dni', null, array('class' => 'form-control', 'style' => 'width: 100%')) !!}
				</div>
				{!! Form::label(null, 'DNI:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">
					{!! Form::number('legajo', null ,array('class'=>' form-control', 'style' => 'width: 100%')) !!}
				</div>
					
				
			</div>
			<div class="form-group">
				{!! Form::label(null, 'Funcion base:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">

					{!! Form::select('funcion', 
							array('Administrativo' => 'Administrativo',
								'Chofer' => 'Chofer',
								'Director' => 'Director',
								'Director general' => 'Director general',
								'Operario' => 'Operario',
								'Coordinador general' => 'Cordinador general',
								'Guardian' => 'Guardian',
								'Docente' => 'Docente',
								'Encargado' => 'Encargado',
								'Inspector' => 'Inspector',
								'Jefe de división' => 'Jefe de división',
								'Jefe de división' => 'Jefe de división',
								'Jefe operativos especiales' => 'Jefe operativos especiales',
								'Ordenanza' => 'Ordenanza',
								'Subjefe division' => 'Subjefe division',
								'Subjefe departamento' => 'Subjefe departamento',
								'Tecnico' => 'Tecnico',
								'Trabajador social' => 'Trabajador social',
								), null ,array('class'=>' form-control', 'style' => 'width: 100%')) 
	                !!}

				</div>

				{!! Form::label(null, 'Lugar de trabajo:', array('class' => 'control-label col-sm-2')) !!}
				<div class="col-sm-4">	
					{!! Form::select('lugar_trabajo', 
							array('Espacios verdes' => 'Espacios verdes',
								'Taller' => 'Taller',
								'Arbolado' => 'Arbolado',
								'Vivero' => 'Vivero',
								'Camiones y cubas' => 'Camiones y cubas',
								'Compostaje' => 'Compostaje',
								'Control de vectores' => 'Control de vectores',
								'Direccion general' => 'Direccion general',
								'Escuela de jardineria' => 'Escuela de jardineria',
								'Inspeccion' => 'Inspeccion',
								'Guardia' => 'Guardian',
								'Ornamentaciones' => 'Ornamentaciones',
								'Tecnica' => 'Tecnica',
								), null ,array('class'=>' form-control', 'style' => 'width: 100%')) 
	                !!}
				</div>
			</div>

       		{!! Form::hidden('id_usuario', Auth::user()->id) !!}

        </div>
        <div class="panel-footer">
        	{!! Form::submit('Despachar', ['class'=>'btn btn btn-primary']) !!}
			{!! Form::close() !!}
        </div>
    </div>

@endsection