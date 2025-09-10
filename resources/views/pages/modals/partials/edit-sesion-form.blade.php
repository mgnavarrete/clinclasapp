<form action="{{ route('sesiones.update', $sesion->id_sesion) }}" method="POST" id="editSesionForm{{ $sesion->id_sesion }}" class="edit-sesion-form">
    @csrf
    
    <!-- Información de la Sesión -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="ri-information-line me-2"></i>
                        Información de la Sesión {{ isset($index) ? $index + 1 : '' }}
                    </h6>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="fw-semibold mb-2 d-flex align-items-center">
                                <i class="ri-bookmark-fill fs-16 me-2 text-primary"></i>
                                {{ ucfirst($sesion->dia_semana) }} - {{ $sesion->tipo }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="ri-time-line me-1"></i>{{ $sesion->hora_inicio }} a {{ $sesion->hora_final }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-secondary fs-12 mb-1">ID: {{ $sesion->id_sesion }}</span>
                            <br>
                            @php
                                $fechaHoy = \Carbon\Carbon::now()->startOfDay();
                                $citasFuturasInfo = \App\Models\EstadoSesion::where('id_sesion', $sesion->id_sesion)
                                    ->whereDate('fecha', '>=', $fechaHoy)
                                    ->count();
                            @endphp
                            @if($citasFuturasInfo > 0)
                                <span class="badge bg-success fs-11">
                                    <i class="ri-calendar-check-line me-1"></i>{{ $citasFuturasInfo }} citas futuras
                                </span>
                            @else
                                <span class="badge bg-warning fs-11">
                                    <i class="ri-calendar-close-line me-1"></i>Sin citas futuras
                                </span>
                            @endif
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
                Editar Información
            </h6>
        </div>
    </div>

    <div class="row">
        <!-- Día de la semana -->
        <div class="col-md-6 mb-3">
            <label for="dia{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-calendar-line me-1"></i>Día de la Semana
            </label>
            <select class="form-select" id="dia{{ $sesion->id_sesion }}" name="dia" required>
                <option value="">Seleccionar día</option>
                <option value="lunes" {{ old('dia', $sesion->dia_semana) == 'lunes' ? 'selected' : '' }}>Lunes</option>
                <option value="martes" {{ old('dia', $sesion->dia_semana) == 'martes' ? 'selected' : '' }}>Martes</option>
                <option value="miércoles" {{ old('dia', $sesion->dia_semana) == 'miércoles' ? 'selected' : '' }}>Miércoles</option>
                <option value="jueves" {{ old('dia', $sesion->dia_semana) == 'jueves' ? 'selected' : '' }}>Jueves</option>
                <option value="viernes" {{ old('dia', $sesion->dia_semana) == 'viernes' ? 'selected' : '' }}>Viernes</option>
            </select>
        </div>

        <!-- Tipo de sesión -->
        <div class="col-md-6 mb-3">
            <label for="tipoSesion{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-group-line me-1"></i>Tipo de Sesión
            </label>
            <select class="form-select" id="tipoSesion{{ $sesion->id_sesion }}" name="tipoSesion" required>
                <option value="">Seleccionar tipo</option>
                <option value="individual" {{ old('tipoSesion', $sesion->tipo) == 'individual' ? 'selected' : '' }}>Individual</option>
                <option value="grupal" {{ old('tipoSesion', $sesion->tipo) == 'grupal' ? 'selected' : '' }}>Grupal</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Hora Inicio Sesión-->
        <div class="col-md-6 mb-3">
            <label for="hora_inicio{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-time-line me-1"></i>Horario de Inicio
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="ri-time-line"></i></span>
                <input type="text" class="form-control flatpickr-input time-picker" id="hora_inicio{{ $sesion->id_sesion }}" 
                       value="{{ old('hora_inicio', $sesion->hora_inicio) }}" placeholder="Elige Hora Inicio" name="hora_inicio" readonly="readonly" required>
            </div>
        </div>

        <!-- Hora Fin Sesión-->
        <div class="col-md-6 mb-3">
            <label for="hora_fin{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-time-line me-1"></i>Horario Final
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="ri-time-line"></i></span>
                <input type="text" class="form-control flatpickr-input time-picker" id="hora_fin{{ $sesion->id_sesion }}" 
                       value="{{ old('hora_fin', $sesion->hora_final) }}" placeholder="Elige Hora Final" name="hora_fin" readonly="readonly" required>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Valor-->
        <div class="col-md-6 mb-3">
            <label for="valor{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-money-dollar-circle-line me-1"></i>Valor de la Sesión
            </label>
            <input type="text" class="form-control" id="valor{{ $sesion->id_sesion }}" name="valor" 
                   value="{{ old('valor', $sesion->valor) }}" placeholder="$0" oninput="formatCurrency(this)" required>
        </div>

        <!-- Year -->
        <div class="col-md-6 mb-3">
            <label for="year{{ $sesion->id_sesion }}" class="form-label fw-semibold">
                <i class="ri-calendar-check-line me-1"></i>Año
            </label>
            <select class="form-select" id="year{{ $sesion->id_sesion }}" name="year" required>
                <option value="{{ \Carbon\Carbon::now()->year }}" {{ old('year', $sesion->year) == \Carbon\Carbon::now()->year ? 'selected' : '' }}>{{ \Carbon\Carbon::now()->year }}</option>
                <option value="{{ \Carbon\Carbon::now()->year + 1 }}" {{ old('year', $sesion->year) == \Carbon\Carbon::now()->year + 1 ? 'selected' : '' }}>{{ \Carbon\Carbon::now()->year + 1 }}</option>
                <option value="{{ \Carbon\Carbon::now()->year + 2 }}" {{ old('year', $sesion->year) == \Carbon\Carbon::now()->year + 2 ? 'selected' : '' }}>{{ \Carbon\Carbon::now()->year + 2 }}</option>
            </select>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="ri-information-line me-2"></i>
                <strong>Nota:</strong> Los cambios se aplicarán a todas las sesiones futuras (desde hoy en adelante). Las sesiones pasadas se mantendrán intactas.
            </div>
        </div>
    </div>

    <!-- Footer del formulario -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Botón de eliminar a la izquierda -->
                <div>
                    @php
                        $fechaHoy = \Carbon\Carbon::now()->startOfDay();
                        $citasFuturas = \App\Models\EstadoSesion::where('id_sesion', $sesion->id_sesion)
                            ->whereDate('fecha', '>=', $fechaHoy)
                            ->count();
                    @endphp
                    
                    @if($citasFuturas > 0)
                        <button type="button" class="btn btn-danger" id="eliminarBtnSesion{{ $sesion->id_sesion }}" 
                                onclick="confirmarEliminacionSesion({{ $sesion->id_sesion }}, '{{ $sesion->dia_semana }}', '{{ $sesion->hora_inicio }}')">
                            <i class="ri-calendar-close-line me-1"></i>Cancelar Sesión
                            <span class="badge bg-white text-danger ms-1">{{ $citasFuturas }}</span>
                        </button>
                    @else
                        <button type="button" class="btn btn-outline-secondary" disabled title="No hay citas futuras para cancelar">
                            <i class="ri-calendar-close-line me-1"></i>Sin Citas Futuras
                        </button>
                    @endif
                </div>
                
                <!-- Botones de acción a la derecha -->
                <div class="d-flex gap-2 align-items-center">
                    <div class="spinner-border text-primary d-none" role="status" id="spinnerSesion{{ $sesion->id_sesion }}">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" id="guardarBtnSesion{{ $sesion->id_sesion }}">
                        <i class="ri-save-line me-1"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configurar time pickers para esta sesión específica
    const horaInicio = document.getElementById('hora_inicio{{ $sesion->id_sesion }}');
    const horaFin = document.getElementById('hora_fin{{ $sesion->id_sesion }}');
    
    if (horaInicio && typeof flatpickr !== 'undefined') {
        flatpickr(horaInicio, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    }
    
    if (horaFin && typeof flatpickr !== 'undefined') {
        flatpickr(horaFin, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    }
    
    // Manejar envío del formulario
    const form = document.getElementById('editSesionForm{{ $sesion->id_sesion }}');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('guardarBtnSesion{{ $sesion->id_sesion }}');
            const spinner = document.getElementById('spinnerSesion{{ $sesion->id_sesion }}');
            
            if (btn && spinner) {
                btn.classList.add('d-none');
                spinner.classList.remove('d-none');
            }
            
            // Enviar formulario
            this.submit();
        });
    }
});

