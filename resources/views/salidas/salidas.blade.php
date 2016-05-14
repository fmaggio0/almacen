@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection


@section('main-content')
        <div class="box">
            <div class="box-header">
               
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <form>
                    <div class="col-md-6">
                     <fieldset style="  border: 1px groove #ddd !important;
                            padding: 0 1.4em 1.4em 1.4em !important;
                            margin: 0 0 1.5em 0 !important;
                            -webkit-box-shadow:  0px 0px 0px 0px #000;
                        ">
                    <legend style=" font-size: 1.2em !important;
                            font-weight: bold !important;
                            text-align: left !important;
                            width:auto;
                            padding:0 10px;
                            border-bottom:none;">Despachar salidas</legend>
                        <div class="form-group">
                            <label class="col-sm-6">Salida de:</label>
                            <select>
                                <option>Articulos</option>
                                <option>Respuestos</option>
                                <option>Combustibles</option>
                            </select>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-6">Fecha:</label>
                            <input type="text" value="07-04-2016 12:33 hs"></input>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6">Despachante:</label>
                            <input type="text" value="DALMAS DAVID">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6">Responsable:</label>
                            <input type="text" value="ZOLEZZI JOSE">
                        </div>
                       </fieldset>
                    </div>
                    <div class="col-md-6">
                    <fieldset style="  border: 1px groove #ddd !important;
                            padding: 0 1.4em 1.4em 1.4em !important;
                            margin: 0 0 1.5em 0 !important;
                            -webkit-box-shadow:  0px 0px 0px 0px #000;
                        ">
                    <legend style=" font-size: 1.2em !important;
                            font-weight: bold !important;
                            text-align: left !important;
                            width:auto;
                            padding:0 10px;
                            border-bottom:none;">Vehiculos</legend>
                        <div class="form-group">
                            <label class="col-sm-6">Nº Nota:</label>
                            <input type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6">Nº Comprobante:</label>
                            <input type="text" disabled></input>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6">Vehiculos:</label>
                            <input type="text" disabled>
                        </div>
                        
                    </fieldset>
                        
                    <fieldset style="  border: 1px groove #ddd !important;
                            padding: 0 1.4em 1.4em 1.4em !important;
                            margin: 0 0 1.5em 0 !important;
                            -webkit-box-shadow:  0px 0px 0px 0px #000;
                        ">
                    <legend style=" font-size: 1.2em !important;
                            font-weight: bold !important;
                            text-align: left !important;
                            width:auto;
                            padding:0 10px;
                            border-bottom:none;">Respuestos</legend>
                        <div class="form-group">
                            <label class="col-sm-6">Nº Nota:</label>
                            <input type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6">Maquina:</label>
                            <input type="text" disabled></input>
                        </div>
                    </fieldset>

                    </div>
                <form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
@endsection