@foreach($reuniones as $reunion)
<!-- Editar Reunion -->
<div class="modal fade" id="editReunion{{ $reunion->id_reunion }}" tabindex="-1" aria-labelledby="editReunionModal{{ $reunion->id_reunion }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReunionModal{{ $reunion->id_reunion }}">Reunión de {{ $reunion->paciente->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reuniones.update', $reunion->id_reunion) }}" method="POST" id="formEditReunion{{ $reunion->id_reunion }}">
                    @csrf
                    <p class="fw-semibold mb-3 d-flex align-items-center">
                        <a><i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i></a>
                        {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('l')) }} {{ \Carbon\Carbon::parse($reunion->fecha)->format('j') }} de {{ ucfirst(\Carbon\Carbon::parse($reunion->fecha)->translatedFormat('F')) }} a las {{ \Carbon\Carbon::parse($reunion->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reunion->hora_final)->format('H:i') }}
                    </p>
                    <div class="mb-3">
                        <label for="estado{{ $reunion->id_reunion }}" class="form-label">Estado Reunión:</label>
                        <select class="form-select" id="estado{{ $reunion->id_reunion }}" name="estado">
                            <option value="pendiente" {{ $reunion->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="cancelada" {{ $reunion->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="realizada" {{ $reunion->estado === 'realizada' ? 'selected' : '' }}>Realizada</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="spinner-border text-primary d-none" role="status" id="spinnerEditReunion{{ $reunion->id_reunion }}">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="guardarBtnEditReunion{{ $reunion->id_reunion }}">Guardar</button>
                 
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('formEditReunion{{ $reunion->id_reunion }}').addEventListener('submit', function() {
        document.getElementById('guardarBtnEditReunion{{ $reunion->id_reunion }}').classList.add('d-none');
        document.getElementById('spinnerEditReunion{{ $reunion->id_reunion }}').classList.remove('d-none');
    });
</script>
@endforeach