<!-- Asignar Especialista -->
<div class="modal fade" id="asignarEspecialista" tabindex="-1" aria-labelledby="asignarEspecialistaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarEspecialistaModal">Asignar Especialista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('PE.create', $paciente->id_paciente) }}" method="POST" id="formAsignarEspecialista">
                    @csrf
                    <!-- Nombre -->
                    <div class="col-xl-12 mb-3">
                        <label for="id_especialista" class="form-label text-default ">Elije un Especialista</label>
                        <select class="form-select form-control-lg bg-outline-primary" id="id_especialista" name="id_especialista" required>
                            <option value="">Selecciona un Especialista</option>
                            @foreach ($especialistas as $especialista)
                                <option name="id_especialista" id="id_especialista" value="{{ $especialista->id_especialista }}">{{ $especialista->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerAsignarEspecialista">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnAsignarEspecialista">Asignar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('formAsignarEspecialista').addEventListener('submit', function() {
        document.getElementById('guardarBtnAsignarEspecialista').classList.add('d-none');
        document.getElementById('spinnerAsignarEspecialista').classList.remove('d-none');
    });
</script>