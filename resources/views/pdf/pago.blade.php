<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
    @php
    \Carbon\Carbon::setLocale('es');
    @endphp
    <head>

        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Laravel Bootstrap Responsive Admin Web Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="dashboard bootstrap, laravel template, admin panel in laravel, php admin panel, admin panel for laravel, admin template bootstrap 5, laravel admin panel, admin dashboard template, hrm dashboard, vite laravel, admin dashboard, ecommerce admin dashboard, dashboard laravel, analytics dashboard, template dashboard, admin panel template, bootstrap admin panel template">
        
        <!-- TITLE -->
		<title> Pago_{{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }}_{{$pago->paciente->nombre}} </title>

        <!-- FAVICON -->
        <link rel="icon" href="{{asset('build/assets/images/brand-logos/favicon.png')}}" type="image/x-icon">

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="{{asset('build/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/icon-fonts/icons.css')}}" rel="stylesheet">
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])


        @include('layouts.components.styles')

        <!-- MAIN JS -->
        <script src="{{asset('build/assets/main.js')}}"></script>

        <!-- Estilos específicos para impresión -->
        <style>
            @media print {
                .print-columns {
                    display: flex !important;
                    flex-direction: row !important;
                    width: 100% !important;
                }
                
                .print-column {
                    flex: 1 !important;
                    width: 33.333% !important;
                    float: none !important;
                    display: block !important;
                    margin-right: 10px !important;
                }
                
                .print-column:last-child {
                    margin-right: 0 !important;
                }
                
                .col-xl-4, .col-lg-4, .col-md-4, .col-sm-4, .col-sm-12 {
                    width: 33.333% !important;
                    float: left !important;
                    display: block !important;
                    margin-right: 10px !important;
                }
                
                .col-xl-4:last-child, .col-lg-4:last-child, .col-md-4:last-child, .col-sm-4:last-child, .col-sm-12:last-child {
                    margin-right: 0 !important;
                }
                
                /* Estilos para tablas en impresión */
                .table {
                    font-size: 11px !important;
                }
                
                .table th {
                    font-size: 10px !important;
                    padding: 4px 6px !important;
                }
                
                .table td {
                    font-size: 10px !important;
                    padding: 4px 6px !important;
                }
                
                .table-sm th {
                    font-size: 9px !important;
                    padding: 2px 4px !important;
                }
                
                .table-sm td {
                    font-size: 9px !important;
                    padding: 2px 4px !important;
                }
                
                /* Estilos para la sección de información del pago */
                .payment-info-section * {
                    font-size: 12px !important;
                }
                
                .payment-info-section .fs-17,
                .payment-info-section .fs-16,
                .payment-info-section .fs-15,
                .payment-info-section .fs-14 {
                    font-size: 12px !important;
                }
            }
        </style>

        @yield('styles')

	</head>

	<body>


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
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <div class="row align-items-between print-columns">
                             <!-- Columna 1: Datos del Alumno -->
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 print-column">
                                            <div class="card bg-transparent border-0">
                                                <div class="card-body">
                                                    <h6 class="card-title text-primary mb-3">
                                                        <i class="ri-user-line me-2"></i>Datos del Alumno
                                                    </h6>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Nombre:</span>
                                                        <p class="fw-bold mb-1">{{ucfirst($pago->paciente->nombre)}}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">RUT:</span>
                                                        <p class="mb-1">{{$pago->paciente->rut}}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Dirección:</span>
                                                        <p class="mb-1">{{$pago->paciente->direccion}}</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Fecha de Nacimiento:</span>
                                                        <p class="mb-1">{{ \Carbon\Carbon::parse($pago->paciente->fecha_nacimiento)->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <span class="text-muted fs-12">Curso y Colegio:</span>
                                                        <p class="mb-0">{{$pago->paciente->curso}}, {{$pago->paciente->colegio}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Columna 2: Datos de Apoderados -->
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 print-column">
                                            <div class="card bg-transparent border-0">
                                                <div class="card-body">
                                                    <h6 class="card-title text-success mb-3">
                                                        <i class="ri-parent-line me-2"></i>Datos de Apoderados
                                                    </h6>
                                                    @forelse ($apoderados as $apoderado)
                                                        <div class="mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                                                            <div class="mb-2">
                                                                <span class="text-muted fs-12">Nombre:</span>
                                                                <p class="fw-bold mb-1">{{$apoderado->nombre}}</p>
                                                            </div>
                                                            <div class="mb-2">
                                                                <span class="text-muted fs-12">Email:</span>
                                                                <p class="mb-1">{{$apoderado->mail}}</p>
                                                            </div>
                                                            <div class="mb-0">
                                                                <span class="text-muted fs-12">Teléfono:</span>
                                                                <p class="mb-0">{{$apoderado->telefono}}</p>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="text-center text-muted">
                                                            <i class="ri-user-line fs-24 mb-2"></i>
                                                            <p class="mb-0">No hay apoderados registrados</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Columna 3: Datos de Transferencia -->
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 print-column">
                                            <div class="card bg-transparent border-0">
                                                <div class="card-body">
                                                    <h6 class="card-title text-warning mb-3">
                                                        <i class="ri-bank-line me-2"></i>Datos de Transferencia
                                                    </h6>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Titular:</span>
                                                        <p class="fw-bold mb-1">Norma Tapia</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">RUT:</span>
                                                        <p class="mb-1">10.335.911-2</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Banco:</span>
                                                        <p class="mb-1">Banco Edwards</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Tipo de Cuenta:</span>
                                                        <p class="mb-1">Cuenta Corriente</p>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="text-muted fs-12">Número de Cuenta:</span>
                                                        <p class="mb-1">00-153-03387-08</p>
                                                    </div>
                                                    <div class="mb-0">
                                                        <span class="text-muted fs-12">Email:</span>
                                                        <p class="mb-0">natapiar@gmail.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                    <div class="row gy-3 payment-info-section">
                        <div class="col-ml-12 d-flex flex-wrap">
                            <div class="col-md-3 ">
                                <p class="fw-semibold text-muted mb-1">Estado del Pago :</p>
                                <span class="fs-17 mb-1 fw-semibold
                                @if($pago->estado === 'atrasado') text-warning
                                @elseif($pago->estado === 'pendiente') text-secondary
                                @elseif($pago->estado === 'pagado') text-success
                                @endif">
                                {{ ucfirst($pago->estado) }}
                            </span>
                            </div>
                            <div class="col-md-3 ms-5">
                                <p class="fw-semibold text-muted mb-1">Mes de Pago :</p>
                                <p class="fs-15 mb-1"> {{ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F'))}}</p>
                            </div>
                            <div class="col-md-3 ms-5">
                                <p class="fw-semibold text-muted mb-1">Pago Realizado el :</p>
                                <p class="fs-15 mb-1">
                                    {{ $pago->fecha_pagado ? \Carbon\Carbon::parse($pago->fecha_pagado)->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-3 ms-5">
                                <p class="fw-semibold text-muted mb-1">Valor Total:</p>
                                <p class="fs-16 mb-1 fw-semibold">${{ number_format($pago->valor_total, 0, ',', '.')}}</p>
                            </div>
                    </div>
                </div>
                    <div class="col-xl-12">
                        <div class="table-responsive">
                            <table class="table border mt-4">
                                <thead>
                                    <tr>
                                        <th>TIPO</th>
                                        <th>FECHA</th>
                                        <th>ESTADO</th>
                                        <th>VALOR</th>
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
                                        <td colspan="2"></td>
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
<script>
    // Espera a que la página se cargue completamente
    window.onload = function() {
        // Llama a la función de impresión
        window.print();
    };
</script>
        @include('layouts.components.scripts')

        @yield('scripts')

        <!-- STICKY JS -->
		<script src="{{asset('build/assets/sticky.js')}}"></script>

        <!-- APP JS -->
		<!--@vite('resources/js/app.js')-->


        <!-- CUSTOM-SWITCHER JS -->
        @vite('resources/assets/js/custom-switcher.js')

        
        <!-- END SCRIPTS -->

	</body>
</html>

