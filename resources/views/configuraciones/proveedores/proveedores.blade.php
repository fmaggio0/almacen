@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE PROVEEDORES
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="/proveedores/nuevo">
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
                            <th>CUIT</th>
                            <th>E-Mail</th>
                            <th>Telefono</th>
                            <th>Observaciones</th>
                            <th>Rubros</th>
                            <th>Modificado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->


        @include('configuraciones.proveedores.delete')
        @include('configuraciones.proveedores.activar')
@stop

@section('js')
<script>
    $(document).ready(function(){
        //Ocultar mensajes de error o success
        $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
            $("ocultar").alert('close');
        });
        
        //DATATABLE
        $('#tabla-proveedores').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/datatables/proveedores",
            "error": function () {
                alert( 'Custom error' );
            },
            "columns":[
                {data: 'id_proveedor', name: 'proveedores.id_proveedor', visible: false, orderable: false, searchable: false},
                {data: 'nombre', name: 'proveedores.nombre'},
                {data: 'direccion', name: 'proveedores.direccion'},
                {data: 'cuit', name: 'proveedores.cuit'},
                {data: 'email', name: 'proveedores.email'},
                {data: 'telefono', name: 'proveedores.telefono'},
                {data: 'observaciones', name: 'proveedores.observaciones'},
                {data: 'rubros', name: 'proveedores.rubros'},
                {data: 'updated_at', name: 'proveedores.updated_at'},
                {data: 'estado', name: 'proveedores.estado'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [ 7, "desc" ],
            "language":{
                url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
            }
        });

        //ESPERAR HASTA QUE CARGUE LA TABLA
        $('#tabla-proveedores').on('draw.dt', function () {
            //MODAL DELETE -----------------------------------------------------------------------
            $('.delete').click(function() {
                $('#delete').modal();
                var id = $(this).attr('value');
                $("input[name='id_proveedor']").val(id);
            });
            //MODAL ACTIVAR -----------------------------------------------------------------------
            $('.activar').click(function() {
                $('#activar').modal();
                var id = $(this).attr('value');
                $("input[name='id_proveedor']").val(id);
            });
        });
        
        //CERRAR TODOS LOS MODALES
        $('.close').click(function() {
            $('#activar').modal('hide');
            $('#delete').modal('hide');
        });

    });
</script>
@stop