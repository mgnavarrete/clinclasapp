<!-- Editar Sesion -->
<div class="modal fade" id="editSesion" tabindex="-1" aria-labelledby="editSesionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSesionModal">Editar Sesion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sesiones.update', $sesion->id_sesion) }}" method="POST" id="editSesionForm">
                    @csrf
                    <div class="col-xl-12 mb-3">
                        <label for="dia" class="form-label text-default">Día de la semana</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="dia" name="dia" required>
                            <option value="">Seleccionar día</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miércoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Hora Inicio Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_inicio" class="form-label text-default">Horario Inicio Sesión</label>
                    
                        <div class="input-group">
                            <div class="input-group-text text-muted"> <i class="ri-time-line"></i> </div>
                            <input type="text" class="form-control flatpickr-input active" id="timepickr1" placeholder="Elige Hora Inicio" name="hora_inicio" readonly="readonly">
                        </div>
                       
                    </div>

                    <!-- Hora Fin Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_fin" class="form-label text-default">Horario Final Sesión</label>
                        <div class="input-group">
                            <div class="input-group-text text-muted"> <i class="ri-time-line"></i> </div>
                            <input type="text" class="form-control flatpickr-input active" id="timepickr1" placeholder="Elige Hora Final" name="hora_fin" readonly="readonly">
                        </div>
                    </div>

                    <!-- Tipo de sesión -->
                    <div class="col-xl-12 mb-3">
                        <label for="tipoSesion" class="form-label text-default">Tipo de sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="tipoSesion" name="tipoSesion" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="individual">Individual</option>
                            <option value="grupal">Grupal</option>
                        </select>
                    </div>

                    <!-- Valor-->
                    <div class="col-xl-12 mb-3">
                        <label for="valor" class="form-label text-default">Valor</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valor" name="valor" placeholder="Valor" oninput="formatCurrency(this)" required>
                    </div>

                    <!-- Year -->
                    <div class="col-xl-12 mb-3">
                        <label for="year"    class="form-label text-default">Año</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="year" name="year" required>
                            <option value="{{ \Carbon\Carbon::now()->year }}">{{ \Carbon\Carbon::now()->year }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerSesion">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnSesion">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   document.getElementById('editSesionForm').addEventListener('submit', function() {
            // Ocultar el botón de guardar
            document.getElementById('guardarBtnSesion').classList.add('d-none');
            // Mostrar el spinner
            document.getElementById('spinnerSesion').classList.remove('d-none');
        });
</script>