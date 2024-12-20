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
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    /**
     * Mostrar listado de pacientes.
     */
    public function index(Request $request)
    {
        $query = Paciente::where('id_user', Auth::user()->id);

        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->input('search') . '%');
        }

        $pacientes = $query->paginate(6);
        $apoderados = Tutor::all();
        $especialistas = Especialista::all();
        $sesiones = Sesion::all();
        $estadoSesiones = EstadoSesion::all();

        return view('pages.pacientes.index', compact('pacientes', 'apoderados', 'especialistas', 'sesiones'));
    }

    public function form()
    {
        return view('pages.pacientes.form');
    }

    public function create(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'curso' => 'nullable|string|max:50',
            'colegio' => 'nullable|string|max:100',
            'rut' => 'nullable|string|max:20',
            'sexo' => 'nullable|string|max:10',
            'direccion' => 'nullable|string|max:100',
            'info_adicional' => 'nullable|string|max:255',
            'nombre_tutor' => 'required|string|max:100',
            'telefono_tutor' => 'nullable|string|max:15',
            'mail_tutor' => 'nullable|email|max:100',
            'dia' => 'required|in:lunes,martes,miércoles,jueves,viernes',
            'hora_inicio' => 'required|string',
            'hora_fin' => 'required|string',
            'valor' => 'required|numeric|between:0,99999999.99',
            'nombre_tutor2' => 'nullable|string|max:100',
            'telefono_tutor2' => 'nullable|string|max:15',
            'mail_tutor2' => 'nullable|email|max:100',
            'tipoSesion' => 'required|in:individual,grupal',
            'year' => 'required|integer',
            'sesiones-anual' => 'nullable|integer',
        ]);

        try {
            // Crear el Paciente
            $paciente = Paciente::create([
                'id_user' => Auth::user()->id,
                'nombre' => $validatedData['nombre'],
                'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                'curso' => $validatedData['curso'],
                'colegio' => $validatedData['colegio'],
                'rut' => $validatedData['rut'],
                'sexo' => $validatedData['sexo'],
                'direccion' => $validatedData['direccion'],
                'info_adicional' => $validatedData['info_adicional'],
            ]);

            // Crear el Tutor
            $tutor = Tutor::create([
                'nombre' => $validatedData['nombre_tutor'],
                'telefono' => $validatedData['telefono_tutor'],
                'mail' => $validatedData['mail_tutor'],
                'id_paciente' => $paciente->id_paciente,
            ]);

            // Crear el Tutor 2 si existe esta completado el nombre_tutor2
            if ($validatedData['nombre_tutor2']) {
                Tutor::create([
                    'nombre' => $validatedData['nombre_tutor2'],
                    'telefono' => $validatedData['telefono_tutor2'],
                    'mail' => $validatedData['mail_tutor2'],
                    'id_paciente' => $paciente->id_paciente,
                ]);
            }


            // Obtener el día de la semana de la sesión creada
            $diaSemana = $validatedData['dia'];

            // Obtener el primer día del mes actual
            $fechaActual = Carbon::now();
            $primerDiaMes = $fechaActual->copy()->startOfMonth();

            // Crear la Sesion
            $sesion = Sesion::create([
                'dia_semana' => $validatedData['dia'],
                'hora_inicio' => $validatedData['hora_inicio'],
                'hora_final' => $validatedData['hora_fin'],
                'valor' => $validatedData['valor'],
                'year' => $validatedData['year'],
                'id_paciente' => $paciente->id_paciente,
                'tipo' => $validatedData['tipoSesion'],
            ]);


            // Si el checkbox sesiones-anual está marcado, crear las sesiones por todo el año
            if (isset($validatedData['sesiones-anual']) && $validatedData['sesiones-anual'] == 1) {
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
            }

            // Redirigir a la vista de pacientes con un mensaje de éxito
            return redirect()->route('pacientes.show', $paciente->id_paciente)->with('success', 'Alumno creado exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al crear el alumno: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el alumno. ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $paciente = Paciente::where('id_user', Auth::user()->id)->findOrFail($id);
        $sesiones = Sesion::all();
        $sesion = $sesiones->where('id_paciente', $id)->first();

        $apoderados = Tutor::all();
        $apoderadosPaciente = $apoderados->where('id_paciente', $id);
        $edadPaciente = Carbon::parse($paciente->fecha_nacimiento)->age;
        $especialistas = Especialista::all();
        $PacienteEspecialista = PacienteEspecialista::where('id_paciente', $id)->get();
        $especialistasPaciente = Especialista::whereIn('id_especialista', $PacienteEspecialista->pluck('id_especialista'))->get();

        $pagosPaciente = Pago::where('id_paciente', $id)
            ->orderBy('mes', 'desc')
            ->orderByRaw("FIELD(estado, 'atrasado', 'pendiente', 'pagado')")
            ->get();

        $estadoSesiones = EstadoSesion::where('id_sesion', $sesion->id_sesion)->get();
        $sesionesCanceladas = $estadoSesiones->where('estado', 'cancelada')->count();
        $sesionesRealizadas = $estadoSesiones->where('estado', 'realizada')->count();
        $sesionesPendientes = $estadoSesiones->where('estado', 'pendiente')->count();

        $reuniones = Reunion::where('id_paciente', $id)->get();

        return view('pages.pacientes.show', compact(
            'paciente',
            'sesion',
            'apoderadosPaciente',
            'edadPaciente',
            'especialistas',
            'PacienteEspecialista',
            'pagosPaciente',
            'sesionesCanceladas',
            'sesionesRealizadas',
            'sesionesPendientes',
            'especialistasPaciente',
            'estadoSesiones',
            'reuniones',
        ));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'curso' => 'nullable|string|max:50',
            'colegio' => 'nullable|string|max:100',
            'rut' => 'nullable|string|max:20',
            'sexo' => 'nullable|string|max:10',
            'direccion' => 'nullable|string|max:100',
            'info_adicional' => 'nullable|string|max:255',
        ]);

        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->update($validatedData);

            return redirect()->route('pacientes.show', $id)->with('success', 'Alumno actualizado exitosamente.');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar el alumno: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar el alumno. ' . $e->getMessage()]);
        }
    }
}
