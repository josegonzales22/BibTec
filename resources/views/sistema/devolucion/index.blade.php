<x-layouts.system
title2="Devolucion"
iname="Devolucion">
<style>.d-icons{font-size:40px;color:whitesmoke;}</style>
<main class="container-fluid">
    <div class="card shadow ">
        <div class="card-body">
            @if(session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (app(App\Http\Controllers\DevolucionController::class)->checkTableDevolucionIsNotEmpty())

            @else
                <x-layouts.empty/>
                <div class="col-12 text-center mt-2">
                    <a href="" class="btn btn-a">
                        {{app(App\Http\Controllers\DevolucionController::class)->verCantBaulPres(Auth::user()->id)}}
                        <i class="fa-solid fa-box-archive"></i>
                    </a>
                    <a href="" class="btn btn-a">
                        <i class="fa-solid fa-qrcode"></i> Escáner
                    </a>
                </div>
            @endif
        </div>
    </div>
</main>
</x-layouts.system>
