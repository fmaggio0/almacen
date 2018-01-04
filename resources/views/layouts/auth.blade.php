<!DOCTYPE html>
<html>

	<head>
	    <meta charset="UTF-8">
	    <title> Sistema Integral de Compras</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	    <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="/css/ionicons.min.css" />
        <link rel="stylesheet" href="/css/AdminLTE.css" />
        <link rel="stylesheet" href="/css/estilos.css" />
        <link rel="stylesheet" href="/css/skins/skin-blue.css" />

        <link rel="stylesheet" href="/plugins/jQuery/jquery-ui.min.css" />
        <link rel="stylesheet" href="/plugins/jQuery/jquery-ui.theme.min.css" />
        <link rel="stylesheet" href="/plugins/font-awesome-4.6.3/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css" />
        <link rel="stylesheet" href="/plugins/iCheck/square/blue.css" />
        <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css" />
        
        <script src="{{ asset('/plugins/jQuery/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('/plugins/jQuery/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('/plugins/select2/js/i18n/es.js') }}"></script>
        <script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/js/bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/js/handlebars-v4.0.5.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/js/bootbox.js') }}" type="text/javascript"></script>
	</head>


@yield('content')

</html>