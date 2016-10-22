@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE PROVEEDORES
    </div>
        <div class="boton_titulo">
        <a id="add-proveedor" class="btn btn-success" href="#">
        <i class="fa fa-plus"></i> Nuevo proveedor</a>
    </div>
@stop

@section('main-content')
    @if($errors->has())
        <div class="alert alert-warning" role="alert">
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        </div>
    @endif

        <div class="box tabla-proveedores">
            <div class="box-body"> 

                <table class="table table-striped table-bordered accionstyle"  cellspacing="0" width="100%" id="tabla-proveedores">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Dirección</th>
                            <th>E-Mail</th>
                            <th>Telefono</th>
                            <th>Observaciones</th>
                            <th>Rubros</th>
                            <th>Modificado</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('configuraciones.modalsProveedores.create')
        @include('configuraciones.modalsProveedores.edit')
        @include('configuraciones.modalsProveedores.delete')
        @include('configuraciones.modalsProveedores.activar')

        <script>
            $(document).ready(function(){
            //DATATABLE
                $('#tabla-proveedores').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/datatables/proveedores",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_proveedor', name: 'proveedores.id_proveedor', visible: false},
                        {data: 'nombre', name: 'proveedores.nombre'},
                        {data: 'direccion', name: 'proveedores.direccion'},
                        {data: 'email', name: 'proveedores.email'},
                        {data: 'telefono', name: 'proveedores.telefono'},
                        {data: 'observaciones', name: 'proveedores.observaciones'},
                        {data: 'rubros', name: 'proveedores.rubros'},
                        {data: 'updated_at', name: 'proveedores.updated_at'},
                        {data: 'usuario', name: 'users.name'},
                        {data: 'estado', name: 'proveedores.estado'},
                        {data: 'action', name: 'action' , orderable: false, searchable: false},
                    ],
                    "order": [ 7, "desc" ],
                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
            //FIN DATATABLE

                //ESPERAR HASTA QUE CARGUE LA TABLA
                 $('#tabla-proveedores').on('draw.dt', function () {
                    //MODAL DELETE -----------------------------------------------------------------------
                    $('.delete').click(function() {
                        $('#delete').modal();
                        var id = $(this).attr('value');
                        $("input[name='id_proveedor']").val(id);
                    });
                    //FIN MODAL DELETE -------------------------------------------------------------------
                    //MODAL ACTIVAR -----------------------------------------------------------------------
                    $('.activar').click(function() {
                        $('#activar').modal();
                        var id = $(this).attr('value');
                        $("input[name='id_proveedor']").val(id);
                    });
                    //FIN MODAL ACTIVAR -------------------------------------------------------------------

                    //MODAL EDIT --------------------------------------------------------------------------
                    $('.edit').click(function(){
                        $('#editarproveedor').modal();

                        var nombre = $(this).data('nombre');
                        var direccion = $(this).data('direccion');
                        var email = $(this).data('email');
                        var telefono = $(this).data('telefono');
                        var id = $(this).attr('value');
                        var observaciones = $(this).data('observaciones');
                        var rubros = $(this).data('rubros');

                        if(rubros){
                            var rubros2 = rubros.split(', ');
                        }     

                        $(".edit-nombre").val( nombre ).trigger("change");
                        $(".edit-direccion").val( direccion ).trigger("change");
                        $(".edit-email").val( email ).trigger("change");
                        $(".edit-telefono").val( telefono ).trigger("change");
                        $(".edit-observaciones").val( observaciones ).trigger("change");
                        $(".edit-rubros").val(rubros2).trigger("change");
                        $(".edit-id_proveedor").val(id);
                    });   
                    //FIN MODAL EDIT -----------------------------------------------------------------------

                });
                //FIN ESPERAR HASTA QUE CARGUE LA TABLA
                
                //CERRAR TODOS LOS MODALES
                $('.close').click(function() {
                    $('#editarproveedor').modal('hide');
                    $('#delete').modal('hide');
                });
                //FIN CERRAR TODOS LOS MODALES
            });
        </script>

    @endsection

<!-- Arreglar validaciones 
    arreglar edit formulario
    
-->