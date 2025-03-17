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

class EstadoController extends Controller
{

    public function index()
    {

        return view('pages.estado.index');
    }



    public function update(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'estado' => 'required|string',
                'notas' => 'nullable|string',
            ]);

            $estadoSesion = EstadoSesion::findOrFail($id);
            $estadoSesion->update([
                'estado' => $validatedData['estado'],
                'notas' => $validatedData['notas'],
            ]);

            $sesion = Sesion::findOrFail($estadoSesion->id_sesion);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('pacientes.show', $sesion->id_paciente)->with('success', 'Actualización exitosa.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar. ' . $e->getMessage()]);
        }
    }


    public function updateCal(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'estado' => 'required|string',
                'notas' => 'nullable|string',
            ]);

            $estadoSesion = EstadoSesion::findOrFail($id);
            $estadoSesion->update([
                'estado' => $validatedData['estado'],
                'notas' => $validatedData['notas'],
            ]);

            $sesion = Sesion::findOrFail($estadoSesion->id_sesion);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Actualización exitosa.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar. ' . $e->getMessage()]);
        }
    }

    public function updatePago(Request $request, $id_estado, $id_pago)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'estado' => 'required|string',
                'notas' => 'nullable|string',
            ]);

            $estadoSesion = EstadoSesion::findOrFail($id_estado);
            $estadoSesion->update([
                'estado' => $validatedData['estado'],
                'notas' => $validatedData['notas'],
            ]);

            $sesion = Sesion::findOrFail($estadoSesion->id_sesion);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('pagos.show', $id_pago)->with('success', 'Actualización exitosa.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar. ' . $e->getMessage()]);
        }
    }


    public function updateIdx(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'estado' => 'required|string',
                'notas' => 'nullable|string',
            ]);

            $estadoSesion = EstadoSesion::findOrFail($id);
            $estadoSesion->update([
                'estado' => $validatedData['estado'],
                'notas' => $validatedData['notas'],
            ]);

            $sesion = Sesion::findOrFail($estadoSesion->id_sesion);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('index')->with('success', 'Actualización exitosa.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar. ' . $e->getMessage()]);
        }
    }


    public function create(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'fecha_sesionAgendar' => 'required|date',
                'hora_inicioSesion' => 'required|string',
                'minuto_inicioSesion' => 'required|string',
                'hora_finSesion' => 'required|string',
                'minuto_finSesion' => 'required|string',
                'notas_sesionAgendar' => 'nullable|string',
            ]);

            // Separar la hora en hora_inicio y hora_fin
            $hora_inicio = $validatedData['hora_inicioSesion'] . ':' . $validatedData['minuto_inicioSesion'];
            $hora_final = $validatedData['hora_finSesion'] . ':' . $validatedData['minuto_finSesion'];
            $hora_inicio = Carbon::createFromFormat('H:i', $hora_inicio)->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora_final)->format('H:i:s');


            $sesion = Sesion::where('id_paciente', $id)->first();

            $estadoSesion = EstadoSesion::create([
                'id_sesion' => $sesion->id_sesion,
                'fecha' => $validatedData['fecha_sesionAgendar'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'notas' => $validatedData['notas_sesionAgendar'],
            ]);

            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $id)->with('success', 'Sesión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la sesión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la sesión. ' . $e->getMessage()]);
        }
    }

    public function createAnual(Request $request, $id)
    {

        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'diaSesionAnual' => 'required|string',
                'hora_inicioSesionAnual' => 'required|string',
                'minuto_inicioSesionAnual' => 'required|string',
                'hora_finSesionAnual' => 'required|string',
                'minuto_finSesionAnual' => 'required|string',
                'valorSesionAnual' => 'required|numeric',
                'yearSesionAnual' => 'required|numeric',
                'tipoSesionAnual' => 'required|string',
            ]);

            // Obtener el día de la semana de la sesión creada
            $diaSemana = $validatedData['diaSesionAnual'];

            // Obtener el primer día del mes actual
            $fechaActual = Carbon::now();
            $primerDiaMes = $fechaActual->copy()->startOfMonth();
            // Separar la hora en hora_inicio y hora_fin
            $hora_inicio = $validatedData['hora_inicioSesionAnual'] . ':' . $validatedData['minuto_inicioSesionAnual'];
            $hora_final = $validatedData['hora_finSesionAnual'] . ':' . $validatedData['minuto_finSesionAnual'];
            $hora_inicio = Carbon::createFromFormat('H:i', $hora_inicio)->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora_final)->format('H:i:s');


            // Crear la Sesion
            $sesion = Sesion::create([
                'dia_semana' => $validatedData['diaSesionAnual'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'valor' => $validatedData['valorSesionAnual'],
                'year' => $validatedData['yearSesionAnual'],
                'id_paciente' => $id,
                'tipo' => $validatedData['tipoSesionAnual'],
            ]);



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
                            'hora_inicio' => $hora_inicio,
                            'hora_final' => $hora_final,
                            'estado' => 'pendiente',
                            'notas' => '',
                        ]);
                    }
                }
            }

            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $id)->with('success', 'Sesión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la sesión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la sesión. ' . $e->getMessage()]);
        }
    }
}
