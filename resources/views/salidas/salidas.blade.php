@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection


@section('main-content')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Encabezado</h3>
                <div class="box-tools">
                     <div class="form-group">
                        <label>07-04-2016 12:33 hs</label>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                        <div class="form-group col-sm-4">
                            <label>Despachante:</label>
                            <input type="text" value="DALMAS DAVID">
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Responsable:</label>
                            <input type="text" value="ZOLEZZI JOSE">
                        </div>
                         <div class="form-group col-sm-4">
                            <label>Nº Nota:</label>
                            <input type="text" value="35221">
                        </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

          <div class="box">
            <div class="box-header">
                <h3 class="box-title">Agregar articulos</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
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


            </div><!-- /.box-body -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Nro Item</th>
                        <th>Articulo</th>
                        <th>Cantidad</th>
                        <th>Autorizar</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>BOTINES DE CUERO PARA OPERARIOS 1 x U.</td>
                        <td>1</td>
                        <td><input type='checkbox' /></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>REMERA</td>
                        <td>1</td>
                        <td><input type='checkbox' /></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>GUANTE PUÑO LARGO x 1 U</td>
                        <td>1</td>
                        <td><input type='checkbox' /></td>
                    </tr>
                </table>
                <div style="padding: 8px;" class="form-group">
                    <input type='button' class="btn btn-primary" value='Despachar'/>
                    <input type='submit' class="btn btn-default" value='Imprimir'/>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
@endsection