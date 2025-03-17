<!-- agendar Sesion -->
<div class="modal fade" id="agendarSesionAnual" tabindex="-1" aria-labelledby="agendarSesionModalAnual" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="agendarSesionModalAnual">Agregar Sesion Anual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{ route('estado.createAnual', $paciente->id_paciente) }}" method="POST" id="agendarSesionFormAnual">
                    @csrf
        

                    <!-- Dia de la semana -->
                    <div class="col-xl-12 mb-3">
                        <label for="dia" class="form-label text-default">Día de la semana</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="diaSesionAnual" name="diaSesionAnual" required>
                            <option value="">Seleccionar día</option>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miércoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Hora -->
                    <!-- Hora Inicio Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_inicioSesionAnual" class="form-label text-default">Horario Inicio Sesión</label>
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

                    <!-- Hora Fin Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_finSesionAnual" class="form-label text-default">Horario Final Sesión</label>

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
                    <div class="col-xl-12 mb-3">
                        <label for="tipoSesionAnual" class="form-label text-default">Tipo de sesión</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="tipoSesionAnual" name="tipoSesionAnual" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="individual">Individual</option>
                            <option value="grupal">Grupal</option>
                        </select>
                    </div>

                    <!-- Valor-->
                    <div class="col-xl-12 mb-3">
                        <label for="valorSesionAnual" class="form-label text-default">Valor</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="valorSesionAnual" name="valorSesionAnual" placeholder="Valor" oninput="formatCurrency(this)" required>
                    </div>

                    <!-- Year -->
                    <div class="col-xl-12 mb-3">
                        <label for="yearSesionAnual"    class="form-label text-default">Año</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="yearSesionAnual" name="yearSesionAnual" required>
                            <option value="{{ \Carbon\Carbon::now()->year }}">{{ \Carbon\Carbon::now()->year }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                        </select>
                    </div>

               

                
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAgendarSesionAnual">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnAgendarSesionAnual">Guardar</button>
                        
                        
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