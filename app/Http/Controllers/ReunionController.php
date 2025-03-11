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
use App\Models\Reunion;

class ReunionController extends Controller
{
    /**
     * Mostrar listado de pacientes.
     */
    public function index(Request $request)
    {

        return view('pages.reuniones.index');
    }


    public function create(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([

            'fecha_reunion' => 'required|date',
            'hora_inicioReunion' => 'required|string',
            'minuto_inicioReunion' => 'required|string',
            'hora_finReunion' => 'required|string',
            'minuto_finReunion' => 'required|string',
            'valor_reunion' => 'required|numeric|between:0,99999999.99',
        ]);

        try {

            // Separar la hora en hora_inicio y hora_fin
            $hora_inicio = $validatedData['hora_inicioReunion'] . ':' . $validatedData['minuto_inicioReunion'];
            $hora_final = $validatedData['hora_finReunion'] . ':' . $validatedData['minuto_finReunion'];
            $hora_inicio = Carbon::createFromFormat('H:i', $hora_inicio)->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora_final)->format('H:i:s');

            $reunion = Reunion::create([
                'id_paciente' => $id,
                'fecha' => $validatedData['fecha_reunion'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'valor' => $validatedData['valor_reunion'],
                'estado' => 'pendiente',
            ]);


            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $id)->with('success', 'Reunión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la reunión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear la reunión. ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        try {
            $reunion = Reunion::findOrFail($id);
            $reunion->update([
                'estado' => $validatedData['estado'],
            ]);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('pacientes.show', $reunion->id_paciente)->with('success', 'Reunión actualizada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la reunión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la reunión. ' . $e->getMessage()]);
        }
    }

    public function updatePago(Request $request, $id_reunion, $id_pago)
    {
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        try {
            $reunion = Reunion::findOrFail($id_reunion);
            $reunion->update([
                'estado' => $validatedData['estado'],
            ]);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('pagos.show', $id_pago)->with('success', 'Reunión actualizada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la reunión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la reunión. ' . $e->getMessage()]);
        }
    }

    public function updateCal(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        try {
            $reunion = Reunion::findOrFail($id);
            $reunion->update([
                'estado' => $validatedData['estado'],
            ]);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Reunión actualizada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la reunión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la reunión. ' . $e->getMessage()]);
        }
    }

    public function updateIdx(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        try {
            $reunion = Reunion::findOrFail($id);
            $reunion->update([
                'estado' => $validatedData['estado'],
            ]);

            // Redirigir a la página anterior con un mensaje de éxito
            return redirect()->route('index')->with('success', 'Reunión actualizada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la reunión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la reunión. ' . $e->getMessage()]);
        }
    }
}
