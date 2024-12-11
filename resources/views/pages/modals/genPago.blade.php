<!-- Generar Pagos -->
<div class="modal fade" id="genPagos" tabindex="-1" aria-labelledby="genPagosModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="genPagosModal">Generar Pagos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pago.create') }}" method="POST" id="fromGenPagos">
                    @csrf
                    <div class="mb-3">
                        <label for="mes" class="form-label text-default">Seleccione el mes para generar los pagos:</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="mes" name="mes">
                            <option value="">Seleccione un mes</option>
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
                    <!-- Year -->
                    <div class="col-xl-12 mb-3">
                        <label for="year"    class="form-label text-default">Año</label>
                        <select class="form-select form-select-lg bg-outline-primary" id="year" name="year" required>
                            <option value="{{ \Carbon\Carbon::now()->year }}">{{ \Carbon\Carbon::now()->year }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 1 }}">{{ \Carbon\Carbon::now()->year + 1 }}</option>
                            <option value="{{ \Carbon\Carbon::now()->year + 2 }}">{{ \Carbon\Carbon::now()->year + 2 }}</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerGenPagos">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnGenPagos">Generar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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

