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
}
