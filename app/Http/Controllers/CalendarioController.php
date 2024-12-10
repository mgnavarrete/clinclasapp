<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Tutor;
use App\Models\Especialista;
use App\Models\Sesion;
use App\Models\EstadoSesion;
use App\Models\Reunion;
use Carbon\Carbon;

class CalendarioController extends Controller
{

    public function index()
    {

        $pacientes = Paciente::all();
        $sesiones = Sesion::with('paciente')->get();
        $estadoSesiones = EstadoSesion::with('sesion')->get();
        $reuniones = Reunion::with('paciente')->get();


        // Próximas sesiones (semana actual)
        $inicioSemana = Carbon::now('America/Santiago')->startOfWeek();
        $finSemana = Carbon::now('America/Santiago')->endOfWeek();

        $proximasSesiones = EstadoSesion::with('sesion.paciente')
            ->where('fecha', '>=', $inicioSemana)
            ->where('fecha', '<=', $finSemana)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();


        $proximasReuniones = Reunion::with('paciente')
            ->where('fecha', '>=', $inicioSemana)
            ->where('fecha', '<=', $finSemana)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();




        $proximosTodos = $proximasSesiones->merge($proximasReuniones);
        //ordenar por fecha y hora
        $proximosTodos = $proximosTodos->sortBy([
            ['fecha', 'asc'],
            ['hora_inicio', 'asc'],
        ]);
        return view('pages.calendario.index', compact('pacientes', 'sesiones', 'estadoSesiones', 'reuniones', 'proximasSesiones', 'proximasReuniones', 'proximosTodos'));
    }


    public function createReunion(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'paciente_reunion' => 'required|numeric',
            'fecha_reunion' => 'required|date',
            'hora_reunion' => 'required|string',
            'valor_reunion' => 'required|numeric|between:0,99999999.99',
        ]);

        try {

            // Separar la hora en hora_inicio y hora_fin
            $hora = explode(',', $validatedData['hora_reunion']);
            $hora_inicio = Carbon::createFromFormat('H:i', $hora[0])->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora[1])->format('H:i:s');


            $reunion = Reunion::create([
                'id_paciente' => $validatedData['paciente_reunion'],
                'fecha' => $validatedData['fecha_reunion'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'valor' => $validatedData['valor_reunion'],
            ]);


            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Reunión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la reunión: ' . $e->getMessage());
            $errorMessage = json_encode('Error al crear la reunión: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
            // return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el paciente. <br>' . $e->getMessage()]);
        }
    }


    public function createSesion(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'paciente_sesion' => 'required|numeric',
            'fecha_sesionAgendar' => 'required|date',
            'hora_sesionAgendar' => 'required|string',
            'notas_sesionAgendar' => 'nullable|string',
        ]);

        try {

            // Separar la hora en hora_inicio y hora_fin
            $hora = explode(',', $validatedData['hora_sesionAgendar']);
            $hora_inicio = Carbon::createFromFormat('H:i', $hora[0])->format('H:i:s');
            $hora_final = Carbon::createFromFormat('H:i', $hora[1])->format('H:i:s');

            $sesion = Sesion::where('id_paciente', $validatedData['paciente_sesion'])->first();

            $estadoSesion = EstadoSesion::create([
                'id_sesion' => $sesion->id_sesion,
                'fecha' => $validatedData['fecha_sesionAgendar'],
                'hora_inicio' => $hora_inicio,
                'hora_final' => $hora_final,
                'notas' => $validatedData['notas_sesionAgendar'],
            ]);


            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('calendario.index')->with('success', 'Sesión creada exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear la reunión: ' . $e->getMessage());
            $errorMessage = json_encode('Error al crear la reunión: ' . $e->getMessage());
            echo "<script>console.error($errorMessage);</script>";
            // return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el paciente. <br>' . $e->getMessage()]);
        }
    }
}
