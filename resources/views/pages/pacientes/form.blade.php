@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('build/assets/libs/flatpickr/l10n/es.js')}}"></script>
@vite('resources/assets/js/date&time_pickers.js')
@endsection


@section('content')

@php
    \Carbon\Carbon::setLocale('es');

@endphp

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Nuevo Alumno</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agregar Alumno</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->


    <form action="{{ route('pacientes.create') }}" method="POST" id="formPaciente">
        @csrf
        <div class="row d-flex align-items-stretch">
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información del Alumno</h5>
                    </div>
                    <div class="card-body">

                        <!-- Nombre -->
                        <div class="col-xl-12 mb-3">
                            <label for="nombre" class="form-label text-default ">Nombre</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre" name="nombre" placeholder="Nombre" required>
                        </div>

                        <!-- Fecha de nacimiento -->
                        <div class="col-xl-12 mb-3">
                            <label for="humanfrienndlydate" class="form-label text-default">Fecha de nacimiento</label>
                            <div class="form-group bg-outline-primary">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                    <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_nacimiento" placeholder="Seleccionar fecha de nacimiento" required>
                                </div>
                            </div>
                        </div>

                        <!-- Curso -->
                        <div class="col-xl-12 mb-3">
                            <label for="curso" class="form-label text-default">Curso</label>
                            <select class="form-select form-select-lg bg-outline-primary" id="curso" name="curso" required>
                                <option value="">Seleccionar curso</option>
                                <option value="pre-kinder">Pre-Kinder</option>
                                <option value="kinder">Kinder</option>
                                <option value="1° Básico">1° Básico</option>
                                <option value="2° Básico">2° Básico</option>
                                <option value="3° Básico">3° Básico</option>
                                <option value="4° Básico">4° Básico</option>
                                <option value="5° Básico">5° Básico</option>
                                <option value="6° Básico">6° Básico</option>
                                <option value="7° Básico">7° Básico</option>
                                <option value="8° Básico">8° Básico</option>
                                <option value="1° Medio">1° Medio</option>
                                <option value="2° Medio">2° Medio</option>
                                <option value="3° Medio">3° Medio</option>
                                <option value="4° Medio">4° Medio</option>
                            </select>
                        </div>

                        <!-- Colegio -->
                        <div class="col-xl-12 mb-3">
                            <label for="colegio" class="form-label text-default">Colegio</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="colegio" name="colegio" placeholder="Colegio" required>
                        </div>


                        <!-- RUT formato 12.345.113-8 -->
                        <div class="col-xl-12 mb-3">
                            <label for="rut" class="form-label text-default">RUT</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="rut" name="rut" placeholder="RUT" oninput="formatRUT(this)" required>
                        </div>

                        <!-- Sexo -->
                        <div class="col-xl-12 mb-3">
                            <label for="sexo" class="form-label text-default">Sexo</label>
                            <select class="form-select form-select-lg bg-outline-primary" id="sexo" name="sexo" required>
                                <option value="">Seleccionar sexo</option>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                            </select>
                        </div>

                        <!-- Dirección -->
                        <div class="col-xl-12 mb-3">
                            <label for="direccion" class="form-label text-default">Dirección</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="direccion" name="direccion" placeholder="Dirección" required>
                        </div>

                        <!-- Información Adicional del Paciente -->
                        <div class="col-xl-12 h-100">
                            <label for="info_adicional" class="form-label text-default mb-3">Información Adicional <span class="text-muted">(Opcional)</span></label>
                            <textarea class=" form-control form-control-lg bg-outline-primary mb-2" id="info_adicional" name="info_adicional" placeholder="Escribe aquí cualquier información adicional sobre el paciente"></textarea>
                        </div>
                        <br>
                    </div>

                </div>
            </div>

            <div class="col-md-6 ">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información de Apoderado</h5>
                    </div>

                    <div class="card-body">

                        <!-- Nombre -->
                        <div class="col-xl-12 mb-3">
                            <label for="nombre_tutor" class="form-label text-default ">Nombre</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre_tutor" name="nombre_tutor" placeholder="Nombre" required>
                        </div>
                        <!-- Telefono -->
                        <div class="col-xl-12 mb-3">
                            <label for="telefono_tutor" class="form-label text-default ">Teléfono</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="telefono_tutor" name="telefono_tutor" placeholder="Teléfono" oninput="addPrefix(this)" required>
                        </div>

                        <!-- Mail -->
                        <div class="col-xl-12 mb-3">
                            <label for="mail_tutor" class="form-label text-default ">Mail</label>
                            <input type="email" class="form-control form-control-lg bg-outline-primary" id="mail_tutor" name="mail_tutor" placeholder="Mail" required>
                        </div>
                    </div>

                </div>

                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información de Apoderado 2 <span class="text-muted">(Opcional)</span></h5>
                    </div>

                    <div class="card-body">

                        <!-- Nombre -->
                        <div class="col-xl-12 mb-3">
                            <label for="nombre_tutor2" class="form-label text-default ">Nombre</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre_tutor2" name="nombre_tutor2" placeholder="Nombre">
                        </div>
                        <!-- Telefono -->
                        <div class="col-xl-12 mb-3">
                            <label for="telefono_tutor2" class="form-label text-default ">Teléfono</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="telefono_tutor2" name="telefono_tutor2" placeholder="Teléfono" oninput="addPrefix(this)">
                        </div>

                        <!-- Mail -->
                        <div class="col-xl-12 mb-3">
                            <label for="mail_tutor2" class="form-label text-default ">Mail</label>
                            <input type="email" class="form-control form-control-lg bg-outline-primary" id="mail_tutor2" name="mail_tutor2" placeholder="Mail">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-end">
          <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <h5 class="card-title">Información de Sesión</h5>
                </div>
                <div class="card-body">
                    <!-- Dia de la semana -->
                    <div class="col-xl-12 mb-3">
                        <label for="dia" class="form-label text-default">Día de la semana</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="dia" name="dia" required>
                            <option value="">Seleccionar día</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miércoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Hora Inicio Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_inicio" class="form-label text-default">Horario Inicio Sesión</label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_inicio" name="hora_inicio" required>
                                <option value="">Hora</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                            </select>
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_inicio" name="minuto_inicio" required>
                                <option value="">Min</option>
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hora Fin Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_fin" class="form-label text-default">Horario Final Sesión</label>

                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_fin" name="hora_fin" required>
                                <option value="">Hora</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                            </select>
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_fin" name="minuto_fin" required>
                                <option value="">Min</option>
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>
             

                    <!-- Tipo de sesión -->
                    <div class="col-xl-12 mb-3">
                        <label for="tipoSesion" class="form-label text-default">Tipo de sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="tipoSesion" name="tipoSesion" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="individual">Individual</option>
                            <option value="grupal">Grupal</option>
                        </select>
                    </div>

                    <!-- Valor-->
                    <div class="col-xl-12 mb-3">
                        <label for="valor" class="form-label text-default">Valor</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valor" name="valor" placeholder="Valor" oninput="formatCurrency(this)" required>
                    </div>

                    <!-- Year -->
                    <div class="col-xl-12 mb-3">
                        <label for="year"    class="form-label text-default">Año</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="year" name="year" required>
                            <option value="{{ \Carbon\Carbon::now()->year }}">{{ \Carbon\Carbon::now()->year }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                        </select>
                    </div>

                    <!-- Crear Sesiones por todo el año -->
                    <div class="col-xl-12 mb-3">
                        <div class="form-check form-check-lg d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" value="1" id="checkebox-lg" name="sesiones-anual" checked="">
                            <label class="form-check-label" for="checkebox-lg">
                                Crear Sesiones por todo el año
                            </label>
                        </div>
                    </div>
                </div>
            </div>


          </div>     
        </div>    

        <div class="text-end">
            <div class="spinner-border text-primary d-none" role="status" id="spinnerPaciente">
                <span class="visually-hidden">Loading...</span>
            </div>
            <button type="submit" class="btn btn-primary m-2 mb-5" id="guardarBtnPaciente">Guardar</button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-outline-danger m-2 mb-5 me-5">Cancelar</a>
        </div>
    </form>

    
    
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

@endsection

@section('scripts')

<!-- Scripts para el formulario -->
<script>
    document.getElementById('formPaciente').addEventListener('submit', function() {
        document.getElementById('guardarBtnPaciente').classList.add('d-none');
        document.getElementById('spinnerPaciente').classList.remove('d-none');
    });
</script>

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