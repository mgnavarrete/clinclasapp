@foreach($reuniones as $reunion)
<!-- Editar Reunion -->
<div class="modal fade" id="editReunion{{ $reunion->id_reunion }}" tabindex="-1" aria-labelledby="editReunionModal{{ $reunion->id_reunion }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReunionModal{{ $reunion->id_reunion }}">
                    <i class="ri-team-line me-2"></i>
                    Editar Reunión - {{ $reunion->paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reuniones.update', $reunion->id_reunion) }}" method="POST" id="formEditReunion{{ $reunion->id_reunion }}">
                    @csrf
                    
                    <!-- Información de la Reunión -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información de la Reunión
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="fw-semibold mb-2 d-flex align-items-center">
                                                <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                                                {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('l')) }} 
                                                {{ \Carbon\Carbon::parse($reunion->fecha)->format('j') }} 
                                                de {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('F')) }}
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="ri-time-line me-1"></i>{{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reunion->hora_final)->format('H:i') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-secondary fs-12">ID: {{ $reunion->id_reunion }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos Editables -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Editar Estado
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado de la Reunión -->
                        <div class="col-12 mb-3">
                            <label for="estado{{ $reunion->id_reunion }}" class="form-label fw-semibold">
                                <i class="ri-flag-line me-1"></i>Estado de la Reunión
                            </label>
                            <select class="form-select" id="estado{{ $reunion->id_reunion }}" name="estado" required>
                                <option value="pendiente" {{ $reunion->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="cancelada" {{ $reunion->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="realizada" {{ $reunion->estado === 'realizada' ? 'selected' : '' }}>Realizada</option>
                            </select>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> El cambio de estado se guardará automáticamente. Asegúrate de verificar la información antes de guardar.
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerEditReunion{{ $reunion->id_reunion }}">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="guardarBtnEditReunion{{ $reunion->id_reunion }}" onclick="document.getElementById('formEditReunion{{ $reunion->id_reunion }}').submit()">
                    <i class="ri-save-line me-1"></i>Guardar Cambios
                </button>
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