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
        @include('configuraciones.modalsArticulos.edit')
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
                        {data: 'id_articulo', name: 'articulos.id_articulo'},
                        {data: 'descripcion', name: 'articulos.descripcion'},
                        {data: 'unidad', name: 'articulos.unidad'},
                        {data: 'usuario', name: 'articulos.unidad'},
                        {data: 'descripcionrubro', name: 'rubros.descripcion'},
                        {data: 'descripcionsubrubro', name: 'subrubros.descripcion'},
                        {data: 'updated_at', name: 'articulos.updated_at'},
                        {data: 'estado', name: 'articulos.estado'},
                        {data: 'action', name: 'action' , orderable: false, searchable: false},
                    ],

                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
                //SELECT2-------------------------------------------
                //select2 Unidades de medida
                $(".unidades").select2({
                    language: "es",
                });
                //select2 rubros
                $.getJSON("/rubros", function (json) { //para modal edit y add
                    $(".completarrubros").select2({
                        data: json,
                        language: "es",
                    });
                });
                //select2 subrubros
                $.getJSON("/subrubros" , function (json) { //solo modal edit
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
                    $.getJSON("/rubrosub/id=" + id, function (json) {
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


                    //MODAL EDIT --------------------------------------------------------------------------
                    $('.edit').click(function(){
                        $('#editar').modal();

                        //tomo las variables y las paso al modal edit
                        var unidad = $(this).data('selectunidad');
                        var rubro = $(this).data('selectrubro');
                        var subrubro = $(this).data('selectsubrubro');
                        var desc = $(this).data('desc');
                        var id = $(this).attr('value');

                         $("#selectsubrubroedit").prop("readonly", true); //desabilitar subrubro hasta que se elija rubro **CORREJIR** Si lo desabilito que seria lo corecto, el usuario vera toda la lista de subrubros.

                        $('#selectrubroedit').on("select2:select", function(e) { //si elijo un rubro...
                            
                            idrubro = $("#selectrubroedit").val(); //tomar id

                            $("#selectsubrubroedit").select2().empty(); // vaciar select subrubros

                            $.getJSON("/rubrosub/id=" + idrubro, function (json) { //completar select subrubros con la query que responda al id del rubro
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

  
                    });   
                    //FIN MODAL EDIT -----------------------------------------------------------------------

                });
                //FIN ESPERAR HASTA QUE CARGUE LA TABLA

                //MODAL ADD ARTICULOS -----------------------------------------------------------------------
                $('#nuevo').click(function(){
                    $('#myModal').modal();
                });
                //FIN MODAL ADD ARTICULOS -----------------------------------------------------------------------
                
                //CERRAR TODOS LOS MODALES
                $('.close').click(function() {
                    $('#myModal').modal('hide');
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