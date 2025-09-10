<!-- Editar Sesion -->
<div class="modal fade" id="editSesion" tabindex="-1" aria-labelledby="editSesionModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSesionModal">
                    <i class="ri-calendar-event-line me-2"></i>
                    Editar Sesiones - {{ $paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @php
                    $sesionesActivas = $sesionesPaciente->filter(function($sesion) {
                        return $sesion->tipo !== null;
                    });
                @endphp
                @if(count($sesionesActivas) > 1)
                    <!-- Tabs para múltiples sesiones -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Seleccionar Sesión a Editar
                                    </h6>
                                    <p class="text-muted mb-3">Este alumno tiene {{ count($sesionesActivas) }} sesiones activas configuradas. Selecciona la que deseas editar:</p>
                                    
                                    <ul class="nav nav-pills nav-justified sesion-tabs" id="sesionTabs" role="tablist">
                                        @foreach($sesionesActivas as $index => $sesion)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                                    id="sesion{{ $sesion->id_sesion }}-tab" 
                                                    data-bs-toggle="pill" 
                                                    data-bs-target="#sesion{{ $sesion->id_sesion }}-content" 
                                                    type="button" 
                                                    role="tab" 
                                                    aria-controls="sesion{{ $sesion->id_sesion }}-content" 
                                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                <i class="ri-calendar-check-line me-2"></i>
                                                Sesión {{ $index + 1 }}: {{ ucfirst($sesion->dia_semana) }}
                                                <br>
                                                <small class="text-muted">{{ $sesion->hora_inicio }} - {{ $sesion->hora_final }}</small>
                                            </button>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido de los tabs -->
                    <div class="tab-content" id="sesionTabsContent">
                        @foreach($sesionesActivas as $index => $sesion)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                             id="sesion{{ $sesion->id_sesion }}-content" 
                             role="tabpanel" 
                             aria-labelledby="sesion{{ $sesion->id_sesion }}-tab">
                            @include('pages.modals.partials.edit-sesion-form', ['sesion' => $sesion, 'index' => $index])
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Una sola sesión -->
                    @if(count($sesionesActivas) > 0)
                        @include('pages.modals.partials.edit-sesion-form', ['sesion' => $sesionesActivas->first(), 'index' => 0])
                    @else
                        <div class="alert alert-warning">
                            <i class="ri-alert-line me-2"></i>
                            <strong>Sin sesiones activas:</strong> Este alumno no tiene sesiones activas configuradas.
                            @if(count($sesionesPaciente) > 0)
                                <br><small class="text-muted">Hay {{ count($sesionesPaciente) - count($sesionesActivas) }} sesiones eliminadas en el historial.</small>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.sesion-tabs .nav-link {
    border-radius: 10px;
    margin: 0 5px;
    padding: 15px 20px;
    text-align: center;
    border: 2px solid #e9ecef;
    background-color: #f8f9fa;
    color: #6c757d;
    transition: all 0.3s ease;
}

.sesion-tabs .nav-link:hover {
    border-color: #0d6efd;
    background-color: #e7f1ff;
    color: #0d6efd;
    transform: translateY(-2px);
}

.sesion-tabs .nav-link.active {
    border-color: #0d6efd;
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
}

.sesion-tabs .nav-link small {
    display: block;
    margin-top: 5px;
    font-size: 0.75rem;
}

.sesion-tabs .nav-link.active small {
    color: rgba(255, 255, 255, 0.8);
}

.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Estilos para botón de eliminar */
.btn-danger {
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

/* Modal de confirmación de eliminación */
.modal-header.bg-danger {
    border-bottom: none;
}

.fs-48 {
    font-size: 3rem;
}
</style>