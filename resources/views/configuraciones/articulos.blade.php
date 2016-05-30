@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section('main-content')
        <div class="box tabla-articulos">
            <div class="box-body no-padding">
                <table class="table table-striped table-bordered"  cellspacing="0" width="100%" id="articulos">
                    <thead>
                        <tr>
                            <th>Derivado por</th>
                            <th>Area</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Derivado por</th>
                            <th>Area</th>
                            <th>Fecha</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <script>
            $(document).ready(function(){
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/articulos/tabla",
                    "columns":[
                        {data: 'id'},
                        {data: 'desc_articulo'},
                        {data: 'estado'},
                    ],
                    "language":{
                        url: "{!! asset('/plugins/datatables/lenguajes/spanish.json') !!}"
                    }
                });
            });
        </script>
@endsection