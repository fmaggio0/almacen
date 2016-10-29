@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
    </div>
        <div class="boton_titulo">
        <a id="add-articulo" class="btn btn-success" href="#">
        <i class="fa fa-plus"></i> Nuevo articulo</a>
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

        <div class="box">
            <div class="box-body"> 
                <table class="table table-striped table-bordered accionstyle"  cellspacing="0" width="100%" id="tabla-articulos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Stock minimo</th>
                            <th>Stock actual</th>
                            <th>Rubro</th>
                            <th>Subrubro</th>
                            <th>Modificado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        @include('configuraciones.modalsArticulos.create')
        @include('configuraciones.modalsArticulos.edit')
        @include('configuraciones.modalsArticulos.delete')
        @include('configuraciones.modalsArticulos.activar')

        <script>
            $(document).ready(function(){
            //DATATABLE
                $('#tabla-articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/datatables/articulos",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_articulo', name: 'articulos.id_articulo', visible: false, orderable: false, searchable: false},
                        {data: 'descripcion', name: 'articulos.descripcion'},
                        {data: 'unidad', name: 'articulos.unidad'},
                        {data: 'stock_minimo', name: 'articulos.stock_minimo'},
                        {data: 'stock_actual', name: 'articulos.stock_actual'},
                        {data: 'descripcionrubro', name: 'rubros.descripcion'},
                        {data: 'descripcionsubrubro', name: 'subrubros.descripcion'},
                        {data: 'updated_at', name: 'articulos.updated_at'},
                        {data: 'estado', name: 'articulos.estado'},
                        {data: 'action', name: 'action' , orderable: false, searchable: false},
                    ],
                    "order": [ 7, "desc" ],
                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
            //FIN DATATABLE

                //ESPERAR HASTA QUE CARGUE LA TABLA
                 $('#tabla-articulos').on('draw.dt', function () {

                    //MODAL DELETE -----------------------------------------------------------------------
                    $('.delete').click(function() {
                        $('#delete').modal();
                        var id = $(this).attr('value');
                        $("input[name='id_articulo']").val(id);
                    });
                    //FIN MODAL DELETE -------------------------------------------------------------------

                    //MODAL ACTIVAR -----------------------------------------------------------------------
                    $('.activar').click(function() {
                        $('#activar').modal();
                        var id = $(this).attr('value');
                        $("input[name='id_articulo']").val(id);
                    });
                    //FIN MODAL ACTIVAR ------------------------------------------------------------------
                });
                //FIN ESPERAR HASTA QUE CARGUE LA TABLA

                //FOCUS ACCESIBILIDAD

                //MODAL ADD ARTICULOS -----------------------------------------------------------------------

                    /*//focus accesibilidad
                    $('#creararticulo').on('shown.bs.modal', function() {
                        $(".desc").focus();
                        $(".unidades").on("select2:select", function(e) {
                            $(".completarrubros").select2("open");
                        });
                        $(".completarrubros").on("select2:select", function(e) {
                            $("subrubros").select2("open");
                        });
                        $(".subrubros").on("select2:select", function(e) {
                            $(".btn-primary").focus();
                        });
                    });
                    //fin focus accesibilidad*/

                $("#add-articulo").click(function(){
                    $("#creararticulo").modal();
                });

                //FIN MODAL ADD ARTICULOS -----------------------------------------------------------------------
                
                //CERRAR TODOS LOS MODALES
                $('.close').click(function() {
                    $('#delete').modal('hide');
                });
                //FIN CERRAR TODOS LOS MODALES
            });
        </script>

    @endsection

<!-- Arreglar validaciones 
    arreglar edit formulario
    
-->