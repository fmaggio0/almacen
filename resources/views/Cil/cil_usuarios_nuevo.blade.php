@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE USUARIOS, ROLES Y PERMISOS
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

    <form method="POST" action="/cil/usuarios/nuevo/post" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Nuevo usuario</h4></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre de usuario:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="name" type="text" required>
                            </div>
                            <label class="control-label col-sm-2">E-Mail:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="email" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">ID empleado:</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input class="form-control" style="width: 20%" readonly name="id_empleado" id="id_empleado" type="text" required>
                                    <select id="empleados" class="form-control" style="width: 80%"></select>
                                </div>    
                            </div>
                            <label class="control-label col-sm-2">Roles asignados:</label>
                            <div class="col-sm-4">
                                <select name="roles[]" id="roles" multiple="multiple" style="width: 100%" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Password:</label>
                            <div class="col-sm-4 has-feedback">
                                <input type="password" class="form-control" name="password"/>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <label class="control-label col-sm-2">Repita password:</label>
                            <div class="col-sm-4 has-feedback">
                                <input type="password" class="form-control" name="password_confirmation"/>
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input class="btn btn btn-primary" tabindex="1" type="submit" value="Crear usuario">
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

    select2empleados = $("#empleados").select2({
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
                    };
                });
                return { results: data };
            },
            cache: true,
        }
    });

    $.getJSON("/ajax/roles", function (json) {
        select2roles = $("#roles").select2({
            data: json,
            language: "es",
            placeholder: "Seleccionar roles",
            tags: true
        });
    });

    $("#empleados").on("select2:select", function(e) { 
        data=$("#empleados").select2('data')[0];
        $("#id_empleado").val(data.id);
    });

});

</script>
@stop