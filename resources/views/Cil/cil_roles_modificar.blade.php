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

    <form method="POST" action="/cil/roles/update/post" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Modificar rol "{{ $role->display_name }}" </h4></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre del rol:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="name" type="text" value="{{ $role->name}}" required>
                            </div>
                            <label class="control-label col-sm-2">Nombre a mostrar:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="display_name" type="text" value="{{ $role->display_name}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Descripción:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="description" type="text" value="{{ $role->description}}" required>
                            </div>
                            <label class="control-label col-sm-2">Permisos:</label>
                            <div class="col-sm-4">
                                <select name="permisos[]" id="permisos" multiple="multiple" style="width: 100%" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input name="role_id" type="hidden" value="{{ $role->id }}">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input class="btn btn btn-primary" id="boton" type="submit" value="Modificar rol">
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

    $.getJSON("/ajax/permisos", function (json) {
        select2roles = $("#permisos").select2({
            data: json,
            language: "es",
            placeholder: "Seleccionar permisos",
            tags: true
        });

        permisos = {!! json_encode($role->permisos->toArray()) !!};
        array = new Array();
        jQuery.each( permisos, function( i, val ) {
            array.push(val.id);
        });
        select2roles.val(array).trigger("change");
    });
});

</script>
@stop