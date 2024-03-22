<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-800 small text-center">
                {{Auth::user()->nombres}}
                <br>
                <span class="text-white pl-2 pr-2" style="background-color: #816af3;">
                    {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->name:""}}
                </span>
            </span>
            <i class="fa-solid fa-user-large" style="color: #816afe"></i>
            <i class="fa-solid fa-chevron-down" style="color: #816afe"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('usuario.perfil', ['id'=>Auth::user()->id]) }}">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Perfil
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>
</ul>
