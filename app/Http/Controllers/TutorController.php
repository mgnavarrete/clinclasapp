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

class TutorController extends Controller
{

    public function index()
    {

        return view('pages.tutores.index');
    }

    public function create(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre_tutor' => 'required|string|max:100',
            'telefono_tutor' => 'nullable|string|max:15',
            'mail_tutor' => 'nullable|email|max:100',
        ]);

        try {

            // Crear el Tutor
            $tutor = Tutor::create([
                'nombre' => $validatedData['nombre_tutor'],
                'telefono' => $validatedData['telefono_tutor'],
                'mail' => $validatedData['mail_tutor'],
                'id_paciente' => $id,
            ]);

            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $id)->with('success', 'Tutor creado correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear el paciente: ' . $e->getMessage());
            $errorMessage = json_encode('Error al crear el paciente: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
            // return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el paciente. <br>' . $e->getMessage()]);
        }
    }







    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nombre_tutor' => 'required|string|max:100',
            'telefono_tutor' => 'nullable|string|max:15',
            'mail_tutor' => 'nullable|email|max:100',
        ]);



        try {
            $tutor = Tutor::findOrFail($id);

            $tutor->update([
                'nombre' => $validatedData['nombre_tutor'],
                'telefono' => $validatedData['telefono_tutor'],
                'mail' => $validatedData['mail_tutor'],
            ]);

            return redirect()->route('pacientes.show', $tutor->id_paciente)->with('success', 'Tutor actualizado correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar el tutor: ' . $e->getMessage());
            $errorMessage = json_encode('Error al actualizar el tutor: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
        }
    }
}
