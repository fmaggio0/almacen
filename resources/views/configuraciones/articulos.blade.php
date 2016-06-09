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
                            <th>Subrubro</th>
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
                            <th>Subrubro</th>
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
                    "ajax": "/articulos/tabla",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_articulo', name: 'articulos.id_articulo'},
                        {data: 'descripcion', name: 'articulos.descripcion'},
                        {data: 'unidad', name: 'articulos.unidad'},
                        {data: 'usuario', name: 'articulos.usuario'},
                        {data: 'id_rubro', name:'rubros.id_rubro'},
                        {data: 'id_subrubro', name: 'subrubros.id_subrubro'},
                        {data: 
                            function(data) {
                            return '<a href="#" value="'+ data.id_articulo +'" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i></a><a href="#" value="'+ data.id_articulo +'" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-remove"></i></a>';
                            }, "orderable": false, "searchable": false,
                        },
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
                        $("input[name='id']").val(id);
                    });
                });
                $('#nuevo').click(function(){
                    $('#myModal').modal(); 
                });
                
                $('.close').click(function() {
                    $('#myModal').modal('hide');
                });
                //FIN EVENTOS MODALES
            });
        </script>

    @endsection