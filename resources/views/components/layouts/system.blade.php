<!DOCTYPE html>
<html lang="es">
<head>
    <x-layouts.head
        title="{{$title2 ?? ''}}">
    </x-layouts.head>
    @yield('css_tagsinput')
    @yield('js_chart')
</head>
<body id="page-top">
    <div id="wrapper">
        <x-layouts.nav-trab/>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h1 class="h3 mb-0 text-gray-800">{{$iname ?? ''}}</h1>
                    <x-layouts.user-menu/>
                </nav>
                {{$slot}}
            </div>
            <x-layouts.footer/>
        </div>
    </div>
<x-layouts.modal/>
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
@yield('js_tagsinput')
@yield('js_addToPlantilla')
</body>
</html>
