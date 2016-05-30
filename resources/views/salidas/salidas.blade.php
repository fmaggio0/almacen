@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section ('contentheader_title') 
    <div class="titulo_header">
        SALIDA
    </div>
@stop

@section('main-content')
        <div class="box" style="
    width: 700px;">
            <!--box-header -->
            <div class="box-header">
                <fieldset>
                    <legend>Encabezado</legend>
                        <div class="form-group" style="float:left;">
                            <label class="formsalidas">Tipo de movimiento:</label>
                            <select class="inputs">
                                <option> *** Seleccione tipo de mov *** </option>
                                <option>Salida por retiro personal</option>
                                <option>Salida por destrucción</option>
                                <option>Salida asignada a trabajo</option>
                            </select>
                        </div>
                        <div class="form-group" style="float:right;">
                            <label class="formsalidas">Responsable:</label>
                            <input class="inputs" type="text" value="ZOLEZZI JOSE">
                        </div>
                         <div class="form-group">
                            <label class="formsalidas">Nº Nota:</label>
                            <input class="inputs" type="text" value="35221">
                        </div>

                </fieldset>
            </div><!-- /.box-header -->

           <!-- /.box-body -->
            <div class="box-body">
                <fieldset>
                     <legend>Detalles</legend>
                        <div class="form-group col-sm-4">
                            <label>Articulo:</label>
                            <input type="text" value="DALMAS DAVID">
                        </div>
                        <div class="form-group col-sm-4">
                            <label> Stock actual: 322</label>
                        </div>
                        <div class="form-group col-sm-4">
                            <label> Cantidad a retirar:</label>
                            <input type="text" size="4" value="1">
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="submit" class="btn btn-default" value="Asignar empleado">
                            <input type="text" value="RAMIREZ, MATIAS">
                        </div>
                         <div class="form-group col-sm-4">
                            <input type="submit" class="btn btn-default" value="Agregar articulo">
                        </div>
                </fieldset>
            </div><!-- /.box-body -->

                <div style="padding: 8px;" class="form-group">
                    <input type='button' class="btn btn-primary" value='Despachar'/>
                    <input type='submit' class="btn btn-default" value='Imprimir'/>
                </div>

        </div><!-- /.box -->
@endsection