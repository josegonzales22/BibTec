<style>.page-title{font-weight: 700;}</style>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/book_white.svg') }}" width="30px">
        <div class="sidebar-brand-text mx-3 page-title">BibTec</div>
    </a>
    <div class="sidebar-heading fw-normal">
        Información
    </div>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'text-light fw-bolder' : '' }}" id="nav-link"
            href="{{ route('dashboard') }}">
            <i class="fa-solid fa-house {{ request()->routeIs('dashboard') ? 'text-light' : '' }}"></i><span>Inicio</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading fw-normal">
        Inventario
    </div>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('libro.*') ? 'text-light fw-bolder' : '' }}" id="nav-link"
            href="{{ route('libro.index') }}">
            <i class="fa-solid fa-book {{ request()->routeIs('libro.*') ? 'text-light' : '' }}"></i>
            <span>Libros</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('prestamo.*') ? 'text-light fw-bolder' : '' }}"
            href="{{route('prestamo.index')}}">
            <i class="fa-solid fa-folder-plus {{ request()->routeIs('prestamo.*') ? 'text-light' : '' }}"></i>
            <span>Préstamos</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('devolucion.*') ? 'text-light fw-bolder' : '' }}"
            href="{{route('devolucion.index')}}">
            <i class="fa-solid fa-folder-minus {{ request()->routeIs('devolucion.*') ? 'text-light' : '' }}"></i>
            <span>Devoluciones</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading fw-normal">
        Personas
    </div>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('trabajador.*') ? 'text-light fw-bolder' : '' }}"
        href="{{ route('trabajador.index') }}">
            <i class="fa-solid fa-user-gear {{ request()->routeIs('trabajador.*') ? 'text-light' : '' }}"></i>
            <span>Trabajadores</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('estudiante.*') ? 'text-light fw-bolder' : '' }}"
        href="{{ route('estudiante.index') }}">
            <i class="fa-solid fa-user-tie {{ request()->routeIs('estudiante.*') ? 'text-light' : '' }}"></i>
            <span>Estudiantes</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading fw-normal">
        Registros
    </div>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('historial.*') ? 'text-light fw-bolder' : '' }}"
        href="{{ route('historial.index') }}">
            <i class="fa-solid fa-file-contract {{ request()->routeIs('historial.*') ? 'text-light' : '' }}"></i>
            <span>Historial</span>
        </a>
    </li>
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <script src="https://kit.fontawesome.com/8e01b9fb0b.js" crossorigin="anonymous"></script>
</ul>
