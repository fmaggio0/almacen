@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection


@section('main-content')
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Despachar autorización</h3>
                 <div class="box-tools">
                    <div class="input-group">
                        <input type="button" name="table_search" class="form-control input-sm pull-right" value='Descartar autorizacion' />
                    </div>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Derivado por</th>
                        <th>Area</th>
                        <th>Fecha</th>
                        <th>Autoriza a</th>
                        <th>Legajo</th>
                    </tr>
                    <tr>
                        <td>ndalmas0</td>
                        <td>Espacios Verdes</td>
                        <td>11-7-2016 12:45</td>
                        <td>Franco Maggioni</td>
                        <td>47004</td>
                    </tr>
                    </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        <div class="box">
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
                        <td>1</td>
                        <td>REMERA</td>
                        <td>1</td>
                        <td><input type='checkbox' /></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>GUANTE PUÑO LARGO x 1 U</td>
                        <td>1</td>
                        <td><input type='checkbox' /></td>
                    </tr>
                </table>
                <input type='button' class="btn btn-default" value='Despachar'/><input type='button' class="btn btn-default" value='Imprimir'/>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->

@endsection