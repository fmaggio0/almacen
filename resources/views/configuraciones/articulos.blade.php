@extends('layouts.app')

@section('htmlheader_title')
    Home
@endsection
@section('scripts')
    @include('layouts.partials.scripts')
@show


@section('main-content')
        <div class="box">
                <table class="table table-hover" id="articulos">
                    <thead>
                        <tr>
                            <th>Derivado por</th>
                            <th>Area</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <script>
            $(document).ready(function(){
                $('#articulos').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/api/users",
                    "columns":[
                        {data: 'id'},
                        {data: 'desc_articulo'},
                        {data: 'estado'},
                    ]
                });
            });
        </script>
@endsection