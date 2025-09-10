<!-- agendar Sesion -->
<div class="modal fade" id="agendarSesion" tabindex="-1" aria-labelledby="agendarSesionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendarSesionModal">
                    <i class="ri-calendar-event-line me-2"></i>
                    Agendar Sesión - {{ $paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('estado.create', $paciente->id_paciente) }}" method="POST" id="agendarSesionForm">
                    @csrf
                    
                    <!-- Información del Paciente -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información del Alumno
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

                    <!-- Campos de la Sesión -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-calendar-event-line me-2"></i>
                                Programar Sesión
                            </h6>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="humanfrienndlydate" class="form-label fw-semibold">
                                <i class="ri-calendar-line me-1"></i>Fecha de la Sesión
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_sesionAgendar" 
                                       placeholder="Seleccionar fecha de la sesión" required>
                            </div>
                        </div>
                    </div>

                    <!-- Horarios de la Sesión -->
                    <div class="row">
                        <!-- Hora Inicio Sesión-->
                        <div class="col-md-6 mb-3">
                            <label for="hora_inicioSesion" class="form-label fw-semibold">
                                <i class="ri-time-line me-1"></i>Horario de Inicio
                            </label>
                            <div class="d-flex gap-2">
                                <select class="form-select" id="hora_inicioSesion" name="hora_inicioSesion" required>
                                    <option value="">Hora</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                </select>
                                <select class="form-select" id="minuto_inicioSesion" name="minuto_inicioSesion" required>
                                    <option value="">Min</option>
                                    <option value="00">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hora Fin Sesión-->
                        <div class="col-md-6 mb-3">
                            <label for="hora_finSesion" class="form-label fw-semibold">
                                <i class="ri-time-line me-1"></i>Horario Final
                            </label>
                            <div class="d-flex gap-2">
                                <select class="form-select" id="hora_finSesion" name="hora_finSesion" required>
                                    <option value="">Hora</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                </select>
                                <select class="form-select" id="minuto_finSesion" name="minuto_finSesion" required>
                                    <option value="">Min</option>
                                    <option value="00">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notas -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="notas_sesionAgendar" class="form-label fw-semibold">
                                <i class="ri-file-text-line me-1"></i>Notas Adicionales
                                <span class="text-muted fw-normal">(Opcional)</span>
                            </label>
                            <textarea class="form-control" id="notas_sesionAgendar" name="notas_sesionAgendar" rows="4"
                                      placeholder="Escribe aquí cualquier información adicional sobre la sesión..."></textarea>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> La sesión se agendará para el alumno {{ $paciente->nombre }}. Verifica los horarios antes de confirmar.
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerAgendarSesion">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="guardarBtnAgendarSesion" onclick="document.getElementById('agendarSesionForm').submit()">
                    <i class="ri-calendar-check-line me-1"></i>Agendar Sesión
                </button>
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