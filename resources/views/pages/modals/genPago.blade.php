<!-- Generar Pagos -->
<div class="modal fade" id="genPagos" tabindex="-1" aria-labelledby="genPagosModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="genPagosModal">
                    <i class="ri-money-dollar-circle-line me-2"></i>
                    Generar Pagos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información de generación -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-file-add-line fs-16 me-2 text-primary"></i>
                                            Generación Automática de Pagos
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-calendar-line me-1"></i>Selecciona el mes y año para generar los pagos correspondientes
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-success fs-12">
                                            <i class="ri-money-dollar-circle-line me-1"></i>Generación
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('pago.create') }}" method="POST" id="fromGenPagos">
                    @csrf
                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-settings-line me-2"></i>
                                Configuración de Generación
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Mes -->
                        <div class="col-md-6 mb-3">
                            <label for="mes" class="form-label text-default">
                                <i class="ri-calendar-line me-1"></i>Mes
                            </label>
                            <select class="form-select form-select-lg bg-outline-primary" id="mes" name="mes" required>
                                <option value="">Seleccione un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        
                        <!-- Año -->
                        <div class="col-md-6 mb-3">
                            <label for="year" class="form-label text-default">
                                <i class="ri-calendar-2-line me-1"></i>Año
                            </label>
                            <select class="form-select form-select-lg bg-outline-primary" id="year" name="year" required>
                                <option value="{{ \Carbon\Carbon::now()->year - 1 }}">{{ \Carbon\Carbon::now()->year - 1 }}</option>
                                <option value="{{ \Carbon\Carbon::now()->year }}" selected>{{ \Carbon\Carbon::now()->year }}</option>
                                <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                                <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alerta informativa -->
                    <div class="alert alert-success">
                        <i class="ri-information-line me-2"></i>
                        <strong>Proceso Automático:</strong> Se generarán los pagos para todos los pacientes activos del mes seleccionado.
                        <br>
                        <small class="mt-2 d-block">
                            <i class="ri-check-line me-1"></i>Se calcularán las sesiones realizadas y no avisadas
                            <br>
                            <i class="ri-check-line me-1"></i>Se incluirán las reuniones del mes
                            <br>
                            <i class="ri-check-line me-1"></i>Se generará un registro de pago por paciente
                        </small>
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerGenPagos">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-success" id="guardarBtnGenPagos">
                                <i class="ri-file-add-line me-1"></i>Generar Pagos
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('fromGenPagos').addEventListener('submit', function() {
        document.getElementById('guardarBtnGenPagos').classList.add('d-none');
        document.getElementById('spinnerGenPagos').classList.remove('d-none');
    });
</script>

