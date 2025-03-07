<!-- agendar Sesion -->
<div class="modal fade" id="agendarSesion" tabindex="-1" aria-labelledby="agendarSesionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="agendarSesionModal">Agendar Sesion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{ route('estado.create', $paciente->id_paciente) }}" method="POST" id="agendarSesionForm">
                    @csrf
        

                    <!-- Fecha -->
                    <div class="col-xl-12 mb-3">
                        <label for="humanfrienndlydate" class="form-label text-default">Fecha de la sesión</label>
                        <div class="form-group bg-outline-primary">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_sesionAgendar" placeholder="Seleccionar fecha sesión" required>
                            </div>
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_sesionAgendar" class="form-label text-default">Horario Sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="hora_sesionAgendar" name="hora_sesionAgendar" required>
                            <option value="">Seleccionar hora</option>
                            <option value="08:30,09:15">08:30 a 09:15</option>
                            <option value="09:30,10:15">09:30 a 10:15</option>
                            <option value="10:30,11:15">10:30 a 11:15</option>
                            <option value="11:30,12:15">11:30 a 12:15</option>
                            <option value="12:30,13:15">12:30 a 13:15</option>
                            <option value="14:30,15:15">14:30 a 15:15</option>
                            <option value="15:30,16:30">15:30 a 16:30</option>
                        </select>
                    </div>
                    <!-- Notas -->
                    <div class="col-xl-12 mb-3">
                        <label for="notas_sesionAgendar" class="form-label text-default">Notas <span class="text-muted">(Opcional)</span></label>
                        <textarea class=" form-control form-control-lg bg-outline-primary mb-2" id="notas_sesionAgendar" name="notas_sesionAgendar" placeholder="Escribe aquí cualquier información adicional sobre la sesión"></textarea>
                    </div>


                
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAgendarSesion">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnAgendarSesion">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        document.getElementById('agendarSesionForm').addEventListener('submit', function() {
            // Ocultar el botón de guardar
            document.getElementById('guardarBtnAgendarSesion').classList.add('d-none');
            // Mostrar el spinner
            document.getElementById('spinnerAgendarSesion').classList.remove('d-none');
        });

</script>