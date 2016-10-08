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
    @if($errors->has())
        <div class="alert alert-warning" role="alert">
           @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
          @endforeach
        </div>
    @endif

        <div class="box tabla-articulos">
            <div class="box-body no-padding"> 

                <table class="table table-striped table-bordered accionstyle"  cellspacing="0" width="100%" id="articulos">
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
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('configuraciones.modalsArticulos.create')
        @include('configuraciones.modalsArticulos.edit')
        @include('configuraciones.modalsArticulos.delete')
        @include('configuraciones.modalsArticulos.activar')

        <script>
            $(document).ready(function(){
            //DATATABLE
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/datatables/articulos",
                    "error": function () {
                        alert( 'Custom error' );
                      },
                    "columns":[
                        {data: 'id_articulo', name: 'articulos.id_articulo', visible: false},
                        {data: 'descripcion', name: 'articulos.descripcion'},
                        {data: 'unidad', name: 'articulos.unidad'},
                        {data: 'stock_minimo', name: 'articulos.stock_minimo'},
                        {data: 'stock_actual', name: 'articulos.stock_actual'},
                        {data: 'descripcionrubro', name: 'rubros.descripcion'},
                        {data: 'descripcionsubrubro', name: 'subrubros.descripcion'},
                        {data: 'updated_at', name: 'articulos.updated_at'},
                        {data: 'usuario', name: 'users.name'},
                        {data: 'estado', name: 'articulos.estado'},
                        {data: 'action', name: 'action' , orderable: false, searchable: false},
                    ],
                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
            //FIN DATATABLE

                //SELECT2-------------------------------------------
                //select2 Unidades de medida
                $(".unidades").select2({
                    language: "es",
                });
                //select2 rubros
                $.getJSON("/ajax/rubros", function (json) { //para modal edit y add
                    $(".completarrubros").select2({
                        data: json,
                        language: "es",
                    });
                });
                //select2 subrubros
                $.getJSON("/ajax/subrubros" , function (json) { //solo modal edit
                  $(".completarsubrubros").select2({
                        data: json,
                        language: "es",

                    });
                });
                //FIN SELECT2-------------------------------------------

                 $(".subrubros").prop("disabled", true);
                 $('.completarrubros').on("select2:select", function(e) { 
                    id = $(".completarrubros").val();
                    $(".subrubros").select2();
                    $(".subrubros").select2().empty();
                    $.getJSON("ajax/subrubros/" + id, function (json) {
                      $(".subrubros").select2({
                            data: json,
                            language: "es",

                        });
                    });
                    $(".subrubros").prop("disabled", false);
                });
                //FIN SELECT2 FAMILIA-SUBFAMILIA

                //ESPERAR HASTA QUE CARGUE LA TABLA
                 $('#articulos').on('draw.dt', function () {

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
                    //FIN MODAL ACTIVAR -------------------------------------------------------------------


                    //MODAL EDIT --------------------------------------------------------------------------
                    $('.edit').click(function(){
                        $('#editar').modal();

                        //tomo las variables y las paso al modal edit
                        var unidad = $(this).data('selectunidad');
                        var rubro = $(this).data('selectrubro');
                        var subrubro = $(this).data('selectsubrubro');
                        var desc = $(this).data('desc');
                        var id = $(this).attr('value');
                        var estado = $(this).data('estado');

                         $("#selectsubrubroedit").prop("readonly", true); //desabilitar subrubro hasta que se elija rubro **CORREJIR** Si lo desabilito que seria lo corecto, el usuario vera toda la lista de subrubros.

                        $('#selectrubroedit').on("select2:select", function(e) { //si elijo un rubro...
                            
                            idrubro = $("#selectrubroedit").val(); //tomar id

                            $("#selectsubrubroedit").select2().empty(); // vaciar select subrubros

                            $.getJSON("/ajax/subrubros/" + idrubro, function (json) { //completar select subrubros con la query que responda al id del rubro
                              $("#selectsubrubroedit").select2({
                                    data: json,
                                    language: "es",

                                });
                            });

                            $("#selectsubrubroedit").prop("readonly", false); // habilitar subrubro una vez que se eligio rubro
                        });
                    
                        //Modificar atributos con el item seleccionado

                        $("#descedit").val( desc ).trigger("change");
                        $("#selectunidadedit").val( unidad ).trigger("change");
                        $("#selectrubroedit").val( rubro ).trigger("change");
                        $("#selectsubrubroedit").val( subrubro ).trigger("change");
                        $("input[name='id_articulo']").val(id);
                        if (estado == 0)
                        {
                           $("#estado").val(false); 
                           $('#estado').prop('checked', false);
                        }
                        else
                        {
                            $("#estado").val(true);
                            $('#estado').prop('checked', true);
                        }
                    });   

                        //focus accesibilidad EDIT
                        $('#editar').on('shown.bs.modal', function() {
                            $("#descedit").focus();
                        });
                        $("#selectunidadedit").on("select2:select", function(e) {
                            $("#selectrubroedit").select2("open");
                        });
                        $("#selectrubroedit").on("select2:select", function(e) {
                            $("#selectsubrubroedit").select2("open");
                        });
                    //FIN MODAL EDIT -----------------------------------------------------------------------

                });
                //FIN ESPERAR HASTA QUE CARGUE LA TABLA

                //FOCUS ACCESIBILIDAD

                //MODAL ADD ARTICULOS -----------------------------------------------------------------------

                $('#nuevo').click(function(){
                    $('#creararticulo').modal();
                });
                    //focus accesibilidad
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
                    //fin focus accesibilidad

                //FIN MODAL ADD ARTICULOS -----------------------------------------------------------------------
                
                //CERRAR TODOS LOS MODALES
                $('.close').click(function() {
                    $('#creararticulo').modal('hide');
                    $('#editar').modal('hide');
                    $('#delete').modal('hide');
                });
                //FIN CERRAR TODOS LOS MODALES
            });
        </script>

    @endsection

<!-- Arreglar validaciones 
    arreglar edit formulario
    
-->