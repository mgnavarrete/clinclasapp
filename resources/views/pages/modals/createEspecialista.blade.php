<!-- Crear Especialista -->
<div class="modal fade" id="createEspecialista" tabindex="-1" aria-labelledby="createEspecialistaModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="createEspecialistaModal">Crear Especialista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('especialistas.create', $paciente->id_paciente) }}" method="POST" id="formCreateEspecialista">
                    @csrf
                    <!-- Nombre -->
                    <div class="col-xl-12 mb-3">
                        <label for="nombre_especialista" class="form-label text-default ">Nombre</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre_especialista" name="nombre_especialista" placeholder="Nombre" required>
                    </div>
                    <!-- Telefono -->
                    <div class="col-xl-12 mb-3">
                        <label for="telefono_especialista" class="form-label text-default ">Teléfono</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="telefono_especialista" name="telefono_especialista" placeholder="Teléfono" oninput="addPrefix(this)" required>
                    </div>

                    <!-- Mail -->
                    <div class="col-xl-12 mb-3">
                        <label for="mail_especialista" class="form-label text-default ">Mail</label>
                        <input type="email" class="form-control form-control-lg bg-outline-primary" id="mail_especialista" name="mail_especialista" placeholder="Mail" required>
                    </div>

                    <!-- Especialidad -->
                    <div class="col-xl-12 mb-3">
                        <label for="especialidad_especialista" class="form-label text-default ">Especialidad</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="especialidad_especialista" name="especialidad_especialista" placeholder="Especialidad" required>
                    </div>


                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerCreateEspecialista">   
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary" id="guardarBtnCreateEspecialista">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    document.getElementById('formCreateEspecialista').addEventListener('submit', function() {
        document.getElementById('guardarBtnCreateEspecialista').classList.add('d-none');
        document.getElementById('spinnerCreateEspecialista').classList.remove('d-none');
    });
</script>