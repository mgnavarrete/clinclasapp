@extends('layouts.master')

@section('styles')
      
@endsection

@section('content')

@php
    \Carbon\Carbon::setLocale('es');

@endphp

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Listado de Alumnos</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Alumnos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="team-members" id="team-members">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="team-header">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="h5 fw-semibold mb-0">Alumnos</div>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group">
                                                <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex">
                                                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Buscar alumno" aria-describedby="search-team-member" value="{{ request('search') }}">
                                                    <button class="btn btn-light" type="submit" id="search-team-member"><i class="ri-search-line text-muted"></i></button>
                                                </form>
                                            </div>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-light btn-wave waves-effect waves-light px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('pacientes.form') }}">Agregar Alumno</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($pacientes as $paciente)
                    @php
                    $apoderadosPaciente = $paciente->tutores;
                    $edadPaciente = \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age;
                    $coverImageNumber = rand(1, 6);
                    $avatarImageNumber = $paciente->sexo === 'Mujer' ? rand(1, 8) : rand(9, 15);
                    $sesion = $sesiones->where('id_paciente', $paciente->id_paciente)->first();
                    @endphp
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card team-member-card" style="height: 280px;">
                            <div class="teammember-cover-image">
                                <img src="https://laravelui.spruko.com/ynex/build/assets/images/media/team-covers/{{ $coverImageNumber }}.jpg" class="card-img-top" alt="...">
                                <span class="avatar avatar-xl avatar-rounded">
                                    <img src="https://laravelui.spruko.com/ynex/build/assets/images/faces/{{ $avatarImageNumber }}.jpg" alt="">
                                </span>
                            </div>
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-item-center mt-0 justify-content-between border-bottom p-3">
    
                                    <div style="margin-left: 4.5rem;">
                                        <p class="mb-1 fw-semibold fs-17">
                                            <a href="{{ route('pacientes.show', $paciente->id_paciente) }}">{{ $paciente->nombre }}</a>
                                        </p>
                                        <p class="mb-0 fs-12 text-muted text-break">
                                            {{ $edadPaciente }} años
                                        </p>
                                        <p class="mb-0 fs-12 text-muted text-break">
                                            {{$paciente->curso}}, {{$paciente->colegio}}
                                        </p>
                                    </div>
                                    {{-- <div class="dropdown">
                                        <button class="btn btn-sm btn-icon btn-light btn-wave waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">Ver</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Editar</a></li>
    
                                        </ul>
                                    </div> --}}
                                </div>
                                <div class="team-member-stats d-sm-flex justify-content-evenly">
                                    <div class="text-center p-3 my-auto">
                                        <p class="fw-semibold mb-0">Día</p>
                                        <span class="text-muted fs-12">
                                            {{ $sesion ? ($sesion->dia_semana ? ucfirst($sesion->dia_semana) : 'N/A') : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-center p-3 my-auto">
                                        <p class="fw-semibold mb-0">Hora</p>
                                        <span class="text-muted fs-12">
                                            {{ $sesion ? ($sesion->hora_inicio ? \Carbon\Carbon::parse($sesion->hora_inicio)->format('H:i') : 'N/A') : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="text-center p-3 my-auto">
                                        <p class="fw-semibold mb-0">Valor</p>
                                        <span class="text-muted fs-12">
                                            {{ $sesion ? '$' . number_format($sesion->valor, 0, ',', '.') : 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-3">
                                {{-- Previous Page Link --}}
                                @if ($pacientes->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Anterior</a></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $pacientes->previousPageUrl() }}">Anterior</a></li>
                                @endif
    
                                {{-- Pagination Elements --}}
                                @foreach ($pacientes->links()->elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{{ $element }}</a></li>
                                @endif
    
                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                @foreach ($element as $page => $url)
                                @if ($page == $pacientes->currentPage())
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $page }}</a></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
    
                                {{-- Next Page Link --}}
                                @if ($pacientes->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $pacientes->nextPageUrl() }}">Siguiente</a></li>
                                @else
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Siguiente</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

