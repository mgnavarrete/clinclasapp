<!-- agendar Reunion -->
<div class="modal fade" id="agendarReunion" tabindex="-1" aria-labelledby="agendarReunionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendarReunionModal">
                    <i class="ri-team-line me-2"></i>
                    Agendar Reunión
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del paciente -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-user-line fs-16 me-2 text-primary"></i>
                                            {{ $paciente->nombre }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-calendar-event-line me-1"></i>Nueva reunión programada
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-primary fs-12">
                                            <i class="ri-team-line me-1"></i>Reunión
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <form action="{{ route('reuniones.create', $paciente->id_paciente) }}" method="POST" id="agendarReunionForm">
                    @csrf
        

                <!-- Campos del formulario -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="ri-edit-line me-2"></i>
                            Información de la Reunión
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <!-- Fecha -->
                    <div class="col-md-6 mb-3">
                        <label for="humanfrienndlydate" class="form-label text-default">
                            <i class="ri-calendar-line me-1"></i>Fecha de la reunión
                        </label>
                        <div class="form-group bg-outline-primary">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                <input type="text" class="form-control" id="humanfrienndlydate" name="fecha_reunion" placeholder="Seleccionar fecha reunión" required>
                            </div>
                        </div>
                    </div>

                    <!-- Valor -->
                    <div class="col-md-6 mb-3">
                        <label for="valor_reunion" class="form-label text-default">
                            <i class="ri-money-dollar-circle-line me-1"></i>Valor
                        </label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valor_reunion" name="valor_reunion" placeholder="Valor de la reunión" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Hora Inicio -->
                    <div class="col-md-6 mb-3">
                        <label for="hora_inicioReunion" class="form-label text-default">
                            <i class="ri-time-line me-1"></i>Horario Inicio
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_inicioReunion" name="hora_inicioReunion" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_inicioReunion" name="minuto_inicioReunion" required>
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
                        <label for="hora_finReunion" class="form-label text-default">
                            <i class="ri-time-fill me-1"></i>Horario Final
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_finReunion" name="hora_finReunion" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_finReunion" name="minuto_finReunion" required>
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

                <!-- Alerta informativa -->
                <div class="alert alert-info">
                    <i class="ri-information-line me-2"></i>
                    <strong>Información:</strong> La reunión será agendada para la fecha y horario seleccionados.
                </div>
                
                <div class="modal-footer">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerReunion">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="guardarBtnReunion">
                            <i class="ri-save-line me-1"></i>Guardar Reunión
                        </button>
                    </div>
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