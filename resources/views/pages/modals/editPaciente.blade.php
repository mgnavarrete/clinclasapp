<!-- Editar Paciente -->
<div class="modal fade" id="editPaciente" tabindex="-1" aria-labelledby="editPacienteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="editPacienteModal">Editar Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{ route('pacientes.update', $paciente->id_paciente) }}" method="POST" id="editPacienteForm">
                    @csrf
                    <!-- Nombre -->
                    <div class="col-xl-12 mb-3">
                        <label for="nombre" class="form-label text-default ">Nombre</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre" name="nombre" placeholder="Nombre" required>
                    </div>

                    <!-- Fecha de nacimiento -->
                    <div class="col-xl-12 mb-3">
                        <label for="humanfrienndlydate" class="form-label text-default">Fecha de nacimiento</label>
                        <div class="form-group bg-outline-primary">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_nacimiento" placeholder="Seleccionar fecha de nacimiento" required>
                            </div>
                        </div>
                    </div>

                    <!-- Curso -->
                    <div class="col-xl-12 mb-3">
                        <label for="curso" class="form-label text-default">Curso</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="curso" name="curso" required>
                            <option value="">Seleccionar curso</option>
                            <option value="pre-kinder">Pre-Kinder</option>
                            <option value="kinder">Kinder</option>
                            <option value="1° Básico">1° Básico</option>
                            <option value="2° Básico">2° Básico</option>
                            <option value="3° Básico">3° Básico</option>
                            <option value="4° Básico">4° Básico</option>
                            <option value="5° Básico">5° Básico</option>
                            <option value="6° Básico">6° Básico</option>
                            <option value="7° Básico">7° Básico</option>
                            <option value="8° Básico">8° Básico</option>
                            <option value="1° Medio">1° Medio</option>
                            <option value="2° Medio">2° Medio</option>
                            <option value="3° Medio">3° Medio</option>
                            <option value="4° Medio">4° Medio</option>
                        </select>
                    </div>

                    <!-- Colegio -->
                    <div class="col-xl-12 mb-3">
                        <label for="colegio" class="form-label text-default">Colegio</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="colegio" name="colegio" placeholder="Colegio" required>
                    </div>


                    <!-- RUT formato 12.345.113-8 -->
                    <div class="col-xl-12 mb-3">
                        <label for="rut" class="form-label text-default">RUT</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="rut" name="rut" placeholder="RUT" oninput="formatRUT(this)" required>
                    </div>

                    <!-- Sexo -->
                    <div class="col-xl-12 mb-3">
                        <label for="sexo" class="form-label text-default">Sexo</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="sexo" name="sexo" required>
                            <option value="">Seleccionar sexo</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>

                    <!-- Dirección -->
                    <div class="col-xl-12 mb-3">
                        <label for="direccion" class="form-label text-default">Dirección</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="direccion" name="direccion" placeholder="Dirección" required>
                    </div>

                    <!-- Información Adicional del Paciente -->
                    <div class="col-xl-12 h-100">
                        <label for="info_adicional" class="form-label text-default mb-3">Información Adicional <span class="text-muted">(Opcional)</span></label>
                        <textarea class=" form-control form-control-lg bg-outline-primary mb-2" id="info_adicional" name="info_adicional" placeholder="Escribe aquí cualquier información adicional sobre el paciente"></textarea>
                    </div>

                
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerPaciente">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnPaciente">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </form>
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