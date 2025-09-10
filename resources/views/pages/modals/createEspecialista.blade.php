<!-- Crear Especialista -->
<div class="modal fade" id="createEspecialista" tabindex="-1" aria-labelledby="createEspecialistaModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEspecialistaModal">
                    <i class="ri-user-add-line me-2"></i>
                    Crear Nuevo Especialista
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('especialistas.create', $paciente->id_paciente) }}" method="POST" id="formCreateEspecialista">
                    @csrf
                    
                    <!-- Información del Paciente -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Asignar a Paciente
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="fw-semibold mb-0 d-flex align-items-center">
                                                <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                                                {{ $paciente->nombre }} - {{ $paciente->curso }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos del Especialista -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-user-add-line me-2"></i>
                                Datos del Especialista
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre_especialista" class="form-label fw-semibold">
                                <i class="ri-user-line me-1"></i>Nombre Completo
                            </label>
                            <input type="text" class="form-control" id="nombre_especialista" name="nombre_especialista" 
                                   placeholder="Nombre completo del especialista" required>
                        </div>

                        <!-- Especialidad -->
                        <div class="col-md-6 mb-3">
                            <label for="especialidad_especialista" class="form-label fw-semibold">
                                <i class="ri-stethoscope-line me-1"></i>Especialidad
                            </label>
                            <input type="text" class="form-control" id="especialidad_especialista" name="especialidad_especialista" 
                                   placeholder="Ej: Psicología, Fonoaudiología, etc." required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Telefono -->
                        <div class="col-md-6 mb-3">
                            <label for="telefono_especialista" class="form-label fw-semibold">
                                <i class="ri-phone-line me-1"></i>Teléfono
                            </label>
                            <input type="text" class="form-control" id="telefono_especialista" name="telefono_especialista" 
                                   placeholder="+56 9 1234 5678" oninput="addPrefix(this)" required>
                        </div>

                        <!-- Mail -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_especialista" class="form-label fw-semibold">
                                <i class="ri-mail-line me-1"></i>Correo Electrónico
                            </label>
                            <input type="email" class="form-control" id="mail_especialista" name="mail_especialista" 
                                   placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> El especialista será asignado automáticamente al alumno {{ $paciente->nombre }}.
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerCreateEspecialista">   
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="guardarBtnCreateEspecialista" onclick="document.getElementById('formCreateEspecialista').submit()">
                    <i class="ri-save-line me-1"></i>Crear Especialista
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    
    document.getElementById('formCreateEspecialista').addEventListener('submit', function() {
        document.getElementById('guardarBtnCreateEspecialista').classList.add('d-none');
        document.getElementById('spinnerCreateEspecialista').classList.remove('d-none');
    });
</script>