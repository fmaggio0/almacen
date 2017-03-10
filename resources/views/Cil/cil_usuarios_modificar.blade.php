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

    <form method="POST" action="/cil/usuarios/update" accept-charset="UTF-8" class="form-horizontal">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Modificar usuario</h4></div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre de usuario:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="name" type="text" value="{{$user->name}}">
                            </div>
                            <label class="control-label col-sm-2">E-Mail:</label>
                            <div class="col-sm-4">
                                <input class="form-control" style="width: 100%" name="email" type="text" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">ID empleado:</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input class="form-control" style="width: 20%" readonly name="id_empleado" id="id_empleado" type="text" value="{{$user->id_empleado}}">
                                    <select id="empleados" class="form-control" style="width: 80%" name="articulos" aria-hidden="true"><option value="{{$user->id_empleado}}">{{$empleado[0]->Apellido}}, {{$empleado[0]->Nombres}}</option></select>
                                </div>    
                            </div>
                            <label class="control-label col-sm-2">Roles asignados:</label>
                            <div class="col-sm-4">
                                <select name="roles[]" id="roles" multiple="multiple" style="width: 100%" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input name="id_user" type="hidden" value="{{$user->id}}">
                        <input name="usuario" type="hidden" value="{{Auth::user()->id}}">
                        <input class="btn btn btn-primary" tabindex="1" type="submit" value="Modificar">
                    </div>
                </div>
            </div>
        </div>
    </form>

@stop

@section('js')

<script>    

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
    roles = {!! json_encode($user->roles->toArray()) !!};
    array = new Array();
    jQuery.each( roles, function( i, val ) {
        array.push(val.id);
    });
    select2roles.val(array).trigger("change");
});

$("#empleados").on("select2:select", function(e) { 
    data=$("#empleados").select2('data')[0];
    $("#id_empleado").val(data.id);
});
</script>

@stop