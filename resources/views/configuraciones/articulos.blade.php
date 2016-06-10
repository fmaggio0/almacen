@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
    </div>
        <div class="boton_titulo">
        <a id="nuevo" class="btn btn-success" href="#">
        <i class="fa fa-plus"></i> Nuevo articulo</a>
    </div>
@stop

@section('main-content')
        <div class="box tabla-articulos">
            <div class="box-body no-padding"> 

                <table class="table table-striped table-bordered accionstyle"  cellspacing="0" width="100%" id="articulos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Usuario</th>
                            <th>Rubro</th>
                            <th>Subrubro</th>
                            <th>Modificado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID </th>
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Usuario</th>
                            <th>Rubro</th>
                            <th>Subrubro</th>
                            <th>Modificado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('configuraciones.modalsArticulos.create')
        @include('configuraciones.modalsArticulos.delete')

        <script>
            $(document).ready(function(){
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{!! route('datatables.data') !!}",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_articulo'},
                        {data: 'descripcion'},
                        {data: 'unidad'},
                        {data: 'usuario'},
                        {data: 'descripcionrubro'},
                        {data: 'descripcionsubrubro'},
                        {data: 'updated_at'},
                        {data: 'estado'},
                        {data: 'action', orderable: false, searchable: false},
                    ],

                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
                //SELECT2 FAMILIA-SUBFAMILIA-------------------------------------------
                $(".unidades").select2({
                    language: "es",
                });
                 $.getJSON("/rubros", function (json) {
                      $(".rubros").select2({
                            data: json,
                            language: "es",
                      });
                 });
                 $(".subrubros").select2();
                 $(".subrubros").prop("disabled", true);
                 $('.rubros').on("select2:select", function(e) { 
                    id = $(".rubros").val();
                    $(".subrubros").select2().empty();
                    $(".subrubros").prop("disabled", false);
                    $.getJSON("/subrubros/id=" + id, function (json) {
                      $(".subrubros").select2({
                            data: json,
                            language: "es",

                        });
                    });
                });
                //FIN SELECT2 FAMILIA-SUBFAMILIA
                //EVENTOS MODALES
                 $('#articulos').on('draw.dt', function () {
                    $('.delete').click(function() {
                        $('#delete').modal();
                        var id = $(this).attr('value');
                        $("input[name='id_articulo']").val(id);
                    });
                });
                $('#nuevo').click(function(){
                    $('#myModal').modal();
                $('#myModal').on('shown.bs.modal', function() {
                    $(".desc").focus();
                });
                });
                
                $('.close').click(function() {
                    $('#myModal').modal('hide');
                });
                //FIN EVENTOS MODALES
            });
        </script>

    @endsection