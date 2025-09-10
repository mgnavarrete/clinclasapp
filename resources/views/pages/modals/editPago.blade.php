@foreach($pagos as $pago)
<!-- Editar Pago -->
<div class="modal fade" id="editPago{{ $pago->id_pago }}" tabindex="-1" aria-labelledby="editPagoModal{{ $pago->id_pago }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPagoModal{{ $pago->id_pago }}">
                    <i class="ri-money-dollar-circle-line me-2"></i>
                    Editar Pago - {{ $pago->paciente->nombre }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pago.update', $pago->id_pago) }}" method="POST" id="formEditPago{{ $pago->id_pago }}">
                    @csrf
                    
                    <!-- Información del Pago -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>
                                        Información del Pago
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="fw-semibold mb-2 d-flex align-items-center">
                                                <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                                                Mes de {{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }} - {{ $pago->paciente->nombre }}
                                            </p>
                                            <p class="text-muted mb-0">
                                                <i class="ri-money-dollar-circle-line me-1"></i>Valor: ${{ number_format($pago->valor_total, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-gray fs-12"><a href="{{ route('pagos.show', $pago->id_pago) }}" class="fs-12 mt-2 text-secondary">
                                                Ver Detalles <i class="ri-external-link-line ms-1"></i>
                                            </a></span>
                                            <br>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos Editables -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">
                                <i class="ri-edit-line me-2"></i>
                                Editar Estado
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Estado del Pago -->
                        <div class="col-12 mb-3">
                            <label for="estado{{ $pago->id_pago }}" class="form-label fw-semibold">
                                <i class="ri-flag-line me-1"></i>Estado del Pago
                            </label>
                            <select class="form-select" id="estado{{ $pago->id_pago }}" name="estado" required>
                                <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="atrasado" {{ $pago->estado === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                <option value="pagado" {{ $pago->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                            </select>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Nota:</strong> El cambio de estado se guardará automáticamente. Si marcas como "Pagado", se registrará la fecha actual.
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerEditPago{{ $pago->id_pago }}">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" id="guardarBtnEditPago{{ $pago->id_pago }}" onclick="document.getElementById('formEditPago{{ $pago->id_pago }}').submit()">
                    <i class="ri-save-line me-1"></i>Guardar Cambios
                </button>
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
@endforeach