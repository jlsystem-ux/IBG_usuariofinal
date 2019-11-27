<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas Laravel Vue Js- IncanatoIT">
    <meta name="author" content="Incanatoit.com">
    <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>IBG - @yield('title')</title>
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

  <div id="app">

    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notificaciones</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Ingresos
                        <span class="badge badge-success">3</span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks"></i> Ventas
                        <span class="badge badge-danger">2</span>
                    </a>
                </div>
             <div class="">
               <a class="btn btn-primary" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fa fa-lock"></i> Cerrar sesión</a>
             </div>

            </li>
            <li class="nav-item dropdown">
                  <div class="dropdown-menu dropdown-menu-right">
                    <form id="logout-form" action="{{ route ('logout')}}" method="post" style="display: none;">
                          {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">

        @if(Auth::check())
             @if(Auth::user()->idrol == 1)
                   @include('sidebar.sidebaradministrador')
                     @elseif(Auth::user()->idrol == 2)
                      @include('sidebar.sidebarvendedor')
                      @elseif(Auth::user()->idrol == 3)
                       @include('sidebar.sidebaralmacenero')
                      @else
             @endif
        @endif

        <!-- Contenido Principal -->

        <div class="container">
             @yield('contenido')
        </div>

        <!-- /Fin del contenido principal -->
    </div>

</div>

    <footer class="app-footer">
        <span><a href="http://oferta.senasofiaplus.edu.co/sofia-oferta/">Estudiantes SENA ADSI</a> &copy; 2019</span>
        <span class="ml-auto">Desarrollado por <a href="http://oferta.senasofiaplus.edu.co/sofia-oferta/">ADSI</a></span>
    </footer>

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


</body>

</html>
