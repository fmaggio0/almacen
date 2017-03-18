@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ROLES Y PERMISOS
    </div>
@stop

@section('main-content')

    <!-- Mensajes de error-->

    @if($errors->has())
        <div class="alert alert-warning" role="alert" id="ocultar">
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        </div>
    @endif 


    <!-- Mensajes de exito-->

    @if (session('status'))
        <div class="alert alert-success" id="ocultar">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="/cil/permisos/update/post" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Modificar permiso "{{ $permiso->display_name }}" </h4></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre del rol:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="name" type="text" value="{{ $permiso->name}}" required>
                            </div>
                            <label class="control-label col-sm-2">Nombre a mostrar:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="display_name" type="text" value="{{ $permiso->display_name}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Descripción:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="description" type="text" value="{{ $permiso->description}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input name="permiso_id" type="hidden" value="{{ $permiso->id }}">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input class="btn btn btn-primary" id="boton" type="submit" value="Modificar permiso">
                    </div>
                </div>
            </div>
        </div>
    </form>

@stop

@section('js')

<script>
$(document).ready( function () {
    //Ocultar mensajes de error o success
    $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
        $("ocultar").alert('close');
    });
});
</script>
@stop