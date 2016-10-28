<aside class="main-sidebar">

    <section class="sidebar">

        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu">

            @role(['developers', 'user'])
                <li class="header">GESTIONES DE COMPRA</li>
               
                <li class="active"><a href="{{ url('home') }}"> <i class='fa fa-link'></i> <span>Principal</span></a></li>

                <li class="treeview">
                    <a href="#"><i class='fa fa-exchange'></i> <span>Gestionar stock</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/ingresos">Ingreso de Stock</a></li>
                        <li><a href="/egresos">Egreso de Stock</a></li>
                    </ul>
                </li>

                <li><a href="/autorizaciones"><i class='fa fa-link'></i> <span>Gestionar autorizaciones</span></a></li>
                <li><a href="#"><i class='fa fa-link'></i> <span>Gestionar ordenes de compra</span></a></li>
                 <li><a href="#"><i class='fa fa-link'></i> <span>Registro de combustibles</span></a></li>

                <li class="treeview">
                    <a href="#"><i class='fa fa-bar-chart'></i> <span>Informes/Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#">Movimiento de Stock</a></li>
                        <li><a href="#">Movimientos por empleado</a></li>
                        <li><a href="#">Stock faltante</a></li>
                        <li><a href="#">Reporte de compras</a></li>
                        <li><a href="#">Combustibles</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><i class='fa fa-cogs'></i> <span>Configuracion</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="/articulos">Articulos</a></li>
                        <li><a href="/proveedores">Proveedores</a></li>
                    </ul>
                </li>
            @endrole
            
            @role(['developers', 'user'])
                <li class="header">GESTIONES DE AREAS</li>
                <li><a href="/areas/autorizaciones"><i class='fa fa-link'></i> <span>Autorizaciones</span></a></li>
            @endrole

            @role(['developers'])
                <li class="header">GESTIONES DEL CIL</li>
                <li><a href="/usuario"><i class='fa fa-link'></i> <span>Roles de usuario</span></a></li>
                <li><a href="/backup"><i class='fa fa-link'></i><span>Back Ups</span></a></li>
            @endrole

        </ul>
    </section>
</aside>
