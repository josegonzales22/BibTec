<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Seguro que desea salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "salir" para cerrar la sesión actual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary"  href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                style="background-color: #816af3" >Salir</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="footerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Herramientas/Bibliotecas utilizadas</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <a class="text-body" href="https://startbootstrap.com/theme/sb-admin-2" target="_blank" style="text-decoration: none;">
                    <img src="https://startbootstrap.com/assets/img/sb-logo.svg" width="30px">
                     Start Bootstrap
                </a><br><br>
                <a class="text-body" href="https://github.com/PHPMailer/PHPMailer" target="_blank" style="text-decoration: none;">
                    <img src="https://avatars.githubusercontent.com/u/3959702?s=48&v=4" width="30px">
                     PHPMailer
                </a><br><br>
                <a class="text-body" href="https://phpqrcode.sourceforge.net/" target="_blank" style="text-decoration: none;">
                    <i class="fa-solid fa-qrcode fa-2xl"></i>
                     PHP QR Code
                </a><br><br>
                <a class="text-body" href="https://fontawesome.com/" target="_blank" style="text-decoration: none;">
                    <i class="fa-solid fa-font-awesome fa-2xl"></i>
                     Font Awesome
                </a><br><br>
                <a class="text-body" href="https://lottiefiles.com/" target="_blank" style="text-decoration: none;">
                    <img src="https://media.licdn.com/dms/image/C4E0BAQFu04wPVBDhVg/company-logo_200_200/0/1651486022084/lottiefiles_logo?e=2147483647&v=beta&t=JzBgj9pH9nv3GLv_6Fg_x_OQlktSxP8d4W16xSTaub4" width="30px">
                     LottieFiles
                </a><br><br>
                <a class="text-body" href="https://bgjar.com" target="_blank" style="text-decoration: none;">
                    <img src="https://bgjar.com/bgjar.svg" width="30px">
                     BGJar
                </a><br><br>
                <a class="text-body" href="https://ngrok.com/" target="_blank" style="text-decoration: none;">
                    <img src="https://assets-global.website-files.com/63ed4bc7a4b189da942a6b8c/63ef861b114f2bbd3e038582_Untitled%20design%20(3).svg" width="30px">
                     ngrok
                </a><br><br>
            </div>
        </div>
    </div>
</div>
