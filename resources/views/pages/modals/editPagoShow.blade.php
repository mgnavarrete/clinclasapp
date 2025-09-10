<!-- Editar Pago -->
<div class="modal fade" id="editPago{{ $pago->id_pago }}" tabindex="-1" aria-labelledby="editPagoModal{{ $pago->id_pago }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPagoModal{{ $pago->id_pago }}">
                    <i class="ri-money-dollar-circle-line me-2"></i>
                    Pago de {{ $pago->paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del pago -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 d-flex align-items-center">
                                            <i class="ri-user-line fs-16 me-2 text-primary"></i>
                                            {{ $pago->paciente->nombre }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="ri-calendar-line me-1"></i>
                                            Mes de {{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }}
                                            <br>
                                            <i class="ri-money-dollar-circle-line me-1"></i>
                                            Valor: ${{ number_format($pago->valor_total, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @php
                                            $badgeClass = match($pago->estado) {
                                                'pendiente' => 'bg-warning',
                                                'pagado' => 'bg-success',
                                                'atrasado' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-12">
                                            <i class="ri-bookmark-line me-1"></i>{{ ucfirst($pago->estado) }}
                                        </span>
                                        <br>
                                        <small class="text-muted">Vista detalle</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('pago.updateShow', $pago->id_pago) }}" method="POST" id="formEditPago{{ $pago->id_pago }}">
                    @csrf
                    
                    <!-- Campos del formulario -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Actualizar Estado del Pago
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado del Pago -->
                        <div class="col-md-6 mb-3">
                            <label for="estado{{ $pago->id_pago }}" class="form-label text-default">
                                <i class="ri-bookmark-line me-1"></i>Estado del Pago
                            </label>
                            <select class="form-select form-select-lg bg-outline-primary" id="estado{{ $pago->id_pago }}" name="estado">
                                <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="atrasado" {{ $pago->estado === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                <option value="pagado" {{ $pago->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="ri-file-text-line fs-24 text-info mb-2"></i>
                                    <p class="text-muted small mb-0">Vista de detalle</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerta informativa -->
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>Vista Detalle:</strong> Los cambios se aplicarán al registro de pago y serán visibles en el resumen.
                    </div>
                    
                    <div class="modal-footer">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="spinnerEditPago{{ $pago->id_pago }}">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-info" id="guardarBtnEditPago{{ $pago->id_pago }}">
                                <i class="ri-save-line me-1"></i>Actualizar Pago
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('formEditPago{{ $pago->id_pago }}').addEventListener('submit', function() {
        document.getElementById('guardarBtnEditPago{{ $pago->id_pago }}').classList.add('d-none');
        document.getElementById('spinnerEditPago{{ $pago->id_pago }}').classList.remove('d-none');
    });
</script>