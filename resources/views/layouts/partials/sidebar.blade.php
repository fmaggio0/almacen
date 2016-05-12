<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">ALMACEN</li>
            <!-- Optionally, you can add icons to the links -->
           
            <li class="active"><a href="{{ url('home') }}"> <i class='fa fa-link'></i> <span>Principal</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Movimientos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Entradas</a></li>
                    <li><a href="#">Salidas</a></li>
                </ul>
            </li>

            <li><a href="#"><i class='fa fa-link'></i> <span>Recibir autorizaciones</span></a></li>
            <li><a href="#"><i class='fa fa-link'></i> <span>Recibir orden de compra</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Informes/Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Movimiento de Stock</a></li>
                    <li><a href="#">Movimientos por empleado</a></li>
                    <li><a href="#">Stock faltante</a></li>
                    <li><a href="#">Reporte de compras</a></li>
                    <li><a href="#">Combustibles</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>Configuracion</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Articulos</a></li>
                    <li><a href="#">Proveedores</a></li>
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Back Up</a></li>
                </ul>
            </li>


        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
