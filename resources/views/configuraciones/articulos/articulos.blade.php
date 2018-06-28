@extends('layouts.app')

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE ARTICULOS
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="/articulos/nuevo" style="float: right;">
        <i class="fa fa-plus"></i> Nuevo articulo</a>
    </div>
@stop

@section('main-content')
        <!-- Mensajes de exito-->
        @if (session('status'))
            <div class="alert alert-success" id="ocultar">
                {{ session('status') }}
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
                            <th>Tipo</th>
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

        @include('configuraciones.articulos.delete')
        @include('configuraciones.articulos.activar')
@stop

@section('js')
    <script>
        $(document).ready(function(){
            //Ocultar mensajes de error o success
            $("#ocultar").fadeTo(8000, 500).slideUp(500, function(){
                $("ocultar").alert('close');
            });
            
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
                    {data: 'tipo', name: 'articulos.tipo'},
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
            $('#tabla-articulos').on('draw.dt', function () {
                $('.delete').click(function() {
                    $('#delete').modal();
                    var id = $(this).attr('value');
                    $("input[name='id_articulo']").val(id);
                });
                $('.activar').click(function() {
                    $('#activar').modal();
                    var id = $(this).attr('value');
                    $("input[name='id_articulo']").val(id);
                });
            });
        });
    </script>
@stop

 