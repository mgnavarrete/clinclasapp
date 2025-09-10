<!-- agendar Sesion -->
<div class="modal fade" id="agendarSesionAnual" tabindex="-1" aria-labelledby="agendarSesionModalAnual" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendarSesionModalAnual">
                    <i class="ri-calendar-event-line me-2"></i>
                    Agregar Sesión Anual
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
                                            <i class="ri-calendar-event-line me-1"></i>Nueva sesión anual programada
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-success fs-12">
                                            <i class="ri-calendar-event-line me-1"></i>Sesión Anual
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <form action="{{ route('estado.createAnual', $paciente->id_paciente) }}" method="POST" id="agendarSesionFormAnual">
                    @csrf
        

                <!-- Campos del formulario -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">
                            <i class="ri-edit-line me-2"></i>
                            Configuración de la Sesión Anual
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <!-- Dia de la semana -->
                    <div class="col-md-6 mb-3">
                        <label for="dia" class="form-label text-default">
                            <i class="ri-calendar-line me-1"></i>Día de la semana
                        </label>
                        <select class="form-select form-select-lg bg-outline-primary" id="diaSesionAnual" name="diaSesionAnual" required>
                            <option value="">Seleccionar día</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miércoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Hora Inicio -->
                    <div class="col-md-6 mb-3">
                        <label for="hora_inicioSesionAnual" class="form-label text-default">
                            <i class="ri-time-line me-1"></i>Horario Inicio
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_inicioSesionAnual" name="hora_inicioSesionAnual" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_inicioSesionAnual" name="minuto_inicioSesionAnual" required>
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
                        <label for="hora_finSesionAnual" class="form-label text-default">
                            <i class="ri-time-fill me-1"></i>Horario Final
                        </label>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-lg bg-outline-primary" id="hora_finSesionAnual" name="hora_finSesionAnual" required>
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
                            <select class="form-select form-select-lg bg-outline-primary" id="minuto_finSesionAnual" name="minuto_finSesionAnual" required>
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
                    <!-- Tipo de sesión -->
                    <div class="col-md-6 mb-3">
                        <label for="tipoSesionAnual" class="form-label text-default">
                            <i class="ri-group-line me-1"></i>Tipo de sesión
                        </label>
                        <select class="form-select form-select-lg bg-outline-primary" id="tipoSesionAnual" name="tipoSesionAnual" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="individual">Individual</option>
                            <option value="grupal">Grupal</option>
                        </select>
                    </div>
                </div>

                <div class="row">

                </div>

                <div class="row">
                    <!-- Valor -->
                    <div class="col-md-6 mb-3">
                        <label for="valorSesionAnual" class="form-label text-default">
                            <i class="ri-money-dollar-circle-line me-1"></i>Valor
                        </label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valorSesionAnual" name="valorSesionAnual" placeholder="Valor de la sesión" oninput="formatCurrency(this)" required>
                    </div>

                    <!-- Year -->
                    <div class="col-md-6 mb-3">
                        <label for="yearSesionAnual" class="form-label text-default">
                            <i class="ri-calendar-2-line me-1"></i>Año
                        </label>
                        <select class="form-select form-select-lg bg-outline-primary" id="yearSesionAnual" name="yearSesionAnual" required>
                            <option value="{{ \Carbon\Carbon::now()->year }}">{{ \Carbon\Carbon::now()->year }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                        </select>
                    </div>
                </div>

                <!-- Alerta informativa -->
                <div class="alert alert-success">
                    <i class="ri-information-line me-2"></i>
                    <strong>Información:</strong> Esta sesión se programará de forma recurrente todos los días seleccionados durante el año especificado.
                </div>
                
                <div class="modal-footer">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAgendarSesionAnual">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-success" id="guardarBtnAgendarSesionAnual">
                            <i class="ri-save-line me-1"></i>Guardar Sesión Anual
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        document.getElementById('agendarSesionFormAnual').addEventListener('submit', function() {
            // Ocultar el botón de guardar
            document.getElementById('guardarBtnAgendarSesionAnual').classList.add('d-none');
            // Mostrar el spinner
            document.getElementById('spinnerAgendarSesionAnual').classList.remove('d-none');
        });

</script>