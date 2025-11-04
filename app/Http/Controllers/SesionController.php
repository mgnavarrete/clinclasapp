<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Tutor;
use App\Models\Especialista;
use App\Models\Sesion;
use App\Models\EstadoSesion;
use Carbon\Carbon;
use App\Models\Pago;
use App\Models\PacienteEspecialista;

class SesionController extends Controller
{

    public function index()
    {

        return view('pages.sesiones.index');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'dia' => 'required|in:lunes,martes,miércoles,jueves,viernes',
            'hora_inicio' => 'required|string',
            'hora_fin' => 'required|string',
            'valor' => 'required|numeric|between:0,99999999.99',
            'tipoSesion' => 'required|in:individual,grupal',
            'year' => 'required|integer',
        ]);

        try {
            $sesion = Sesion::findOrFail($id);

            // Obtener datos originales para comparar cambios
            $diaOriginal = $sesion->dia_semana;
            $horaInicioOriginal = $sesion->hora_inicio;
            $horaFinalOriginal = $sesion->hora_final;

            // Actualizar la sesión base
            $sesion->update([
                'dia_semana' => $validatedData['dia'],
                'hora_inicio' => $validatedData['hora_inicio'],
                'hora_final' => $validatedData['hora_fin'],
                'valor' => $validatedData['valor'],
                'tipo' => $validatedData['tipoSesion'],
                'year' => $validatedData['year'],
            ]);

            // Verificar si hay cambios en día o horarios
            $cambiosDia = $diaOriginal !== $validatedData['dia'];
            $cambiosHorario = $horaInicioOriginal !== $validatedData['hora_inicio'] ||
                $horaFinalOriginal !== $validatedData['hora_fin'];

            logger()->info("Verificando cambios en sesión", [
                'sesion_id' => $sesion->id_sesion,
                'cambio_dia' => $cambiosDia,
                'cambio_horario' => $cambiosHorario,
                'dia_original' => $diaOriginal,
                'dia_nuevo' => $validatedData['dia'],
                'hora_inicio_original' => $horaInicioOriginal,
                'hora_inicio_nueva' => $validatedData['hora_inicio'],
                'hora_final_original' => $horaFinalOriginal,
                'hora_final_nueva' => $validatedData['hora_fin']
            ]);

            if ($cambiosDia || $cambiosHorario) {
                // Solo actualizar EstadoSesion futuros (desde hoy en adelante)
                $fechaHoy = Carbon::now()->startOfDay();

                // Contar EstadoSesion futuros antes de los cambios
                $estadosFuturos = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                    ->futuros($fechaHoy)
                    ->count();

                logger()->info("EstadoSesion futuros encontrados: $estadosFuturos");

                if ($cambiosDia) {
                    // Si cambió el día, eliminar EstadoSesion futuros del día anterior
                    $eliminados = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                        ->futuros($fechaHoy)
                        ->delete();

                    logger()->info("EstadoSesion futuros eliminados: $eliminados");

                    // Crear nuevos EstadoSesion para el nuevo día desde hoy hasta fin de año
                    $this->crearEstadoSesionFuturos($sesion, $validatedData, $fechaHoy);
                } else {
                    // Solo cambió horario, actualizar EstadoSesion futuros existentes
                    $actualizados = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                        ->futuros($fechaHoy)
                        ->update([
                            'hora_inicio' => $validatedData['hora_inicio'],
                            'hora_final' => $validatedData['hora_fin']
                        ]);

                    logger()->info("EstadoSesion futuros actualizados: $actualizados");
                }
            }

            return redirect()->route('pacientes.show', $sesion->id_paciente)
                ->with('success', 'Sesión actualizada correctamente. Los cambios se aplicaron a todas las sesiones futuras.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la sesión: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Error al actualizar la sesión. Favor intenta de nuevo.']);
        }
    }

    /**
     * Crear EstadoSesion futuros para una sesión
     */
    private function crearEstadoSesionFuturos($sesion, $validatedData, $fechaInicio)
    {
        $diaSemana = $validatedData['dia'];
        $year = $sesion->year;

        // Obtener el mes actual y el último mes del año
        $mesActual = Carbon::now()->month;
        $ultimoMes = 12;

        logger()->info("Creando EstadoSesion futuros", [
            'sesion_id' => $sesion->id_sesion,
            'dia_semana' => $diaSemana,
            'fecha_inicio' => $fechaInicio->toDateString(),
            'year' => $year
        ]);

        $contadorCreados = 0;

        // Iterar desde el mes actual hasta diciembre
        for ($mes = $mesActual; $mes <= $ultimoMes; $mes++) {
            // Establecer el primer y último día del mes
            $primerDiaMes = Carbon::create($year, $mes, 1);
            $ultimoDiaMes = $primerDiaMes->copy()->endOfMonth();

            // Asegurar que no creemos sesiones antes de la fecha de inicio
            if ($primerDiaMes->lt($fechaInicio)) {
                $primerDiaMes = $fechaInicio->copy();
            }

            // Iterar sobre los días del mes
            for ($fecha = $primerDiaMes; $fecha->lte($ultimoDiaMes); $fecha->addDay()) {
                // Verificar si el día de la semana coincide
                if ($fecha->locale('es')->translatedFormat('l') === $diaSemana) {
                    // Verificar que no exista ya un EstadoSesion para esta fecha
                    $existente = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                        ->where('fecha', $fecha->toDateString())
                        ->first();

                    if (!$existente) {
                        EstadoSesion::create([
                            'id_sesion' => $sesion->id_sesion,
                            'fecha' => $fecha->toDateString(),
                            'hora_inicio' => $validatedData['hora_inicio'],
                            'hora_final' => $validatedData['hora_fin'],
                            'estado' => 'pendiente',
                            'notas' => '',
                        ]);
                        $contadorCreados++;
                    }
                }
            }
        }

        logger()->info("EstadoSesion futuros creados: $contadorCreados");
    }

    public function generarAnual(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'dia' => 'required|in:lunes,martes,miércoles,jueves,viernes',
            'hora_inicio' => 'required|string',
            'hora_fin' => 'required|string',
            'valor' => 'required|numeric|between:0,99999999.99',
            'tipoSesion' => 'required|in:individual,grupal',
            'year' => 'required|integer',

        ]);
        try {
            $sesion = Sesion::findOrFail($id);

            $sesion->update([
                'dia_semana' => $validatedData['dia'],
                'hora_inicio' => $validatedData['hora_inicio'],
                'hora_fin' => $validatedData['hora_fin'],
                'valor' => $validatedData['valor'],
                'tipo' => $validatedData['tipoSesion'],
                'year' => $validatedData['year'],
            ]);

            // Obtener el día de la semana de la sesión creada
            $diaSemana = $validatedData['dia'];

            // Obtener el primer día del mes actual
            $fechaActual = Carbon::now();
            $primerDiaMes = $fechaActual->copy()->startOfMonth();
            // Obtener el último día del mes actual
            $ultimoDiaMes = $fechaActual->copy()->endOfMonth();
            echo "<script>console.log($sesion->id_sesion);</script>";
            // Iterar sobre los meses de marzo a diciembre
            for ($mes = 3; $mes <= 12; $mes++) {
                // Establecer el primer y último día del mes actual
                $primerDiaMes = Carbon::create($sesion->year, $mes, 1);
                $ultimoDiaMes = $primerDiaMes->copy()->endOfMonth();

                // Iterar sobre los días del mes actual
                for ($fecha = $primerDiaMes; $fecha->lte($ultimoDiaMes); $fecha->addDay()) {
                    // Verificar si el día de la semana coincide
                    if ($fecha->locale('es')->translatedFormat('l') === $diaSemana) {
                        // Crear un registro en EstadoSesion
                        EstadoSesion::create([
                            'id_sesion' => $sesion->id_sesion,
                            'fecha' => $fecha->toDateString(),
                            'hora_inicio' => $validatedData['hora_inicio'],
                            'hora_final' => $validatedData['hora_fin'],
                            'estado' => 'pendiente',
                            'notas' => '',
                        ]);
                    }
                }
            }

            return redirect()->route('pacientes.show', $sesion->id_paciente)->with('success', 'Sesión anual generada correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la sesión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la sesión. Favor intenta de nuevo.']);
        }
    }

    /**
     * Eliminar EstadoSesion futuros de una sesión (mantiene la sesión base y el historial)
     */
    public function delete($id)
    {
        try {
            $sesion = Sesion::findOrFail($id);
            $pacienteId = $sesion->id_paciente;

            logger()->info("Iniciando eliminación de citas futuras de sesión", [
                'sesion_id' => $sesion->id_sesion,
                'paciente_id' => $pacienteId,
                'dia_semana' => $sesion->dia_semana,
                'hora_inicio' => $sesion->hora_inicio
            ]);

            // Solo eliminar EstadoSesion futuros (desde hoy en adelante)
            $fechaHoy = Carbon::now()->startOfDay();

            // Contar EstadoSesion antes de eliminar
            $estadosFuturos = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                ->futuros($fechaHoy)
                ->count();

            $estadosPasados = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                ->pasados($fechaHoy)
                ->count();

            logger()->info("Estados encontrados", [
                'futuros' => $estadosFuturos,
                'pasados' => $estadosPasados
            ]);

            // Verificar si hay citas futuras para cancelar
            if ($estadosFuturos === 0) {
                logger()->info("No hay citas futuras para cancelar");
                return redirect()->back()
                    ->withErrors(['error' => 'Esta sesión ya no tiene citas futuras programadas para cancelar.']);
            }

            // Eliminar SOLO los EstadoSesion futuros
            $estadosParaEliminar = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                ->futuros($fechaHoy)
                ->get();

            logger()->info("Estados futuros a eliminar", [
                'count' => $estadosParaEliminar->count(),
                'fechas' => $estadosParaEliminar->pluck('fecha')->toArray()
            ]);

            $eliminados = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                ->futuros($fechaHoy)
                ->delete();

            logger()->info("EstadoSesion futuros eliminados: $eliminados");

            // SIEMPRE mantener la sesión base para evitar registros huérfanos
            // Marcar la sesión como inactiva para que no aparezca en nuevas programaciones
            $sesion->update([
                'dia_semana' => 'lunes', // Usar día válido (no importa cuál para sesiones canceladas)
                'hora_inicio' => '00:00:00', // Hora 00:00:00 indica sesión cancelada
                'hora_final' => '00:00:00',
                'tipo' => null // NULL indica sesión eliminada
            ]);

            logger()->info("Sesión marcada como eliminada (preservando integridad de datos)");

            // Mensaje personalizado según el contexto
            if ($estadosPasados > 0) {
                $mensaje = "Sesión eliminada correctamente. Se mantuvieron $estadosPasados sesiones pasadas en el historial.";
            } else {
                $mensaje = "Sesión eliminada correctamente. No había sesiones pasadas.";
            }

            if ($eliminados > 0) {
                $mensaje .= " Se cancelaron $eliminados citas futuras.";
            } else {
                $mensaje .= " No había citas futuras programadas.";
            }

            return redirect()->route('pacientes.show', $pacienteId)
                ->with('success', $mensaje);
        } catch (\Exception $e) {
            logger()->error('Error al eliminar la sesión: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la sesión: ' . $e->getMessage()]);
        }
    }
}
