<!-- Asignar Especialista -->
<div class="modal fade" id="asignarEspecialista" tabindex="-1" aria-labelledby="asignarEspecialistaModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarEspecialistaModal">
                    <i class="ri-user-add-line me-2"></i>
                    Asignar Especialista
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del paciente -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-user-line fs-16 me-2 text-primary"></i>
                                            {{ $paciente->nombre }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-user-add-line me-1"></i>Asignación de especialista
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-info fs-12">
                                            <i class="ri-user-star-line me-1"></i>Especialista
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('PE.create', $paciente->id_paciente) }}" method="POST" id="formAsignarEspecialista">
                    @csrf
                <!-- Campos del formulario -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="ri-edit-line me-2"></i>
                            Selección de Especialista
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <!-- Especialista -->
                    <div class="col-12 mb-3">
                        <label for="id_especialista" class="form-label text-default">
                            <i class="ri-user-star-line me-1"></i>Especialista
                        </label>
                        <select class="form-select form-control-lg bg-outline-primary" id="id_especialista" name="id_especialista" required>
                            <option value="">Selecciona un Especialista</option>
                            @foreach ($especialistas as $especialista)
                                <option value="{{ $especialista->id_especialista }}">{{ $especialista->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Alerta informativa -->
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    <strong>Información:</strong> El especialista seleccionado será asignado al paciente y tendrá acceso a su información.
                </div>
                
                <div class="modal-footer">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAsignarEspecialista">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-info" id="guardarBtnAsignarEspecialista">
                            <i class="ri-user-add-line me-1"></i>Asignar Especialista
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('formAsignarEspecialista').addEventListener('submit', function() {
        document.getElementById('guardarBtnAsignarEspecialista').classList.add('d-none');
        document.getElementById('spinnerAsignarEspecialista').classList.remove('d-none');
    });
</script>