@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('build/assets/libs/flatpickr/l10n/es.js')}}"></script>
@vite('resources/assets/js/date&time_pickers.js')

<!-- FULL CALENDAR CSS -->
<link rel="stylesheet" href="{{asset('build/assets/libs/fullcalendar/main.min.css')}}">
<style>
    .fc-event {
        cursor: pointer;
    }
</style>
@endsection


@section('content')

@php
    \Carbon\Carbon::setLocale('es');

@endphp

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Calendario</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Calendario</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-header d-grid">
                    <div class="dropdown ms-2">
                        <button class="btn btn-light btn-wave waves-effect waves-light px-2 w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-add-line align-middle me-1 fw-semibold d-inline-block fs-18"></i>Agendar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#agendarReunion">Agendar Reunión</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#agendarSesion">Agendar Sesión</a></li>

                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="external-events" class="border-bottom p-3">
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event"
                          style="background-color: #0000ff; border-color: #0000ff; cursor: pointer;"
                          data-class="bg-info">
                          <div class="fc-event-main">📓 Sesiones</div>
                        </div>
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event"
                            style="background-color: #6f42c1; border-color: #6f42c1; cursor: pointer;"
                            data-class="bg-danger">
                            <div class="fc-event-main">📋 Reuniones</div>
                        </div>
                        
                        <div
                          class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event"
                          style="background-color: #00c0ef; border-color: #00c0ef; cursor: pointer;"
                          data-class="bg-warning">
                          <div class="fc-event-main">🎂 Cumpleaños</div>
                        </div>
                    </div>
                    
                    <div class="p-3">
                      <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold">
                          Próximos Eventos
                        </h6>
                       
                      </div>
                    </div>
                    <div class="p-3 border-bottom" id="full-calendar-activity">
                      <ul class="list-unstyled mb-0 fullcalendar-events-activity">
                        @php
                            $eventos = collect();

                            foreach ($proximasSesiones as $sesion) {
                                if (\Carbon\Carbon::parse($sesion->fecha)->isToday() || \Carbon\Carbon::parse($sesion->fecha)->isFuture()) {
                                    $eventos->push([
                                        'tipo' => 'sesión',
                                        'nombre' => $sesion->sesion->paciente->nombre,
                                        'fecha' => $sesion->fecha,
                                        'hora_inicio' => $sesion->hora_inicio,
                                        'hora_fin' => $sesion->hora_fin
                                    ]);
                                }
                            }

                            foreach ($proximasReuniones as $reunion) {
                                if (\Carbon\Carbon::parse($reunion->fecha)->isToday() || \Carbon\Carbon::parse($reunion->fecha)->isFuture()) {
                                    $eventos->push([
                                        'tipo' => 'reunión',
                                        'nombre' => $reunion->paciente->nombre,
                                        'fecha' => $reunion->fecha,
                                        'hora_inicio' => $reunion->hora_inicio,
                                        'hora_fin' => $reunion->hora_fin
                                    ]);
                                }
                            }

                            $eventos = $eventos->sortBy(function($evento) {
                                return \Carbon\Carbon::parse($evento['fecha'] . ' ' . $evento['hora_inicio']);
                            });
                        @endphp

                        @foreach ($eventos as $evento)
                            <li>
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <p class="mb-1 fw-semibold">
                                      {{ ucfirst($evento['tipo']) }}: {{ $evento['nombre'] }}
                                    </p>
                                    <span class="badge bg-light text-default mb-1">
                                        {{ \Carbon\Carbon::parse($evento['hora_inicio'])->format('H:i') }} - {{ \Carbon\Carbon::parse($evento['hora_fin'])->format('H:i') }}
                                    </span>
                                </div>
                                <p class="mb-0 text-muted fs-12">
                                    {{ ucfirst(\Carbon\Carbon::parse($evento['fecha'])->translatedFormat('l j \d\e F') ) }}
                                </p>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="p-3">
                      <img src="{{asset('build/assets/images/media/media-83.svg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Calendario</div>
                </div>
                <div class="card-body">
                    <div id='calendar2'></div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
  </div>
  @include('pages.modals.editReunionCal')
  @include('pages.modals.editEstadoCal')
@endsection

@section('scripts')

<!-- MOMENT JS -->
<script src="{{asset('build/assets/libs/moment/moment.js')}}"></script>

<!-- FULLCALENDAR JS -->
<script src="{{asset('build/assets/libs/fullcalendar/main.min.js')}}"></script>
@vite('resources/assets/js/fullcalendar.js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            firstDay: 1,
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            slotMinTime: '08:00:00',
            slotMaxTime: '19:00:00',
            slotDuration: '00:15:00',
            slotLabelInterval: '01:00',
            displayEventTime: false,
            titleFormat: {
                month: 'long',
                year: 'numeric'
            },
            events: [
                @foreach($estadoSesiones as $sesion)
                {
                    title: '📓 {{ \Carbon\Carbon::parse($sesion->hora_inicio)->format('H:i') }}: {{ $sesion->sesion->paciente->nombre }}',
                    start: '{{ $sesion->fecha }}T{{ $sesion->hora_inicio }}',
                    end: '{{ $sesion->fecha }}T{{ $sesion->hora_final }}',
                    color: '{{ $sesion->estado == "cancelada" || $sesion->estado == "no avisó" ? "#ff0000" : ($sesion->estado == "realizada" ? "#28a745" : "#007bff") }}',
                    display: 'block',
                    id: '{{ $sesion->id_estado }}',
                    tipo: 'sesion'
                    
                },
                @endforeach
                @foreach($reuniones as $reunion)
                {
                    title: '📋{{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i') }}: {{ $reunion->paciente->nombre }}',
                    start: '{{ $reunion->fecha }}T{{ $reunion->hora_inicio }}',
                    end: '{{ $reunion->fecha }}T{{ $reunion->hora_fin }}',
                    color: '{{ $reunion->estado == "cancelada" ? "#ff0000" : ($reunion->estado == "realizada" ? "#28a745" : "#6f42c1") }}',
                    display: 'block',
                    id: '{{ $reunion->id_reunion }}',
                    tipo: 'reunion'
                },
                @endforeach
                @foreach($pacientes  as $paciente)
                {
                    title: '🎂 {{ $paciente->nombre }}',
                    start: '{{ $paciente->fecha_nacimiento }}',
                    color: '#00c0ef',
                    display: 'block'
                },
                @endforeach
            ],
            eventClick: function(info) {
                if (info.event.extendedProps.tipo === 'reunion') {
                    var modalIdCal = '#editReunion' + info.event.id;
                    var modalCal = new bootstrap.Modal(document.querySelector(modalIdCal));
                    modalCal.show();
                } else if (info.event.extendedProps.tipo === 'sesion') {
                    var modalIdEstado = '#editEstado' + info.event.id;
                    var modalEstado = new bootstrap.Modal(document.querySelector(modalIdEstado));
                    modalEstado.show();
                }
            } 
        });
        calendar.render();
    });
</script>
@include('pages.modals.agendarReunionCal')
@include('pages.modals.agendarSesionCal')
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