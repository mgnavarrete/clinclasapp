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
        <h1 class="page-title fw-semibold fs-18 mb-0">Perfil de {{ $paciente->nombre }}</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    @php
        $coverImageNumber = rand(1, 6);
        $avatarImageNumber = $paciente->sexo === 'Mujer' ? rand(1, 8) : rand(9, 15);
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
                                <h6 class="fw-semibold  mb-3 text-fixed-white">{{ $paciente->nombre }} <span class="text-muted fs-14"></span></h6>
                                    <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#editPaciente">
                                        <i class="ri-pencil-line text-white"></i>
                                    </button>
                            </div>
                                
                                
       
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class="bx bx-id-card me-1 align-middle"></i> {{ $paciente->rut }}</span> 
                                <span><i class="ri-cake-2-line me-1 align-middle"></i> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d-m-Y') }}</span> 
                            </p>
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class=" ri-home-heart-line me-1 align-middle"></i>{{ $paciente->direccion }}</span> 
                        
                            </p>
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class=" ri-git-repository-line me-1 align-middle"></i>{{ $paciente->curso }}</span> 
                                <span><i class="ri-building-line me-1 align-middle"></i>{{ $paciente->colegio }}</span> 
                            </p>
                            
                        </div>
                    </div>
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap align-item-center  justify-content-between">
                                <p class="fs-15 mb-2 me-4 fw-semibold">Información Adicional:</p>
                            </div>
                            <p class="fs-12 text-muted op-7 mb-0">
                                {{ $paciente->info_adicional }}
                            </p>
                        </div>   
                    </div>  

                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center  justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Información Sesiones:</p>
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
                                        {{ ucfirst($sesion->dia_semana) }}
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-palette-line align-middle fs-14"></i>
                                        </span>
                                        Sesión {{ ucfirst($sesion->tipo) }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="ri-time-line align-middle fs-14"></i>
                                        </span>
                                        {{ date('H:i', strtotime($sesion->hora_inicio))}} a {{ date('H:i', strtotime($sesion->hora_fin))}}
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                            <i class="bx bx-money align-middle fs-14"></i>
                                            </span>
                                        ${{ number_format($sesion->valor, 0, ',', '.') }}
                                    </p>  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center  justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Información Apoderados:</p>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createTutor">Agregar</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="text-muted">
                            <div class="row">
                                @foreach ($apoderadosPaciente as $apoderado)
                                    <div class="col-md-6">
                                        <p class="mb-3">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="bx bx-user align-middle fs-14"></i>
                                            </span>
                                            {{ $apoderado->nombre }}
                                        </p>

                                        <p class="mb-3 d-flex align-items-center">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="ri-mail-line align-middle fs-14"></i>
                                            </span>
                                            <span class="text-truncate" style="max-width: 250px;">
                                                {{ \Illuminate\Support\Str::limit($apoderado->mail, 50, '...') }}
                                            </span>
                                        </p>
                                        <p class="mb-3">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="ri-phone-line align-middle fs-14"></i>
                                            </span>
                                            {{ $apoderado->telefono }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center  justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Información Especialistas:</p>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#asignarEspecialista">Agregar Especialista Existente</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createEspecialista">Agregar Nuevo Especialista</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="text-muted">
                            <div class="row">
                                
                                @if($especialistasPaciente->isEmpty())
                                <p class="mb-3">
                                    No tiene especialistas asignados.
                                </p>
                                @else
                                    @foreach ($especialistasPaciente as $especialista)
                                        <div class="col-md-6 mb-3 border-bottom border-block-end-dashed">
                                            <p class="mb-3">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="bx bx-user align-middle fs-14"></i>
                                                </span>
                                                {{ $especialista->nombre }}
                                            </p>

                                            <p class="mb-3">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-mail-line align-middle fs-14"></i>
                                                </span>
                                                {{ $especialista->mail }}
                                            </p>
                                            <p class="mb-3">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-phone-line align-middle fs-14"></i>
                                                </span>
                                                {{ $especialista->telefono }}
                                            </p>

                                            <p class="mb-3">
                                                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                    <i class="ri-briefcase-line align-middle fs-14"></i>
                                                </span>
                                                {{ $especialista->especialidad }}
                                            </p>
                                        </div>
                                    @endforeach
                                @endif
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
                                            class="ri-bill-line me-1 align-middle d-inline-block"></i>Sesiones de {{ ucfirst(\Carbon\Carbon::now()->translatedFormat('F')) }}</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reuniones-tab" data-bs-toggle="tab"
                                        data-bs-target="#reuniones-tab-pane" type="button" role="tab"
                                        aria-controls="reuniones-tab-pane" aria-selected="false"><i
                                            class="ri-briefcase-4-line me-1 align-middle d-inline-block"></i>Reuniones</button>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pagos-tab" data-bs-toggle="tab"
                                        data-bs-target="#pagos-tab-pane" type="button" role="tab"
                                        aria-controls="pagos-tab-pane" aria-selected="false"><i
                                            class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Pagos</button>
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
                                <div class="row d-flex align-items-stretch">
                                    @foreach ($estadoSesiones as $estado)
                                    @if (\Carbon\Carbon::parse($estado->fecha)->isCurrentMonth())
                                    
                                    <div class="col-md-6 d-flex">
                                        <div class="card custom-card flex-fill
                                            @if($estado->estado === 'realizada') task-completed-card
                                            @elseif($estado->estado === 'pendiente') task-pending-card
                                            @elseif($estado->estado === 'cancelada') task-inprogress-card
                                            @elseif($estado->estado === 'no avisó') task-inprogress-card
                                            @endif"
                                            data-bs-toggle="modal" data-bs-target="#editEstado{{ $estado->id_estado }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <p class="fw-semibold mb-3 d-flex align-items-center">
                                                            <a><i class="ri-bill-line fs-16 op-5 me-1 text-muted"></i></a>
                                                            {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($estado->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('F')) }} de {{ \Carbon\Carbon::parse($sesion->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesion->hora_final)->format('H:i') }}
                                                        </p>

                                                        <p class="mb-3">Estado Sesión: <span class="fs-12 mb-1 fw-semibold
                                                            @if($estado->estado === 'realizada') text-success 
                                                            @elseif($estado->estado === 'pendiente') text-secondary
                                                            @elseif($estado->estado === 'cancelada') text-danger
                                                            @elseif($estado->estado === 'no avisó') text-warning
                                                            @endif">
                                                              {{ ucfirst($estado->estado) }}
                                                        </span>
                                                        </p>                                                    
                                                        
                                                        <p class="mb-0">Notas : 
                                                            <span class="fs-12 mb-1 text-muted">{{ empty($estado->notas) ? 'No hay notas todavía.' : $estado->notas }}</span>
                                                        </p>
                                                    </div>                                            
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                  
                                </div>
                                
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="reuniones-tab-pane"
                                role="tabpanel" aria-labelledby="reuniones-tab" tabindex="0">
                                <div class="row d-flex align-items-stretch" style="overflow-x: auto; white-space: nowrap;">
                                    @foreach ($reuniones as $reunion)
                                    
                                    <div class="col-md-6 d-flex">
                                        <div class="card custom-card flex-fill
                                            @if($reunion->estado === 'realizada') task-completed-card
                                            @elseif($reunion->estado === 'pendiente') task-pending-card
                                            @elseif($reunion->estado === 'cancelada') task-inprogress-card
                                            @endif"
                                            data-bs-toggle="modal" data-bs-target="#editReunion{{ $reunion->id_reunion }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <p class="fw-semibold mb-3 d-flex align-items-center">
                                                            <a><i class="ri-briefcase-4-fill fs-16 op-5 me-1 text-muted"></i></a>
                                                            {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($reunion->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('F')) }} de {{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($reunion->hora_final)->format('H:i') }}
                                                        </p>

                                                        <p class="mb-3">Estado Reunión: <span class="fs-12 mb-1 fw-semibold
                                                            @if($reunion->estado === 'realizada') text-success 
                                                            @elseif($reunion->estado === 'pendiente') text-secondary
                                                            @elseif($reunion->estado === 'cancelada') text-danger
                                                            @endif">
                                                              {{ ucfirst($reunion->estado) }}
                                                        </span>
                                                        </p>                                                    
                                                        
                                                        <p class="mb-0">Valor : 
                                                            <span class="fs-12 mb-1 text-muted">${{ number_format($reunion->valor, 0, ',', '.') }}</span>
                                                        </p>
                                                    </div>                                            
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                  
                                    @endforeach
                                  
                                </div>
                            
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="pagos-tab-pane"
                                role="tabpanel" aria-labelledby="pagos-tab" tabindex="0">
                                <div class="row d-flex align-items-stretch">
                                    @foreach ($pagosPaciente as $pago)
                                            <div class="col-md-6 d-flex">
                                                <a href="{{ route('pagos.show', $pago->id_pago) }}" class="card custom-card flex-fill
                                                    @if($pago->estado === 'atrasado') task-pending-card
                                                    @elseif($pago->estado === 'pendiente') task-pending-card
                                                    @elseif($pago->estado === 'pagado') task-completed-card
                                                    @endif">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                                            <div>
                                                                <p class="fw-semibold mb-3 d-flex align-items-center">
                                                                    <i class="ri-money-dollar-box-fill fs-16 op-5 me-1 text-muted"></i>
                                                                    {{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }} - {{ $pago->paciente->nombre }}
                                                                </p>
                                                                <p class="mb-2">Valor Total :
                                                                    <span class="fs-12 mb-1 text-muted">{{ '$' . number_format($pago->valor_total, 0, ',', '.') }}</span>
                                                                </p>
                                                                <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold
                                                                    @if($pago->estado === 'atrasado') text-warning
                                                                    @elseif($pago->estado === 'pendiente') text-secondary
                                                                    @elseif($pago->estado === 'pagado') text-success
                                                                    @endif">
                                                                      {{ ucfirst($pago->estado) }}
                                                                </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                    @endforeach
                                </div>
                            
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="sesionesPasadas-tab-pane"
                                role="tabpanel" aria-labelledby="sesionesPasadas-tab" tabindex="0">
                                <div class="row d-flex align-items-stretch" style="overflow-x: auto; white-space: nowrap;">
                                    @foreach ($estadoSesiones as $estado)
                                    @if (!\Carbon\Carbon::parse($estado->fecha)->isCurrentMonth())
                                    
                                    <div class="col-md-6 d-flex">
                                        <div class="card custom-card flex-fill
                                            @if($estado->estado === 'realizada') task-completed-card
                                            @elseif($estado->estado === 'pendiente') task-pending-card
                                            @elseif($estado->estado === 'cancelada') task-inprogress-card
                                            @elseif($estado->estado === 'no avisó') task-inprogress-card
                                            @endif"
                                            data-bs-toggle="modal" data-bs-target="#editEstado{{ $estado->id_estado }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <p class="fw-semibold mb-3 d-flex align-items-center">
                                                            <a><i class="ri-attachment-line fs-16 op-5 me-1 text-muted"></i></a>
                                                            {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($estado->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('F')) }} de {{ \Carbon\Carbon::parse($sesion->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesion->hora_final)->format('H:i') }}
                                                        </p>

                                                        <p class="mb-3">Estado Sesión: <span class="fs-12 mb-1 fw-semibold
                                                            @if($estado->estado === 'realizada') text-success 
                                                            @elseif($estado->estado === 'pendiente') text-secondary
                                                            @elseif($estado->estado === 'cancelada') text-danger
                                                            @elseif($estado->estado === 'no avisó') text-warning
                                                            @endif">
                                                              {{ ucfirst($estado->estado) }}
                                                        </span>
                                                        </p>                                                    
                                                        
                                                        <p class="mb-0">Notas : 
                                                            <span class="fs-12 mb-1 text-muted">{{ empty($estado->notas) ? 'No hay notas todavía.' : $estado->notas }}</span>
                                                        </p>
                                                    </div>                                            
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                  
                                </div>
                            
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

