<!-- Editar Paciente -->
<div class="modal fade" id="editPaciente" tabindex="-1" aria-labelledby="editPacienteModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPacienteModal">
                    <i class="ri-user-edit-line me-2"></i>
                    Editar Alumno - {{ $paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pacientes.update', $paciente->id_paciente) }}" method="POST" id="editPacienteForm">
                    @csrf
                    
                    <!-- Información del Alumno -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información del Alumno
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="fw-semibold mb-2 d-flex align-items-center">
                                                <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                                                {{ $paciente->nombre }} - {{ $paciente->curso }}
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="ri-school-line me-1"></i>{{ $paciente->colegio }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-secondary fs-12">ID: {{ $paciente->id_paciente }}</span>
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
                                Editar Información
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="ri-user-line me-1"></i>Nombre Completo
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="{{ old('nombre', $paciente->nombre) }}" placeholder="Nombre completo del alumno" required>
                        </div>

                        <!-- RUT -->
                        <div class="col-md-6 mb-3">
                            <label for="rut" class="form-label fw-semibold">
                                <i class="ri-id-card-line me-1"></i>RUT
                            </label>
                            <input type="text" class="form-control" id="rut" name="rut" 
                                   value="{{ old('rut', $paciente->rut) }}" placeholder="12.345.678-9" oninput="formatRUT(this)" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Fecha de nacimiento -->
                        <div class="col-md-6 mb-3">
                            <label for="humanfrienndlydate" class="form-label fw-semibold">
                                <i class="ri-calendar-line me-1"></i>Fecha de Nacimiento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" placeholder="Seleccionar fecha de nacimiento" required>
                            </div>
                        </div>

                        <!-- Sexo -->
                        <div class="col-md-6 mb-3">
                            <label for="sexo" class="form-label fw-semibold">
                                <i class="ri-user-2-line me-1"></i>Sexo
                            </label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="">Seleccionar sexo</option>
                                <option value="Hombre" {{ old('sexo', $paciente->sexo) == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="Mujer" {{ old('sexo', $paciente->sexo) == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Curso -->
                        <div class="col-md-6 mb-3">
                            <label for="curso" class="form-label fw-semibold">
                                <i class="ri-graduation-cap-line me-1"></i>Curso
                            </label>
                            <select class="form-select" id="curso" name="curso" required>
                                <option value="">Seleccionar curso</option>
                                <option value="pre-kinder" {{ old('curso', $paciente->curso) == 'pre-kinder' ? 'selected' : '' }}>Pre-Kinder</option>
                                <option value="kinder" {{ old('curso', $paciente->curso) == 'kinder' ? 'selected' : '' }}>Kinder</option>
                                <option value="1° Básico" {{ old('curso', $paciente->curso) == '1° Básico' ? 'selected' : '' }}>1° Básico</option>
                                <option value="2° Básico" {{ old('curso', $paciente->curso) == '2° Básico' ? 'selected' : '' }}>2° Básico</option>
                                <option value="3° Básico" {{ old('curso', $paciente->curso) == '3° Básico' ? 'selected' : '' }}>3° Básico</option>
                                <option value="4° Básico" {{ old('curso', $paciente->curso) == '4° Básico' ? 'selected' : '' }}>4° Básico</option>
                                <option value="5° Básico" {{ old('curso', $paciente->curso) == '5° Básico' ? 'selected' : '' }}>5° Básico</option>
                                <option value="6° Básico" {{ old('curso', $paciente->curso) == '6° Básico' ? 'selected' : '' }}>6° Básico</option>
                                <option value="7° Básico" {{ old('curso', $paciente->curso) == '7° Básico' ? 'selected' : '' }}>7° Básico</option>
                                <option value="8° Básico" {{ old('curso', $paciente->curso) == '8° Básico' ? 'selected' : '' }}>8° Básico</option>
                                <option value="1° Medio" {{ old('curso', $paciente->curso) == '1° Medio' ? 'selected' : '' }}>1° Medio</option>
                                <option value="2° Medio" {{ old('curso', $paciente->curso) == '2° Medio' ? 'selected' : '' }}>2° Medio</option>
                                <option value="3° Medio" {{ old('curso', $paciente->curso) == '3° Medio' ? 'selected' : '' }}>3° Medio</option>
                                <option value="4° Medio" {{ old('curso', $paciente->curso) == '4° Medio' ? 'selected' : '' }}>4° Medio</option>
                            </select>
                        </div>

                        <!-- Colegio -->
                        <div class="col-md-6 mb-3">
                            <label for="colegio" class="form-label fw-semibold">
                                <i class="ri-school-line me-1"></i>Colegio
                            </label>
                            <input type="text" class="form-control" id="colegio" name="colegio" 
                                   value="{{ old('colegio', $paciente->colegio) }}" placeholder="Nombre del colegio" required>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="direccion" class="form-label fw-semibold">
                                <i class="ri-map-pin-line me-1"></i>Dirección
                            </label>
                            <input type="text" class="form-control" id="direccion" name="direccion" 
                                   value="{{ old('direccion', $paciente->direccion) }}" placeholder="Dirección completa" required>
                        </div>
                    </div>

                    <!-- Información Adicional del Paciente -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="info_adicional" class="form-label fw-semibold">
                                <i class="ri-file-text-line me-1"></i>Información Adicional
                                <span class="text-muted fw-normal">(Opcional)</span>
                            </label>
                            <textarea class="form-control" id="info_adicional" name="info_adicional" rows="4"
                                      placeholder="Escribe aquí cualquier información adicional sobre el alumno...">{{ old('info_adicional', $paciente->info_adicional) }}</textarea>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> Los cambios se guardarán automáticamente. Asegúrate de revisar toda la información antes de guardar.
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerPaciente">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="guardarBtnPaciente" onclick="document.getElementById('editPacienteForm').submit()">
                    <i class="ri-save-line me-1"></i>Guardar Cambios
                </button>
            </div>

        </div>
    </div>
</div>

<script>
        document.getElementById('editPacienteForm').addEventListener('submit', function() {
            // Ocultar el botón de guardar
            document.getElementById('guardarBtnPaciente').classList.add('d-none');
            // Mostrar el spinner
            document.getElementById('spinnerPaciente').classList.remove('d-none');
        });

</script>