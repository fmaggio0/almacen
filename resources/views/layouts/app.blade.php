<!DOCTYPE html>
<html lang="es">

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
        <link rel="stylesheet" href="/plugins/select2/css/select2.css" />
        <link rel="stylesheet" href="/plugins/iCheck/square/blue.css" />
        <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css" />

        <link rel="stylesheet" href="/plugins/leaflet/leaflet.css" />
        <link rel="stylesheet" href="/plugins/leaflet/leaflet-routing-machine.css" />
        
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
        <script src="{{ asset('/plugins/leaflet/leaflet.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/plugins/leaflet/leaflet-routing-machine.min.js') }}" type="text/javascript"></script>

    </head>

    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            {{-- HEADER --}}
            <header class="main-header">
                <a href="{{ url('/home') }}" class="logo">
                    <span class="logo-mini"><b>G</b>IC</span>{{-- mini logo --}}
                    <span class="logo-lg"><b>Sistema</b>GIC </span>{{-- logo --}}
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">{{-- Boton para achicar --}}
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">              
                            <li class="dropdown notifications-menu">{{-- Menu de notificaciones --}}
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Usted tiene -num- notificaciones</li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a href="#"><i class="fa fa-users text-aqua"></i> Autorizacion de retiro</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">Ver todas</a></li>
                                </ul>

                            </li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i></a></li>{{-- Cerrar session --}}
                        </ul>
                    </div>
                </nav>
            </header>
            {{-- SIDEBAR --}}
            <aside class="main-sidebar">
                <section class="sidebar">
                    @if (! Auth::guest())
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"/>
                            </div>
                            <div class="pull-left info">
                                <p>{{ Auth::user()->name }}</p>
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                    @endif

                    <ul class="sidebar-menu">

                        @role(['developers', 'user'])
                            <li class="header">GESTIONES DE COMPRA</li>
                            <li class="active">
                                <a href="{{ url('home') }}"><i class='fa fa-link'></i><span>Principal</span></a>
                            </li>
                            <li>
                                <a href="#"><i class='fa fa-exchange'></i> <span>Gestionar stock</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="/ingresos">Ingreso de Stock</a></li>
                                    <li><a href="/egresos">Egreso de Stock</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="/autorizaciones"><i class='fa fa-link'></i> <span>Gestionar autorizaciones</span></a>
                            </li>
                            <li>
                                <a href="#"><i class='fa fa-link'></i> <span>Gestionar ordenes de compra</span></a>
                            </li>
                            <li>
                                <a href="#"><i class='fa fa-link'></i> <span>Registro de combustibles</span></a>
                            </li>
                            <li>
                                <a href="#"><i class='fa fa-bar-chart'></i> <span>Informes/Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="/informes/stock">Movimiento de Stock</a></li>
                                    <li><a href="/informes/empleados">Movimientos por empleado</a></li>
                                    <li><a href="#">Stock faltante</a></li>
                                    <li><a href="#">Reporte de compras</a></li>
                                    <li><a href="#">Combustibles</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class='fa fa-cogs'></i> <span>Configuracion</span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="/articulos">Articulos</a></li>
                                    <li><a href="/proveedores">Proveedores</a></li>
                                </ul>
                            </li>
                        @endrole
                        
                        @role(['developers', 'user'])
                            <li class="header">GESTIONES DE AREAS</li>
                            <li>
                                <a href="/areas"><i class='fa fa-link'></i> <span>Inicio</span></a>
                            </li>
                            <li>
                                <a href="/areas/autorizaciones"><i class='fa fa-link'></i> <span>Autorizaciones</span></a>
                            </li>
                            <li>
                                <a href="/areas/indumentaria"><i class='fa fa-link'></i> <span>Indumentaria</span></a>
                            </li>
                        @endrole

                        @role(['developers', 'cil'])
                            <li class="header">GESTIONES DEL CIL</li>
                            <li><a href="/cil"><i class='fa fa-link'></i> <span>Inicio</span></a></li>
                            <li><a href="/cil/usuarios"><i class='fa fa-link'></i> <span>Usuarios</span></a></li>
                            <li><a href="/cil/roles"><i class='fa fa-link'></i> <span>Roles y permisos</span></a></li>
                            <li><a href="/backup"><i class='fa fa-link'></i><span>Back Ups</span></a></li>
                        @endrole

                    </ul>
                </section>
            </aside>
            {{-- CONTENIDO --}}
            <div class="content-wrapper">
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                        <li class="active">Here</li>
                    </ol><br>
                    <h1>
                        @yield('contentheader_title', 'FALTA COLOCAR TITULO')
                        <small></small>
                    </h1>
                </section>
                <section class="content">
                    @yield('main-content')
                </section>
            </div>
            @yield('js')
        </div>
    </body>
</html>
