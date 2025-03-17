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
                    <!-- Hora Inicio Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_inicioReunion" class="form-label text-default">Horario Inicio Reunión</label>
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

                    <!-- Hora Fin Sesión-->
                    <div class="col-xl-12 mb-3">
                        <label for="hora_finReunion" class="form-label text-default">Horario Final Reunión</label>

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