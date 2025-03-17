<!-- Editar TUTORES -->
<div class="modal fade" id="editTutor" tabindex="-1" aria-labelledby="editTutorModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTutorModal">Editar Apoderado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <!-- Nombre -->
                    <div class="col-xl-12 mb-3">
                        <label for="nombre_tutor" class="form-label text-default ">Nombre</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="nombre_tutor" name="nombre_tutor" placeholder="Nombre" required>
                    </div>
                    <!-- Telefono -->
                    <div class="col-xl-12 mb-3">
                        <label for="telefono_tutor" class="form-label text-default ">Teléfono</label>
                        <input type="text" class="form-control form-control-lg bg-outline-primary" id="telefono_tutor" name="telefono_tutor" placeholder="Teléfono" oninput="addPrefix(this)" required>
                    </div>

                    <!-- Mail -->
                    <div class="col-xl-12 mb-3">
                        <label for="mail_tutor" class="form-label text-default ">Mail</label>
                        <input type="email" class="form-control form-control-lg bg-outline-primary" id="mail_tutor" name="mail_tutor" placeholder="Mail" required>
                    </div>

                    <div class="modal-footer">
                        <div class="spinner-border text-primary d-none" role="status" id="spinnerTutor">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="submit" class="btn btn-secondary">Guardar</button>
               
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editSesionForm').addEventListener('submit', function() {
             // Ocultar el botón de guardar
             document.getElementById('guardarBtnSesion').classList.add('d-none');
             // Mostrar el spinner
             document.getElementById('spinnerSesion').classList.remove('d-none');
         });
 </script>