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

class PEController extends Controller
{

    public function index()
    {

        return view('pages.PE.index');
    }

    public function create(Request $request, $id)
    {


        $validatedData = $request->validate([
            'id_especialista' => 'required|exists:Especialistas,id_especialista',
        ]);



        try {
            $especialista = Especialista::findOrFail($validatedData['id_especialista']);

            $pacienteEspecialista = PacienteEspecialista::create([
                'id_paciente' => $id,
                'id_especialista' => $especialista->id_especialista,
            ]);


            return redirect()->route('pacientes.show', $id)->with('success', 'Paciente actualizado correctamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar la sesión: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la sesión. ' . $e->getMessage()]);
        }
    }
}
