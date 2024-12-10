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
                    <!-- Dia de la semana -->
                    <div class="col-xl-12 mb-3">
                        <label for="dia_semana" class="form-label text-default">Día de la semana</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="dia_semana" name="dia_semana" required>
                            <option value="">Seleccionar día</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miércoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Hora -->
                    <div class="col-xl-12 mb-3">
                        <label for="hora" class="form-label text-default">Horario Sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="hora" name="hora" required>
                            <option value="">Seleccionar hora</option>
                            <option value="09:30,10:15">09:30 a 10:15</option>
                            <option value="10:30,11:15">10:30 a 11:15</option>
                            <option value="11:30,12:15">11:30 a 12:15</option>
                            <option value="12:30,13:15">12:30 a 13:15</option>
                            <option value="14:30,15:15">14:30 a 15:15</option>
                            <option value="15:30,16:30">15:30 a 16:30</option>
                        </select>
                    </div>

                    <!-- Tipo de sesión -->
                    <div class="col-xl-12 mb-3">
                        <label for="tipo" class="form-label text-default">Tipo de sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="tipo" name="tipo" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="individual">Individual</option>
                            <option value="grupal">Grupal</option>
                        </select>
                    </div>

                    <!-- Valor-->
                    <div class="col-xl-12 mb-3">
                        <label for="valor" class="form-label text-default">Valor</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valor" name="valor" placeholder="Valor"  required>
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