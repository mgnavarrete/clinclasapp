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

class EspecialistaController extends Controller
{

    public function index()
    {

        return view('pages.especialistas.index');
    }

    public function create(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nombre_especialista' => 'required',
            'telefono_especialista' => 'required',
            'mail_especialista' => 'required',
            'especialidad_especialista' => 'required',
        ]);



        try {
            $especialista = Especialista::create([
                'nombre' => $validatedData['nombre_especialista'],
                'telefono' => $validatedData['telefono_especialista'],
                'mail' => $validatedData['mail_especialista'],
                'especialidad' => $validatedData['especialidad_especialista'],
            ]);

            $pacienteEspecialista = PacienteEspecialista::create([
                'id_paciente' => $id,
                'id_especialista' => $especialista->id_especialista,
            ]);


            return redirect()->route('pacientes.show', $id)->with('success');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la sesión: ' . $e->getMessage());
            $errorMessage = json_encode('Error al actualizar la sesión: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
        }
    }
}
