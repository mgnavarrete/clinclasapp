@foreach($pagosPaciente as $pago)
<!-- Editar Pago -->
<div class="modal fade" id="editPago{{ $pago->id_pago }}" tabindex="-1" aria-labelledby="editPagoModal{{ $pago->id_pago }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPagoModal{{ $pago->id_pago }}">Pago de {{ $pago->paciente->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pago.updatePac', $pago->id_pago) }}" method="POST" id="formEditPago{{ $pago->id_pago }}">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fw-semibold mb-3 d-flex align-items-center">
                            <a><i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i></a>
                     Mes de {{ ucfirst(\Carbon\Carbon::parse($pago->mes)->translatedFormat('F')) }} - {{ $pago->paciente->nombre }}
                    </p>
                    <a href="{{ route('pagos.show', $pago->id_pago) }}" class="fs-12 mb-0 text-secondary">Ver Detalles<i class="ti ti-chevron-right ms-1"></i></a>
                    </div>
                    <div class="mb-3">
                        <label for="estado{{ $pago->id_pago }}" class="form-label">Estado Pago:</label>
                        <select class="form-select" id="estado{{ $pago->id_pago }}" name="estado">
                            <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="atrasado" {{ $pago->estado === 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                            <option value="pagado" {{ $pago->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>

           
                </div>

                <div class="modal-footer">
                    <div class="spinner-border text-primary d-none" role="status" id="spinnerEditPago{{ $pago->id_pago }}">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="guardarBtnEditPago{{ $pago->id_pago }}">Guardar</button>
              
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
@endforeach