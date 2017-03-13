@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE USUARIOS, ROLES Y PERMISOS
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="/cil/usuarios/nuevo">
        <i class="fa fa-plus"></i> Nuevo usuario</a>
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

    <div class="panel panel-default">
        <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Usuarios</h4></div>
        <div class="panel-body">
            <!-- Datatables Salidas Master -->
            <div class="box">
                <div class="box-body">
                    <table id="tabla-usuarios" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de usuario</th>
                                <th>E-Mail</th>
                                <th>Empleado</th>
                                <th>Roles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Roles</h4></div>
                <div class="panel-body">
                    <!-- Datatables Salidas Master -->
                    <div class="box">
                        <div class="box-body">
                            <table id="tabla-roles" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Nombre para mostrar</th>
                                        <th>Descripción</th>
                                        <th>Permisos asignados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td> {{ $role->id}} </td>
                                            <td> {{ $role->name}} </td>
                                            <td> {{ $role->display_name}}</td>
                                            <td> {{ $role->description}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #4682B4; color: #FFFFFF;"><h4 class="panel-title">Permisos</h4></div>
                <div class="panel-body">
                    <!-- Datatables Salidas Master -->
                    <div class="box">
                        <div class="box-body">
                            <table id="tabla-permisos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Nombre para mostrar</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permisos as $permiso)
                                        <tr>
                                            <td> {{ $permiso->id}} </td>
                                            <td> {{ $permiso->name}} </td>
                                            <td> {{ $permiso->display_name}}</td>
                                            <td> {{ $permiso->description}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

<script>

$(document).ready( function () {

    //Ocultar mensajes de error o success
    $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
        $("ocultar").alert('close');
    });

    //Script Datatable Salidas Master y detalles
    var table = 
    $("#tabla-usuarios").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/datatables/usuarios",
        "error": function () {
            alert("Custom error");
        },
        "columns":[
            {data: 'id', name: 'users.id'},
            {data: 'name', name: 'users.name'},
            {data: 'email', name: 'users.email'},
            {data: 'full_name', name: 'empleados.Apellido'},
            {data: 'roles', name: 'roles' , orderable: false, searchable: false},
            {data: 'action', name: 'action' , orderable: false, searchable: false},
        ],
        "order": [ 0, "desc" ],
        "language":{
            url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
        }
    });
});

</script>
@stop