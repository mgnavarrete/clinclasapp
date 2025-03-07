@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="path/to/flatpickr/l10n/es.js"></script>
<link rel="stylesheet" href="{{asset('build/assets/libs/glightbox/css/glightbox.min.css')}}">       
@vite('resources/assets/js/date&time_pickers.js')
<!-- INTERNAL PROFILE JS -->
@vite('resources/assets/js/profile.js')
    
@endsection

@section('content')
@php
    \Carbon\Carbon::setLocale('es');

@endphp
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Perfil de {{ $user->name }}</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    @php
        $coverImageNumber = rand(1, 6);
        $avatarImageNumber =  rand(1, 15);
    @endphp
  
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-5 d-flex">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                        <div>
                            <span class="avatar avatar-xxl avatar-rounded online me-3">
                                <img src="https://laravelui.spruko.com/ynex/build/assets/images/faces/{{ $avatarImageNumber }}.jpg" alt="">
                            </span>

                            
                        </div>
                        <div class="flex-fill main-profile-info">
                    
                            <div class="d-flex flex-wrap align-item-center  justify-content-between mt-3">
                                <h6 class="fw-semibold  mb-3 text-fixed-white">{{ $user->name }} <span class="text-muted fs-14"></span></h6>
                                    <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#editPaciente">
                                        <i class="ri-pencil-line text-white"></i>
                                    </button>
                            </div>
                                
                                
       
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class="bx bx-id-card me-1 align-middle"></i> {{ $user->email}}</span> 
                            </p>
                         
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span><i class="ri-building-line me-1 align-middle"></i>{{ $user->empresa }}</span> 
                            </p>
                            
                        </div>
                    </div>

                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center  justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Información Alumnos:</p>
                            {{-- <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#editSesion">
                                <i class="ri-pencil-line"></i>
                            </button> --}}
                        </div>
                        <div class="text-muted">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-calendar-check-fill align-middle fs-14"></i>
                                        </span>
                                        x Alumnos
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-palette-line align-middle fs-14"></i>
                                        </span>
                                    4 clases semanales
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-time-line align-middle fs-14"></i>
                                        </span>
                                        todos los dias
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="bx bx-money align-middle fs-14"></i>
                                            </span>
                                        $30.000
                                    </p>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 d-flex">
            <div class="card custom-card" style="background-color: transparent;">
                <div class="card-body p-0">
                    <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                        <div>
                            <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="sesionesMes-tab" data-bs-toggle="tab"
                                        data-bs-target="#sesionesMes-tab-pane" type="button" role="tab"
                                        aria-controls="sesionesMes-tab-pane" aria-selected="true"><i
                                            class="ri-bill-line me-1 align-middle d-inline-block"></i>Horarios de Clases</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reuniones-tab" data-bs-toggle="tab"
                                        data-bs-target="#reuniones-tab-pane" type="button" role="tab"
                                        aria-controls="reuniones-tab-pane" aria-selected="false"><i
                                            class="ri-briefcase-4-line me-1 align-middle d-inline-block"></i>Información Clases</button>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pagos-tab" data-bs-toggle="tab"
                                        data-bs-target="#pagos-tab-pane" type="button" role="tab"
                                        aria-controls="pagos-tab-pane" aria-selected="false"><i
                                            class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Configuración</button>
                                </li>
                                



                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="sesionesPasadas-tab" data-bs-toggle="tab"
                                        data-bs-target="#sesionesPasadas-tab-pane" type="button" role="tab"
                                        aria-controls="sesionesPasadas-tab-pane" aria-selected="false"><i
                                            class="ri-attachment-line me-1 align-middle d-inline-block"></i>Sesiones Pasadas</button>
                                </li>

                            </ul>
                        </div>   
                        <div>
                            <div class="dropdown ms-2">
                                <button class="btn btn-light btn-wave waves-effect waves-light px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-18"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#agendarReunion">Agendar Reunión</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#agendarSesion">Agendar Sesión</a></li>
        
                                </ul>
                            </div>
                        </div> 
                    </div>
                    <div class="p-3">
                        <div class="tab-content h-100 w-100" id="myTabContent">
                            <div class="tab-pane show active fade p-0 border-0 h-100" id="sesionesMes-tab-pane"
                                role="tabpanel" aria-labelledby="sesionesMes-tab" tabindex="0">
                                
                                
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="reuniones-tab-pane"
                                role="tabpanel" aria-labelledby="reuniones-tab" tabindex="0">
                               
                            
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="pagos-tab-pane"
                                role="tabpanel" aria-labelledby="pagos-tab" tabindex="0">
                                
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="sesionesPasadas-tab-pane"
                                role="tabpanel" aria-labelledby="sesionesPasadas-tab" tabindex="0">
                                
                            
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

</div>
Mostrar mensaje de éxito
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

{{-- Mostrar mensaje de error --}}
@if($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif


@endsection

@section('scripts')

        <!-- JSVECTOR MAPS JS -->
        <script src="{{asset('build/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
        <script src="{{asset('build/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

        <!-- APEX CHARTS JS -->
        <script src="{{asset('build/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- CHARTJS CHART JS -->
        <script src="{{asset('build/assets/libs/chart.js/chart.min.js')}}"></script>

        <!-- CRM-Dashboard -->
        @vite('resources/assets/js/crm-dashboard.js')

    
@endsection
