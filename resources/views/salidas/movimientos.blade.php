@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        GESTION DE MOVIMIENTOS DE SALIDA
    </div>
        <div class="boton_titulo">
        <a class="btn btn-success" href="#" id="addsalida">
        <i class="fa fa-plus"></i> Nueva salida</a>
    </div>
@stop


@section('main-content')
        <div class="box tabla-articulos">
            <div class="box-body no-padding">
                <table id="tabla-movimientos" class="table table-striped table-bordered"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nro documento</th>
                            <th>Tipo de movimiento</th>
                            <th>Area</th>
                            <th>Responsable</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>NOTSA-1</td>
                            <td>Destruccion</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td>
                             <span class="label label-success">Registrado</span></td>
                            <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>NOTSA-2</td>
                            <td>Salida por retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>NOTSA-3</td>
                            <td>Salida asignada a trabajo</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-warning">Pendiente</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-upload"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>NOTSA-4</td>
                            <td>Salida asignada a trabajo</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>NOTSA-5</td>
                            <td>Salida por retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>NOTSA-6</td>
                            <td>Salida por retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>NOTSA-7</td>
                            <td>Salida asignada a trabajo</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-warning">Pendiente</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-upload"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>NOTSA-8</td>
                            <td>Salida por retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-warning">Pendiente</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-upload"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>NOTSA-9</td>
                            <td>Salida por retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>AUT-10</td>
                            <td>Autorizacion retiro personal</td>
                            <td>Espacios verdes</td>
                            <td>Zolezzi, Jose</td>
                            <td>29/05/2016 10:44</td>
                            <td>ndalmas0</td>
                            <td><span class="label label-success">Registrado</span></td>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nro documento</th>
                            <th>Tipo de movimiento</th>
                            <th>Area</th>
                            <th>Responsable</th>
                            <th>Fecha que registra</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                             <td>
                                <a class="btn botceleste btn-xs" href="#">
                                    <i class="fa fa-search"></i></a> 
                                <a class="btn botgris btn-xs" href="#">
                                    <i class="fa fa-print"></i></a> 
                                <a class="btn botrojo btn-xs" href="#">
                                    <i class="fa fa-times"></i></a>
                            </td>
                        <tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('salidas.modalsMovimientos.salidastock')

        <script>
       $(document).ready( function () {
            $('#tabla-movimientos').DataTable({
                language: {
                    url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                }
            });

            //MODAL SALIDA STOCK
            $('#addsalida').click(function(){
                $("#salidastock").modal();
            });
            //SELECT2
            $.getJSON("/movimientos/responsables", function (json) { //para modal edit y add
                    $("#responsables").select2({
                        data: json,
                        language: "es",
                    });
            });
            $.getJSON("/movimientos/empleados", function (json) { //para modal edit y add
                    $("#empleados").select2({
                        data: json,
                        language: "es",
                    });
            });

            $("#articulos").select2({
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                tokenSeparators: [','],
                ajax:   
                    {
                        url: "/movimientos/articulos",
                        dataType: 'json',
                        delay: 450,
                        data: function(params) {
                            return {
                                term: params.term
                            }
                        },
                        processResults: function (data) {
                             data = data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    stock: item.stock_actual,
                                    unidad: item.unidad

                                };
                            });
                            return { results: data };
                        },
                        cache: true
                    }
            });
            $("#articulos").on("select2:select", function(e) { 
                data=$("#articulos").select2('data')[0];
                $("#cantidad").attr('placeholder', data.stock+" "+data.unidad+"es disponibles" )
            });
        });
        </script>
@endsection