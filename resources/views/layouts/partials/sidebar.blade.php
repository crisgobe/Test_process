<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start active_home_button">
                <a href="../home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Inicio</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item active_orders_button">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-clipboard"></i>
                    <span class="title">Procesos</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if (auth()->user()->user_types_id < 3)
                        <li class="nav-item">
                            <a href="../orders/new_order" class="nav-link">
                                <i class="icon-plus"></i>
                                <span class="title">Nuevo Proceso</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="../orders" class="nav-link">
                            <i class="icon-list"></i>
                            <span class="title">Procesos Activos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../orders/all" class="nav-link">
                            <i class="icon-drawer"></i>
                            <span class="title">Todos los Procesos</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            @if (auth()->user()->user_types_id < 1)
            
                <li class="nav-item active_users_button">
                    <a href="../users" class="nav-link">
                        <i class="fa fa-users"></i>
                        <span class="title">Usuarios</span>
                        <span class="arrow"></span>
                    </a>
                </li>
            @endif
            
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->