// Función global para confirmar eliminación de sesión
if (typeof confirmarEliminacionSesion === 'undefined') {
    window.confirmarEliminacionSesion = function(sesionId, diaSemana, horaInicio) {
        // Crear modal de confirmación personalizado
        const confirmModal = `
            <div class="modal fade" id="confirmDeleteModal${sesionId}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="ri-alert-line me-2"></i>
                                Confirmar Cancelación de Sesión
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-3">
                                <i class="ri-calendar-close-line fs-48 text-danger mb-3"></i>
                                <h6 class="fw-bold">¿Estás seguro de cancelar esta sesión?</h6>
                            </div>
                            <div class="alert alert-warning">
                                <strong>Sesión a cancelar:</strong><br>
                                <i class="ri-calendar-line me-1"></i> ${diaSemana.charAt(0).toUpperCase() + diaSemana.slice(1)} a las ${horaInicio}
                            </div>
                            <div class="alert alert-danger">
                                <i class="ri-information-line me-2"></i>
                                <strong>Atención:</strong> Esta acción:
                                <ul class="mb-0 mt-2">
                                    <li><strong>Cancelará</strong> todas las citas futuras (desde hoy en adelante)</li>
                                    <li><strong>Desactivará</strong> la programación de nuevas citas</li>
                                    <li><strong>Mantendrá</strong> el historial de sesiones pasadas</li>
                                    <li><strong>Preservará</strong> la integridad de los datos</li>
                                </ul>
                                <br>
                                <small class="text-muted"><i class="ri-shield-check-line me-1"></i>La sesión base se mantiene para evitar registros huérfanos.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Cancelar
                            </button>
                            <button type="button" class="btn btn-danger" onclick="ejecutarEliminacionSesion(${sesionId})">
                                <i class="ri-delete-bin-line me-1"></i>Sí, Cancelar Citas Futuras
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Agregar modal al DOM si no existe
        if (!document.getElementById(`confirmDeleteModal${sesionId}`)) {
            document.body.insertAdjacentHTML('beforeend', confirmModal);
        }
        
        // Mostrar modal de confirmación
        const modal = new bootstrap.Modal(document.getElementById(`confirmDeleteModal${sesionId}`));
        modal.show();
    };
}

// Función para ejecutar la eliminación
if (typeof ejecutarEliminacionSesion === 'undefined') {
    window.ejecutarEliminacionSesion = function(sesionId) {
        // Crear formulario de eliminación dinámico
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/sesiones/${sesionId}/delete`;
        
        // Token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // Método DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        
        // Enviar formulario
        form.submit();
    };
}
</script>
