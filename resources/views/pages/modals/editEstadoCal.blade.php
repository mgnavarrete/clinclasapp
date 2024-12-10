@foreach($estadoSesiones as $estado)
<!-- Editar Estado -->
<div class="modal fade" id="editEstado{{ $estado->id_estado }}" tabindex="-1" aria-labelledby="editEstadoModal{{ $estado->id_estado }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEstadoModal{{ $estado->id_estado }}">Editar Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('estado.updateCal', $estado->id_estado) }}" method="POST" id="formEditEstado{{ $estado->id_estado }}">
                    @csrf
                    <p class="fw-semibold mb-3 d-flex align-items-center">
                        <a><i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i></a>
                        {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($estado->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($estado->fecha)->translatedFormat('F')) }} a las {{ \Carbon\Carbon::parse($estado->hora_inicio)->format('H:i') }}
                    </p>
                    <div class="mb-3">
                        <label for="estado{{ $estado->id_estado }}" class="form-label">Estado Sesión:</label>
                        <select class="form-select" id="estado{{ $estado->id_estado }}" name="estado">
                            <option value="pendiente" {{ $estado->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="cancelada" {{ $estado->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="no avisó" {{ $estado->estado === 'no avisó' ? 'selected' : '' }}>No Avisó</option>
                            <option value="realizada" {{ $estado->estado === 'realizada' ? 'selected' : '' }}>Realizada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notas{{ $estado->id_estado }}" class="form-label">Notas:</label>
                        <textarea class="form-control" id="notas{{ $estado->id_estado }}" name="notas" rows="3">{{ $estado->notas }}</textarea>
                    </div>
            </div>

            <div class="modal-footer">
                <div class="spinner-border text-primary d-none" role="status" id="spinnerEditEstado{{ $estado->id_estado }}">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="submit" class="btn btn-secondary" id="guardarBtnEditEstado{{ $estado->id_estado }}">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById('formEditEstado{{ $estado->id_estado }}').addEventListener('submit', function() {
        document.getElementById('guardarBtnEditEstado{{ $estado->id_estado }}').classList.add('d-none');
        document.getElementById('spinnerEditEstado{{ $estado->id_estado }}').classList.remove('d-none');
    });
</script>
@endforeach