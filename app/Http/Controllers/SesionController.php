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

        $validatedData = $request->validate([
            'dia_semana' => 'required|in:lunes,martes,miércoles,jueves,viernes',
            'hora' => 'required|date_format:H:i',
            'tipo' => 'required|in:individual,grupal',
            'valor' => 'required|numeric|between:0,99999999.99',
        ]);



        try {
            $sesion = Sesion::findOrFail($id);

            $sesion->update([
                'dia_semana' => $validatedData['dia_semana'],
                'hora' => $validatedData['hora'],
                'valor' => $validatedData['valor'],
                'tipo' => $validatedData['tipo'],
            ]);



            // Obtener el día de la semana de la sesión creada
            $diaSemana = $sesion->dia_semana;

            // Obtener el primer día del mes actual
            $fechaActual = Carbon::now();
            $primerDiaMes = $fechaActual->copy()->startOfMonth();

            // Obtener el último día del mes actual
            $ultimoDiaMes = $fechaActual->copy()->endOfMonth();

            // Eliminar registros existentes de EstadoSesion para la sesión que tengan estado 'pendiente' y sean del mes actual

            EstadoSesion::where('id_sesion', $sesion->id_sesion)
                ->where('estado', 'pendiente')
                ->where('fecha', '>=', $primerDiaMes)
                ->where('fecha', '<=', $ultimoDiaMes)
                ->delete();

            // Iterar sobre los días del mes actual
            for ($fecha = $fechaActual; $fecha->lte($ultimoDiaMes); $fecha->addDay()) {
                // Verificar si el día de la semana coincide
                if ($fecha->locale('es')->translatedFormat('l') === $diaSemana) {
                    // Crear un registro en EstadoSesion
                    EstadoSesion::create([
                        'id_sesion' => $sesion->id_sesion,
                        'fecha' => $fecha->toDateString(),
                        'estado' => 'pendiente',
                        'notas' => '',
                    ]);
                }
            }


            return redirect()->route('pacientes.show', $sesion->id_paciente)->with('success', 'Sesión actualizada correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la sesión: ' . $e->getMessage());
            $errorMessage = json_encode('Error al actualizar la sesión: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
        }
    }
}