</div>
{{-- Mostrar mensaje de éxito --}}
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
<!-- Modals de Edicion, Creacion y Asignacion -->
@include('pages.modals.editSesion')
@include('pages.modals.createEspecialista')
@include('pages.modals.asignarEspecialista')
@include('pages.modals.createTutor')
@include('pages.modals.editTutor')
@include('pages.modals.editPaciente')
@include('pages.modals.editEstado')
@include('pages.modals.agendarReunion')
@include('pages.modals.editReunion')
@include('pages.modals.agendarSesion')
@include('pages.modals.editPagoPac')

@endsection

@section('scripts')

        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#humanfrienndlydate", {
            locale: "es",
        });
    });

            function formatRUT(input) {
                let value = input.value.replace(/\./g, '').replace('-', '');
                if (value.length > 1) {
                    value = value.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + value.slice(-1);
                }
                input.value = value;
            }
        
            function formatCurrency(input) {
                let value = input.value.replace(/\D/g, '');
                input.value = value;
            }
        
            function addPrefix(input) {
                if (!input.value.startsWith('+569')) {
                    input.value = '+569' + input.value.replace(/^\+569/, '');
                }
            }
        
            function addPrefixToPlaceholder(input) {
                if (input.placeholder !== '+569') {
                    input.placeholder = '+569';
                }
            }
        </script>   

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const editPacienteModal = document.getElementById('editPaciente');
                editPacienteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const paciente = @json($paciente);

                    // Asignar valores a los campos del modal
                    document.getElementById('nombre').value = paciente.nombre;
                    document.getElementById('humanfrienndlydate').value = new Date(paciente.fecha_nacimiento).toISOString().split('T')[0];
                    document.getElementById('curso').value = paciente.curso;
                    document.getElementById('colegio').value = paciente.colegio;
                    document.getElementById('rut').value = paciente.rut;
                    document.getElementById('sexo').value = paciente.sexo;
                    document.getElementById('direccion').value = paciente.direccion;
                    document.getElementById('info_adicional').value = paciente.info_adicional;
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const editSesionModal = document.getElementById('editSesion');
                editSesionModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const sesion = @json($sesion);
                    document.getElementById('dia_semana').value = sesion.dia_semana;
                    document.getElementById('timepickr1').value = new Date('1970-01-01T' + sesion.hora).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    document.getElementById('tipo').value = sesion.tipo;
                    document.getElementById('valor').value = sesion.valor.split('.')[0];
                });
            });
            


           
        </script>
@endsection
