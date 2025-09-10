<!-- Editar TUTORES -->
<div class="modal fade" id="editTutor" tabindex="-1" aria-labelledby="editTutorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTutorModal">
                    <i class="ri-parent-line me-2"></i>
                    Editar Apoderado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del apoderado -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-parent-line fs-16 me-2 text-primary"></i>
                                            Modificar Información del Apoderado
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-edit-line me-1"></i>Actualiza los datos de contacto del apoderado
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-warning fs-12">
                                            <i class="ri-parent-line me-1"></i>Apoderado
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="" method="POST" id="editTutorForm">
                    @csrf
                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Actualizar Información del Apoderado
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre_tutor" class="form-label text-default">
                                <i class="ri-user-line me-1"></i>Nombre Completo
                            </label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre_tutor" name="nombre_tutor" placeholder="Nombre completo del apoderado" required>
                        </div>
                        
                        <!-- Mail -->
                        <div class="col-md-6 mb-3">
                            <label for="mail_tutor" class="form-label text-default">
                                <i class="ri-mail-line me-1"></i>Correo Electrónico
                            </label>
                            <input type="email" class="form-control form-control-lg bg-outline-primary" id="mail_tutor" name="mail_tutor" placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Telefono -->
                        <div class="col-12 mb-3">
                            <label for="telefono_tutor" class="form-label text-default">
                                <i class="ri-phone-line me-1"></i>Teléfono
                            </label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="telefono_tutor" name="telefono_tutor" placeholder="Número de teléfono" oninput="addPrefix(this)" required>
                        </div>
                    </div>

                    <!-- Alerta informativa -->
                    <div class="alert alert-warning">
                        <i class="ri-information-line me-2"></i>
                        <strong>Información:</strong> Los cambios se aplicarán inmediatamente a la información del apoderado.
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerTutor">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-warning" id="guardarBtnTutor">
                                <i class="ri-save-line me-1"></i>Actualizar Apoderado
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editTutorForm').addEventListener('submit', function() {
        // Ocultar el botón de guardar
        document.getElementById('guardarBtnTutor').classList.add('d-none');
        // Mostrar el spinner
        document.getElementById('spinnerTutor').classList.remove('d-none');
    });
</script>