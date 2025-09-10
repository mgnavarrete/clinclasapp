@foreach($estadoSesiones as $estado)
<!-- Editar Estado -->
<div class="modal fade" id="editEstado{{ $estado->id_estado }}" tabindex="-1" aria-labelledby="editEstadoModal{{ $estado->id_estado }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEstadoModal{{ $estado->id_estado }}">
                    <i class="ri-calendar-event-line me-2"></i>
                    Sesión de {{ $estado->sesion->paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información de la sesión -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-user-line fs-16 me-2 text-primary"></i>
                                            {{ $estado->sesion->paciente->nombre }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-calendar-line me-1"></i>
                                            {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($estado->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('F')) }}
                                            <br>
                                            <i class="ri-time-line me-1"></i>
                                            {{ \Carbon\Carbon::parse($estado->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($estado->hora_final)->format('H:i') }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @php
                                            $badgeClass = match($estado->estado) {
                                                'pendiente' => 'bg-warning',
                                                'realizada' => 'bg-success',
                                                'cancelada' => 'bg-danger',
                                                'no avisó' => 'bg-secondary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-12">
                                            <i class="ri-bookmark-line me-1"></i>{{ ucfirst($estado->estado) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">Desde calendario</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('estado.updateCal', $estado->id_estado) }}" method="POST" id="formEditEstado{{ $estado->id_estado }}">
                    @csrf
                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Actualizar Estado de la Sesión
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <label for="estado{{ $estado->id_estado }}" class="form-label text-default">
                                <i class="ri-bookmark-line me-1"></i>Estado de la Sesión
                            </label>
                            <select class="form-select form-select-lg bg-outline-primary" id="estado{{ $estado->id_estado }}" name="estado">
                                <option value="pendiente" {{ $estado->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelada" {{ $estado->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="no avisó" {{ $estado->estado === 'no avisó' ? 'selected' : '' }}>No Avisó</option>
                                <option value="realizada" {{ $estado->estado === 'realizada' ? 'selected' : '' }}>Realizada</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="ri-calendar-2-line fs-24 text-info mb-2"></i>
                                    <p class="text-muted small mb-0">Editando desde calendario</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Notas -->
                        <div class="col-12 mb-3">
                            <label for="notas{{ $estado->id_estado }}" class="form-label text-default">
                                <i class="ri-file-text-line me-1"></i>Notas <span class="text-muted">(Opcional)</span>
                            </label>
                            <textarea class="form-control form-control-lg bg-outline-primary" id="notas{{ $estado->id_estado }}" name="notas" rows="4" placeholder="Agrega cualquier observación o nota sobre esta sesión...">{{ $estado->notas }}</textarea>
                        </div>
                    </div>
                    <!-- Alerta informativa -->
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>Calendario:</strong> Los cambios se aplicarán y serán visibles en la vista de calendario.
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerEditEstado{{ $estado->id_estado }}">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-info" id="guardarBtnEditEstado{{ $estado->id_estado }}">
                                <i class="ri-save-line me-1"></i>Actualizar Estado
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById('formEditEstado{{ $estado->id_estado }}').addEventListener('submit', function() {
        document.getElementById('guardarBtnEditEstado{{ $estado->id_estado }}').classList.add('d-none');
        document.getElementById('spinnerEditEstado{{ $estado->id_estado }}').classList.remove('d-none');
    });
</script>
@endforeach