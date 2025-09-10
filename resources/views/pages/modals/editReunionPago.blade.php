@foreach($reuniones as $reunion)
<!-- Editar Reunion -->
<div class="modal fade" id="editReunion{{ $reunion->id_reunion }}" tabindex="-1" aria-labelledby="editReunionModal{{ $reunion->id_reunion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReunionModal{{ $reunion->id_reunion }}">
                    <i class="ri-team-line me-2"></i>
                    Reunión de {{ $reunion->paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información de la reunión -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-user-line fs-16 me-2 text-primary"></i>
                                            {{ $reunion->paciente->nombre }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-calendar-line me-1"></i>
                                            {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($reunion->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('F')) }}
                                            <br>
                                            <i class="ri-time-line me-1"></i>
                                            {{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reunion->hora_final)->format('H:i') }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @php
                                            $badgeClass = match($reunion->estado) {
                                                'pendiente' => 'bg-warning',
                                                'realizada' => 'bg-success',
                                                'cancelada' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-12">
                                            <i class="ri-bookmark-line me-1"></i>{{ ucfirst($reunion->estado) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">Gestión de pagos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('reuniones.updatePago', ['id_reunion' => $reunion->id_reunion, 'id_pago' => $pago->id_pago]) }}" method="POST" id="formEditReunion{{ $reunion->id_reunion }}">
                    @csrf
                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Actualizar Estado de la Reunión
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado de la Reunión -->
                        <div class="col-md-6 mb-3">
                            <label for="estado{{ $reunion->id_reunion }}" class="form-label text-default">
                                <i class="ri-bookmark-line me-1"></i>Estado de la Reunión
                            </label>
                            <select class="form-select form-select-lg bg-outline-primary" id="estado{{ $reunion->id_reunion }}" name="estado">
                                <option value="pendiente" {{ $reunion->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelada" {{ $reunion->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="realizada" {{ $reunion->estado === 'realizada' ? 'selected' : '' }}>Realizada</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="ri-money-dollar-circle-line fs-24 text-warning mb-2"></i>
                                    <p class="text-muted small mb-0">Gestión de pagos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerta informativa -->
                    <div class="alert alert-warning">
                        <i class="ri-information-line me-2"></i>
                        <strong>Pagos:</strong> Los cambios afectarán el cálculo y estado del pago asociado a esta reunión.
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerEditReunion{{ $reunion->id_reunion }}">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-warning" id="guardarBtnEditReunion{{ $reunion->id_reunion }}">
                                <i class="ri-save-line me-1"></i>Actualizar Reunión
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('formEditReunion{{ $reunion->id_reunion }}').addEventListener('submit', function() {
        document.getElementById('guardarBtnEditReunion{{ $reunion->id_reunion }}').classList.add('d-none');
        document.getElementById('spinnerEditReunion{{ $reunion->id_reunion }}').classList.remove('d-none');
    });
</script>
@endforeach