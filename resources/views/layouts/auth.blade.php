<!DOCTYPE html>
<html>

	<head>
	    <meta charset="UTF-8">
	    <title> Sistema Integral de Compras</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	    {{-- Bootstrap 3.3.4 --}}
	    {!! Html::style('/css/bootstrap.min.css') !!}
	    {!! Html::style('/css/bootstrap-theme.min.css') !!}
	    {{-- Font Awesome Icons --}}
	    {!! Html::style('plugins/font-awesome-4.6.3/css/font-awesome.min.css') !!} 
	    {{-- Select2--}}
	    {!! Html::style('/plugins/select2/css/select2.min.css') !!}
	    {{-- Ionicons --}}
	    {!! Html::style('/css/ionicons.min.css') !!}
	    {{-- Theme style --}}
	    {!! Html::style('/css/AdminLTE.css') !!}
	    {{-- Datatables style --}}
	    {!! Html::style('/plugins/datatables/dataTables.bootstrap.css') !!}
	    {{-- Estilos personalizados --}}
	    {!! Html::style('/css/estilos.css') !!}
	    {{-- AdminLTE Skins --}}
	    {!! Html::style('/css/skins/skin-blue.css') !!}
	    {{-- iCheck --}}
	    {!! Html::style('/plugins/iCheck/square/blue.css') !!}
	    {{-- Jquery 2.2.4 JS --}}
	    <script src="{{ asset('/plugins/jQuery/jQuery-2.2.4.min.js') }}"></script>
	    {{-- Bootstrap 3.3.2 JS --}}
	    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
	    {{-- AdminLTE App --}}
	    <script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
	    <script src="{{ asset('/js/bootbox.js') }}" type="text/javascript"></script>
	    {{-- DataTables --}}
	    <script src="{{ asset('/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	    {{-- Bootstrap-select--}}
	    <script src="{{ asset('/plugins/select2/js/select2.min.js') }}"></script>
	    <script src="{{ asset('/plugins/select2/js/i18n/es.js') }}"></script>
	    {{--handlebars--}}
	    <script src="{{ asset('/js/handlebars-v4.0.5.js') }}" type="text/javascript"></script>
	    {{--icheck--}}
	    <script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
	</head>


@yield('content')

</html>