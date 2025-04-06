@extends('layouts.master')

@section('styles')
      
@endsection

@section('content')

@php
    \Carbon\Carbon::setLocale('es');
    

@endphp
<script>
    // Convertir la variable PHP a JSON para evitar problemas de sintaxis
    console.log('id del usuario', @auth{{Auth::user()->id}}@endauth);
    const estadoSesionesRealizadas = @json($estadoSesionesRealizadasMesActual);
    console.log('Estado Sesiones Realizadas', estadoSesionesRealizadas);
</script>
<div class="container-fluid">

<!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">¡Hola 👋, @auth{{Auth::user()->name}}@endauth!</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Resumen</li>
                </ol>
            </nav>
        </div>
    </div>
<!-- Page Header Close -->

    <div class="row d-flex align-items-stretch">
        <!-- Total de Pacientes -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">Total Alumnos</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">{{ $totalPacientes }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            {{-- <a href="{{ route('pacientes.index') }}" class="fs-12 mb-0 text-secondary">Ver Alumnos<i class="ti ti-chevron-right ms-1"></i></a> --}}
                        </div>
                        <div class="col-6">
                            @php
                                $diferenciaPacientes = $sesionesPendientes;
                                $iconoPacientes = $diferenciaPacientes >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPacientes = $diferenciaPacientes >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPacientes }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPacientes }} me-1"></i>{{ $sesionesPendientes }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-primary">
                                <i class="ti ti-users fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ganado Mes Actual -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                            <span class="fs-14">Ingresos</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">${{ number_format($totalGanadoMesActual, 0, ',', '.') }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            {{-- <a href="/" class="fs-12 mb-0 text-secondary">Ver Ingresos<i class="ti ti-chevron-right ms-1"></i></a> --}}
                        </div>
                        <div class="col-6">
                            @php
                                $diferenciaPagos = $totalGanadoMesActual - $totalGanadoMesPasado;
                                $iconoPagos = $diferenciaPagos >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPagos = $diferenciaPagos >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPagos }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPagos }} me-1"></i>
                                ${{ number_format(abs($diferenciaPagos), 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-success">
                                <i class="ti ti-coin fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagos Pendientes -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">No Pagados</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">{{ $pagosPendientes->count() }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            {{-- <a href="{{ route('pagos.index') }}" class="fs-12 mb-0 text-secondary">Ver Pendientes<i class="ti ti-chevron-right ms-1"></i></a> --}}
                        </div>
                        <div class="col-6">
                            @php
                                $diferenciaPendientes = $pagosPendientes->sum(function ($pago) {
                                    return $pago->valor_total;
                                });
                                $iconoPendientes = $diferenciaPendientes <= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPendientes = $diferenciaPendientes <= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPendientes }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPendientes }} me-1"></i>${{ number_format($diferenciaPendientes, 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-warning">
                                <i class="ti ti-coin-off fs-16"></i> 
                            </span> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ganado Mes Pasado -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">Pagos Pasados</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">${{ number_format($totalGanadoMesPasado, 0, ',', '.') }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Mes Pasado</span>
                            </p>
                            {{-- <a href="{{ route('pagos.index') }}" class="fs-12 mb-0 text-secondary">Ver Pagos<i class="ti ti-chevron-right ms-1"></i></a> --}}
                        </div>
                        <div class="col-6">
                            @php
                                $diferenciaPagos = $diferenciaIngresos;
                                $iconoPagos = $diferenciaPagos >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPagos = $diferenciaPagos >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPagos }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPagos }} me-1"></i>
                                ${{ number_format(abs($diferenciaPagos), 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-secondary">
                                <i class="ti ti-wallet fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    {{-- <div class="row d-flex align-items-stretch">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Gráfica de Ingresos:</div>
                </div>
                <div class="card-body">
      </div>
            </div>
        </div>
        <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Gráfica de Pagos</div>
                    
                    </div>
                    <div class="card-body">
                      
                    </div>
                </div>
        </div>
    </div> --}}
  
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card custom-card flex-fill timeline-container">
                    <div class="card-header d-flex justify-content-between">
                        <p class="card-title fw-semibold fs-18 mb-0">Próximos Eventos</p>
                    </div>
                    <div class="card-body p-0" style="height: 600px; overflow-y: auto;">
                        @php
                            $horaActual = \Carbon\Carbon::now();

                            if (empty($proximasSesiones) && empty($proximasReuniones)) {
                                $eventos = collect([]);
                            } else {
                                // Combinar sesiones y reuniones
                                $sesionesArray = is_array($proximasSesiones) ? collect($proximasSesiones) : $proximasSesiones;
                                $reunionesArray = is_array($proximasReuniones) ? collect($proximasReuniones) : $proximasReuniones;
                                
                                $eventos = $sesionesArray->map(function($sesion) {
                                    return [
                                        'id' => $sesion->id_estado,
                                        'tipo' => 'sesion',
                                        'modal' => 'editEstado',
                                        'fecha' => $sesion->fecha,
                                        'hora_inicio' => $sesion->hora_inicio,
                                        'estado' => $sesion->estado,
                                        'paciente' => isset($sesion->sesion) && isset($sesion->sesion->paciente) ? $sesion->sesion->paciente : null
                                    ];
                                })->merge($reunionesArray->map(function($reunion) {
                                    return [
                                        'id' => $reunion->id_reunion,
                                        'tipo' => 'reunion',
                                        'modal' => 'editReunion',
                                        'fecha' => $reunion->fecha,
                                        'hora_inicio' => $reunion->hora_inicio,
                                        'estado' => $reunion->estado,
                                        'paciente' => isset($reunion->paciente) ? $reunion->paciente : null
                                    ];
                                }))->sortBy(function($evento) {
                                    return \Carbon\Carbon::parse($evento['fecha'] . ' ' . $evento['hora_inicio']);
                                });

                                $eventoMasProximo = $eventos->firstWhere(function($evento) use ($horaActual) {
                                    return \Carbon\Carbon::parse($evento['fecha'])->isToday() && \Carbon\Carbon::parse($evento['hora_inicio'])->greaterThanOrEqualTo($horaActual);
                                });

                                if (!$eventoMasProximo) {
                                    $eventoMasProximo = $eventos->firstWhere(function($evento) {
                                        return \Carbon\Carbon::parse($evento['fecha'])->isTomorrow();
                                    });
                                }
                            }
                        @endphp

                        <ul class="timeline list-unstyled mb-5">
                            @if($eventos->isEmpty())
                                <li>
                                    <div class="text-center">
                                        <div class="alert alert-warning text-center mb-3 ms-3 me-3" role="alert">
                                            No hay eventos agendados para esta semana
                                        </div>
                                    </div>
                                </li>
                            @else
                                @foreach($eventos as $evento)
                                    <li>
                                        <div class="timeline-time text-end">
                                            <span class="date">
                                                @php
                                                    $fechaEvento = \Carbon\Carbon::parse($evento['fecha']);
                                                @endphp
                                                {{ $fechaEvento->isToday() ? 'Hoy' : ucfirst($fechaEvento->translatedFormat('l')) }}
                                            </span>
                                            <span class="time d-inline-block">{{ \Carbon\Carbon::parse($evento['hora_inicio'])->format('H:i') }}</span>
                                        </div>
                                        <div class="timeline-icon"></div>
                                        <div class="timeline-body {{ isset($eventoMasProximo) && $evento['id'] === $eventoMasProximo['id'] && $evento['tipo'] === $eventoMasProximo['tipo'] ? 'bg-outline-success' : 'bg-outline-primary' }}">
                                            <a href="javascript:void(0);" data-bs-target="#{{ $evento['modal'] }}{{ $evento['id'] }}" data-bs-toggle="modal">
                                                <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                                                    <div class="avatar avatar-md online me-3 avatar-rounded mt-sm-0 mt-4">
                                                        @php
                                                            $numeroAleatorio = isset($evento['paciente']) && $evento['paciente']->sexo === 'Mujer' ? rand(1, 8) : rand(9, 15);
                                                        @endphp
                                                        <img alt="avatar" src="https://laravelui.spruko.com/ynex/build/assets/images/faces/{{ $numeroAleatorio }}.jpg">
                                                    </div>
                                                    <div class="flex-fill">
                                                        <div class="d-flex align-items-center">
                                                            <div class="mt-sm-0 mt-2">
                                                                <p class="mb-0 fs-14 fw-semibold">{{ $evento['paciente']->nombre }}</p>
                                                                <p class="mb-0 text-muted">{{ ucfirst($evento['tipo']) }}</p>
                                                            </div>
                                                            <div class="ms-auto">
                                                                @php
                                                                    $colorEstado = match(strtolower($evento['estado'])) {
                                                                        'pendiente' => 'bg-warning',
                                                                        'cancelada' => 'bg-danger',
                                                                        'realizada' => 'bg-success',
                                                                        default => 'bg-light text-muted'
                                                                    };
                                                                @endphp
                                                                <span class="float-end badge {{ $colorEstado }} timeline-badge mt-0 mt-sm-0">
                                                                    {{ ucfirst($evento['estado']) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card custom-card flex-fill" >
                    <div class="card-header d-flex justify-content-between">
                        <p class="card-title fw-semibold fs-18 mb-0">Pagos Pendientes</p>
                    </div>
                    <div class="card-body" style="height: 600px; overflow-y: auto;">
                        
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Fecha de Pago</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pagosPendientes as $pago)
                                    @php
                                        $apoderadosPaciente = $apoderados->where('id_paciente', $pago->id_paciente);
                                    @endphp
                                    <tr>
                                        <td>{{ $pago->paciente->nombre }}</td>
                                        <td>{{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }}</td>
                                        <td>{{ ucfirst($pago->estado) }}</td>
                                        <td>${{ number_format($pago->valor_total, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="alert alert-warning text-center mb-3 ms-1 me-1" role="alert">
                                            No tienes alumnos con pagos pendientes
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- Mostrar mensaje de éxito --}}
{{-- @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif --}}

{{-- Mostrar mensaje de error --}}
@if($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif
@include('pages.modals.editEstadoIdx')
@include('pages.modals.editReunionIdx')
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