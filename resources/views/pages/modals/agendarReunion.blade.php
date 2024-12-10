<!-- agendar Reunion -->
<div class="modal fade" id="agendarReunion" tabindex="-1" aria-labelledby="agendarReunionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="agendarReunionModal">Agendar Reunión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{ route('reuniones.create', $paciente->id_paciente) }}" method="POST" id="agendarReunionForm">
                    @csrf
        

                    <!-- Fecha -->
                    <div class="col-xl-12 mb-3">
                        <label for="humanfrienndlydate" class="form-label text-default">Fecha de la reunión</label>
                        <div class="form-group bg-outline-primary">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_reunion" placeholder="Seleccionar fecha reunión" required>
                            </div>
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_reunion" class="form-label text-default">Horario Reunión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="hora_reunion" name="hora_reunion" required>
                            <option value="">Seleccionar hora</option>
                            <option value="10:00,11:00">10:00 a 11:00</option>
                            <option value="11:00,12:00">11:00 a 12:00</option>
                            <option value="12:00,13:00">12:00 a 13:00</option>
                            <option value="13:00,14:00">13:00 a 14:00</option>
                            <option value="14:00,15:00">14:00 a 15:00</option>
                            <option value="15:00,16:00">15:00 a 16:00</option>
                        </select>
                    </div>

                    <!-- Valor -->
                    <div class="col-xl-12 mb-3">
                        <label for="valor_reunion" class="form-label text-default">Valor</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valor_reunion" name="valor_reunion" placeholder="Valor" required>
                    </div>


                
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerReunion">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnReunion">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        document.getElementById('agendarReunionForm').addEventListener('submit', function() {
            // Ocultar el botón de guardar
            document.getElementById('guardarBtnReunion').classList.add('d-none');
            // Mostrar el spinner
            document.getElementById('spinnerReunion').classList.remove('d-none');
        });

</script>