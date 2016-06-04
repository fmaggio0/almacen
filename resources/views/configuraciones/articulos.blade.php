@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="#">
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
                            <th>ID</th>
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

        @include ('configuraciones.modalsArticulos.create', ['submitTextButton' => 'ADD'])

        <script>
            $(document).ready(function(){
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/articulos/tabla",
                    "columns":[
                        {data: 'id_articulo'},
                        {data: 'descripcion'},
                        {data: 'unidad'},
                        {data: 'usuario'},
                        {data: 'id_rubro'},
                        {data: 'id_subrubro'},
                        {data: 
                            function(data) {
                            return '<a href="#edit-' + data.id_articulo + '" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i></a><a href="#edit-' + data.id_articulo + '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
                            }, "orderable": false, "searchable": false,
                        },
                    ],

                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
            });
        </script>
@endsection