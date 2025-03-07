@extends('layouts.master')

@section('content')
@php
\Carbon\Carbon::setLocale('es');
@endphp


                <div class="container-fluid">

                    <!-- Page Header -->
                    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                        <h1 class="page-title fw-semibold fs-18 mb-0">Pago de {{ $pago->paciente->nombre }} - Mes de {{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }}</h1>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('pagos.index') }}">Pagos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detalles del Pago</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Page Header Close -->

                    <!-- Start::row-1 -->
                    <div class="row">
                        <div class="">
                            <div class="card custom-card">
                                <div class="card-header d-md-flex d-block">
                                    <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                                        <div class="avatar avatar-sm me-2 ms-1">
                                            <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" style="width: 50px; height: 100%;" alt="">
                                        </div>
                                        <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                        <div class="h6 fw-semibold mb-0">DETALLES DEL PAGO : <span class="text-primary"></span></div>
                                        </div>
                                    </div>
                                    <div class="ms-auto mt-md-0 mt-2">

                                        <button class="btn btn-success" onclick="window.open('{{ route('pdf.pago', $pago->id_pago) }}', '_blank')">
                                            Descargar <i class="ri-download-2-line ms-1 align-middle"></i>
                                        </button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPago{{ $pago->id_pago }}">Editar Estado<i class="ri-edit-line ms-1 align-middle"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                                    <p class="text-muted mb-2">
                                                        Datos Alumno :
                                                    </p>
                                                    <p class="fw-bold mb-1">
                                                        {{strtoupper($pago->paciente->nombre)}}
                                                    </p>
                                                    <p class="mb-1">
                                                        {{$pago->paciente->rut}}
                                                        
                                                    </p>
                                                    <p class="mb-1">
                                                        {{$pago->paciente->direccion}}
                                                    </p>
                                                    <p class="mb-1">
                                                        {{ \Carbon\Carbon::parse($pago->paciente->fecha_nacimiento)->format('d/m/Y') }}
                                                    </p>
                                                    <p class="mb-1">
                                                        {{$pago->paciente->curso}}, {{$pago->paciente->colegio}}
                                                    </p>
                                                    
                                                </div>
                                                @foreach ($apoderados as $apoderado)
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
                                                    @if ($loop->first)
                                                    <p class="text-muted mb-2">
                                                        Datos Apoderados :
                                                    </p>
                                                    <p class="fw-bold mb-1">
                                                        {{$apoderado->nombre}}
                                                    </p>
                                                    @else
                                                    <p class="fw-bold mt-4 mb-1">
                                                        {{$apoderado->nombre}}
                                                    </p>
                                                    @endif
                                                    
                                                    <p class="mb-1">
                                                        {{$apoderado->mail}}
                                                    </p>
                                                    <p class="mb-1">
                                                        {{$apoderado->telefono}}
                                                    </p>
                                                </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        <div class="row gy-3">
                                            <div class="col-ml-12 d-flex flex-wrap">
                                                <div class="col-md-3">
                                                    <p class="fw-semibold text-muted mb-1">Estado del Pago :</p>
                                                    <span class="fs-17 mb-1 fw-semibold
                                                    @if($pago->estado === 'atrasado') text-warning
                                                    @elseif($pago->estado === 'pendiente') text-secondary
                                                    @elseif($pago->estado === 'pagado') text-success
                                                    @endif">
                                                    {{ ucfirst($pago->estado) }}
                                                </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="fw-semibold text-muted mb-1">Mes de Pago :</p>
                                                    <p class="fs-15 mb-1"> {{ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F'))}}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="fw-semibold text-muted mb-1">Pago Realizado el :</p>
                                                    <p class="fs-15 mb-1">
                                                        {{ $pago->fecha_pagado ? \Carbon\Carbon::parse($pago->fecha_pagado)->format('d/m/Y') : '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="fw-semibold text-muted mb-1">Valor Total:</p>
                                                    <p class="fs-16 mb-1 fw-semibold">${{ number_format($pago->valor_total, 0, ',', '.')}}</p>
                                                </div>
                                        </div>
                                    </div>
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table table- border mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th>TIPO</th>
                                                            <th>NOTAS</th>
                                                            <th>FECHA</th>
                                                            <th>ESTADO</th>
                                                            <th>VALOR</th>
                                                            <th>EDITAR ESTADO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                        
                                                        <script>console.log({{$eventos}})</script>
                                                        @foreach ($eventos as $evento)
                                                        <tr>
                                                            <td>
                                                                <div class="fw-semibold">
                                                                    {{ $evento['tipo'] }}
                                                                </div>
                                                            </td>
                                                            
                                                            @if($evento['estado'] === 'realizada')
                                                            <td>
                                                                Realizada el {{ \Carbon\Carbon::parse($evento['fecha'])->translatedFormat('j \d\e F') }} desde {{ \Carbon\Carbon::parse($evento['hora_inicio'])->format('H:i') }} a {{ \Carbon\Carbon::parse($evento['hora_final'])->format('H:i') }}.
                                                                {{ ucfirst($evento['notas']) }} 
                                                            </td>
                                                            <td>
                                                                <div class="text-muted">
                                                                    {{ ucfirst(\Carbon\Carbon::parse($evento['fecha'])->translatedFormat('d/m/Y')) }}
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity-container text-success">
                                                                {{ ucfirst($evento['estado']) }}
                                                            </td>
                                                            <td>
                                                                ${{ number_format($evento['valor'], 0, ',', '.') }}
                                                            </td>
                                                            @elseif($evento['estado'] === 'pendiente')
                                                            <td>
                                                                {{ $evento['tipo'] }} pendiente a realizar.
                                                            </td>
                                                            <td>
                                                                <div class="text-muted">
                                                                    {{ ucfirst(\Carbon\Carbon::parse($evento['fecha'])->translatedFormat('d/m/Y')) }}
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity-container text-secondary">
                                                                {{ ucfirst($evento['estado']) }}
                                                            </td>
                                                            <td>
                                                                $0
                                                            </td>
                                                            @elseif($evento['estado'] === 'cancelada')
                                                            <td>
                                                                {{ $evento['tipo'] }} cancelada.
                                                            </td>
                                                            <td>
                                                                <div class="text-muted">
                                                                    {{ ucfirst(\Carbon\Carbon::parse($evento['fecha'])->translatedFormat('d/m/Y')) }}
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity-container text-danger">
                                                                {{ ucfirst($evento['estado']) }}
                                                            </td>
                                                            <td>
                                                                $0
                                                            </td>
                                                            @elseif($evento['estado'] === 'no avisó')
                                                            <td>
                                                                No asistio a la sesión y no se dio avisó.
                                                            </td>
                                                            <td>
                                                                <div class="text-muted">
                                                                    {{ ucfirst(\Carbon\Carbon::parse($evento['fecha'])->translatedFormat('d/m/Y')) }}
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity-container text-warning">
                                                                {{ ucfirst($evento['estado']) }}
                                                            </td>
                                                            <td>
                                                                ${{ number_format($evento['valor'], 0, ',', '.') }}
                                                            </td>
                                                            
                                                            @endif
                                                            <td>
                                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$evento['modal']}}{{ $evento['id'] }}"><i class="ri-edit-line align-middle"></i></button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                        
                                                        <tr>
                                                            @php
                                                            $total_reuniones = 0;
                                                            $total_valor = 0;
                                                            $total_sesiones = 0;
                                                            foreach ($eventos as $evento) {
                                                            if ($evento['tipo'] === 'Reunión' && $evento['estado'] === 'realizada') {
                                                                    $total_reuniones += intval($evento['valor']);
                                                                }
                                                            if ($evento['tipo'] === 'Sesión' && $evento['estado'] === 'realizada') {
                                                                $total_sesiones += intval($evento['valor']);
                                                            }
                                                            if ($evento['tipo'] === 'Sesión' && $evento['estado'] === 'no avisó') {
                                                                $total_sesiones += intval($evento['valor']);
                                                            }
                                                            }

                                                            @endphp
                                                            <td colspan="3"></td>
                                                            <td colspan="2">
                                                                <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                                    <tbody>
                                                                        
                                                                        <tr>
                                                                            <th scope="row">
                                                                                <p class="mb-0">Total Sesiones :</p>
                                                                            </th>
                                                                            <td>
                                                                                <p class="mb-0 fw-semibold fs-15">${{ number_format($total_sesiones, 0, ',', '.') }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">
                                                                                <p class="mb-0">Total Reuniones :</p>
                                                                            </th>
                                                                            <td>
                                                                                <p class="mb-0 fw-semibold fs-15">${{ number_format($total_reuniones, 0, ',', '.') }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">
                                                                                <p class="mb-0 fs-14">Total a Pagar :</p>
                                                                            </th>
                                                                            <td>
                                                                                <p class="mb-0 fw-semibold fs-16 text-success">${{ number_format($pago->valor_total, 0, ',', '.')}}</p>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::row-1 -->

                </div>
@include('pages.modals.editPagoShow')
@include('pages.modals.editReunionPago')
@include('pages.modals.editEstadoPago')
    

@endsection

@section('scripts')


@endsection