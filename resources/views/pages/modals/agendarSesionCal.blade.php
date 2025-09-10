<!-- agendar Sesion -->
<div class="modal fade" id="agendarSesion" tabindex="-1" aria-labelledby="agendarSesionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendarSesionModal">
                    <i class="ri-calendar-event-line me-2"></i>
                    Agendar Sesión
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información general -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-calendar-event-line fs-16 me-2 text-primary"></i>
                                            Nueva Sesión desde Calendario
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-user-line me-1"></i>Selecciona el paciente y programa la sesión
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-success fs-12">
                                            <i class="ri-calendar-event-line me-1"></i>Sesión
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('calendario.createSesion') }}" method="POST" id="agendarSesionForm">
                    @csrf

                <!-- Campos del formulario -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="ri-edit-line me-2"></i>
                            Información de la Sesión
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <!-- Paciente -->
                    <div class="col-md-6 mb-3">
                        <label for="paciente_sesion" class="form-label text-default">
                            <i class="ri-user-line me-1"></i>Paciente
                        </label>
                        <select class="form-select form-select-lg bg-outline-primary" id="paciente_sesion" name="paciente_sesion" required>
                            <option value="">Seleccionar paciente</option>
                            @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id_paciente }}">{{ $paciente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div class="col-md-6 mb-3">
                        <label for="humanfrienndlydate" class="form-label text-default">
                            <i class="ri-calendar-line me-1"></i>Fecha de la sesión
                        </label>
                        <div class="form-group bg-outline-primary">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_sesionAgendar" placeholder="Seleccionar fecha sesión" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Hora Inicio -->
                    <div class="col-md-6 mb-3">
                        <label for="hora_inicioSesion" class="form-label text-default">
                            <i class="ri-time-line me-1"></i>Horario Inicio
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_inicioSesion" name="hora_inicioSesion" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_inicioSesion" name="minuto_inicioSesion" required>
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

                    <!-- Hora Final -->
                    <div class="col-md-6 mb-3">
                        <label for="hora_finSesion" class="form-label text-default">
                            <i class="ri-time-fill me-1"></i>Horario Final
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_finSesion" name="hora_finSesion" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_finSesion" name="minuto_finSesion" required>
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

                <div class="row">
                    <!-- Notas -->
                    <div class="col-12 mb-3">
                        <label for="notas_sesionAgendar" class="form-label text-default">
                            <i class="ri-file-text-line me-1"></i>Notas <span class="text-muted">(Opcional)</span>
                        </label>
                        <textarea class="form-control form-control-lg bg-outline-primary" id="notas_sesionAgendar" name="notas_sesionAgendar" rows="3" placeholder="Escribe aquí cualquier información adicional sobre la sesión"></textarea>
                    </div>
                </div>

                <!-- Alerta informativa -->
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    <strong>Información:</strong> La sesión será agendada para el paciente seleccionado en la fecha y horario especificados.
                </div>
                
                <div class="modal-footer">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAgendarSesion">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-success" id="guardarBtnAgendarSesion">
                            <i class="ri-save-line me-1"></i>Guardar Sesión
                        </button>
                    </div>
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