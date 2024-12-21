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
}
