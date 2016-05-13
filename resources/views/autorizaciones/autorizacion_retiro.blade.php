@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection


@section('main-content')
    <!--<div class="spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12"> -->

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Recibir autorizaciones</h3>
                <div class="box-tools">
                    <div class="input-group">
                        <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Derivado por</th>
                        <th>Area</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Autoriza a</th>
                        <th>Recibir</th>
                    </tr>
                    <tr>
                        <td>ndalmas0</td>
                        <td>Espacios Verdes</td>
                        <td>11-7-2016 12:45</td>
                        <td><span class="label label-warning">Pendiente</span></td>
                        <td>Franco Maggioni</td>
                        <td><input type='button' class="btn btn-default" value='Ver'/></td>
                    </tr>
                    <tr>
                        <td>fmaggio0</td>
                        <td>Taller</td>
                        <td>11-7-2014 09:49</td>
                        <td><span class="label label-warning">Pendiente</span></td>
                        <td>Matias Ramirez</td>
                        <td><input type='button' class="btn btn-default" value='Ver'/></td>
                    </tr>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

         <div class="box">
            <div class="box-header">
                <h3 class="box-title">Ultimas autorizaciones</h3>
                <div class="box-tools">
                    <div class="input-group">
                        <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Derivado por</th>
                        <th>Area</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Autoriza a</th>
                    </tr>
                    <tr>
                        <td>ndalmas0</td>
                        <td>Espacios Verdes</td>
                        <td>11-7-2016</td>
                        <td><span class="label label-success">Recibido</span></td>
                        <td>Franco Maggioni</td>
                    </tr>
                    <tr>
                        <td>fmaggio0</td>
                        <td>Taller</td>
                        <td>11-7-2014</td>
                        <td><span class="label label-warning">Pendiente</span></td>
                        <td>Matias Ramirez</td>
                    </tr>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
@endsection