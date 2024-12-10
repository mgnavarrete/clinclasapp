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
        return redirect()->route('pacientes.show', $sesion->id_paciente)->with('success');
    }


    public function updateCal(Request $request, $id)
    {

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
        return redirect()->route('calendario.index')->with('success');
    }

    public function updateIdx(Request $request, $id)
    {

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
        return redirect()->route('index')->with('success');
    }


    public function create(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([

            'fecha_sesionAgendar' => 'required|date',
            'hora_sesionAgendar' => 'required|string',
            'notas_sesionAgendar' => 'nullable|string',
        ]);

        try {

            // Separar la hora en hora_inicio y hora_fin
            $hora = explode(',', $validatedData['hora_sesionAgendar']);
            $hora_inicio = Carbon::createFromFormat('H:i', $hora[0])->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora[1])->format('H:i:s');

            $sesion = Sesion::where('id_paciente', $id)->first();

            $estadoSesion = EstadoSesion::create([
                'id_sesion' => $sesion->id_sesion,
                'fecha' => $validatedData['fecha_sesionAgendar'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'notas' => $validatedData['notas_sesionAgendar'],
            ]);


            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $id)->with('success', 'Reunión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la reunión: ' . $e->getMessage());
            $errorMessage = json_encode('Error al crear la reunión: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
            // return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el paciente. <br>' . $e->getMessage()]);
        }
    }
}
