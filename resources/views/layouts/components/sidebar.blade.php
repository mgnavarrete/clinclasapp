<!--style>
    .app-sidebar {
        background-color: #ccd5ae;
    }
</style-->

<aside class="app-sidebar sticky" id="sidebar" >

<!-- Start::main-sidebar-header -->
<div class="main-sidebar-header">
    <a href="{{url('index')}}" class="header-logo">
        <!--img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="adentu-sidebar"-->
        <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="desktop-logo">
        <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="toggle-logo">
        <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="desktop-dark">
        <img src="{{asset('build/assets/images/brand-logos/toggle-dark.png')}}" alt="logo" class="toggle-dark">
        <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" alt="logo" class="desktop-white">
        <img src="{{asset('build/assets/images/brand-logos/toggle-white.png')}}" alt="logo" class="toggle-white">
    </a>
</div>
<!-- End::main-sidebar-header -->

<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open " >
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://solar.adentu.cloud/images/logo_xs_nb.png" fill="#A1DD70" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Menu principal</span></li>
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide" >
                <a href="{{url('index')}}" class="side-menu__item">
                    <i class="bx bx-home side-menu__icon"></i>
                    <span class="side-menu__label">Inicio</span>
                </a>

                <a href="{{route('pacientes.index')}}" class="side-menu__item">
                    <i class="ti ti-users side-menu__icon"></i>
                    <span class="side-menu__label">Alumnos</span>
                </a>
                
                <!-- Calendario -->
                <a href="{{route('calendario.index')}}" class="side-menu__item">
                    <i class="bx bx-calendar side-menu__icon"></i>
                    <span class="side-menu__label">Calendario</span>
                </a>


                <!-- pagos -->
                <a href="{{route('pagos.index')}}" class="side-menu__item">
                    <i class="bx bx-money side-menu__icon"></i>
                    <span class="side-menu__label">Pagos</span>
                </a>



            </li>
            <!-- End::slide -->

    




        </ul>
       
    </nav>
    <!-- End::nav -->

</div>
<!-- End::main-sidebar -->

</aside>