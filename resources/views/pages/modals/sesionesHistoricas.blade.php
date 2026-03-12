<div class="modal fade" id="sesionesHistoricasModal" tabindex="-1" aria-labelledby="sesionesHistoricasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sesionesHistoricasModalLabel">
                    <i class="ri-history-line me-2"></i>
                    Sesiones Históricas - {{ $paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @php
                    $resumenHistoricoPorAnio = $estadoSesionesHistoricas->groupBy(function ($estado) {
                        return \Carbon\Carbon::parse($estado->fecha)->year;
                    })->sortKeysDesc();
                @endphp

                @if($sesionesHistoricas->isEmpty() && $estadoSesionesHistoricas->isEmpty())
                    <div class="alert alert-info mb-0">
                        <i class="ri-information-line me-1"></i>No hay sesiones históricas registradas.
                    </div>
                @else
                    <div class="alert alert-light border d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Vista histórica:</strong> aquí se muestran años anteriores a {{ $currentYear }}.
                        </div>
                        <span class="badge bg-secondary">
                            {{ $sesionesHistoricas->count() }} sesiones base
                        </span>
                    </div>

                    <h6 class="fw-semibold mb-3">
                        <i class="ri-calendar-line me-1"></i>Sesiones Base Históricas
                    </h6>
                    <div class="row">
                        @forelse($sesionesHistoricas as $sesionHistorica)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>{{ ucfirst($sesionHistorica->dia_semana) }}</strong>
                                            <span class="badge bg-secondary">{{ $sesionHistorica->year }}</span>
                                        </div>
                                        <p class="mb-1 text-muted">
                                            <i class="ri-time-line me-1"></i>{{ \Carbon\Carbon::parse($sesionHistorica->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesionHistorica->hora_final)->format('H:i') }}
                                        </p>
                                        <p class="mb-0 text-muted">
                                            <i class="ri-money-dollar-circle-line me-1"></i>${{ number_format($sesionHistorica->valor, 0, ',', '.') }} | {{ ucfirst($sesionHistorica->tipo) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">No hay sesiones base históricas.</div>
                            </div>
                        @endforelse
                    </div>

                    <h6 class="fw-semibold mt-4 mb-3">
                        <i class="ri-bar-chart-box-line me-1"></i>Resumen de Citas Históricas
                    </h6>
                    <div class="row">
                        @forelse($resumenHistoricoPorAnio as $anio => $citasAnio)
                            <div class="col-md-6 col-xl-4 mb-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="mb-3">Año {{ $anio }}</h6>
                                        <p class="mb-1">
                                            <span class="badge bg-success me-1">Realizadas</span>
                                            {{ $citasAnio->where('estado', 'realizada')->count() }}
                                        </p>
                                        <p class="mb-1">
                                            <span class="badge bg-warning me-1">Pendientes</span>
                                            {{ $citasAnio->where('estado', 'pendiente')->count() }}
                                        </p>
                                        <p class="mb-1">
                                            <span class="badge bg-danger me-1">Canceladas</span>
                                            {{ $citasAnio->where('estado', 'cancelada')->count() }}
                                        </p>
                                        <p class="mb-0">
                                            <span class="badge bg-secondary me-1">No avisó</span>
                                            {{ $citasAnio->where('estado', 'no avisó')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info mb-0">No hay citas históricas para resumir.</div>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
