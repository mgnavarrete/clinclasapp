<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Carbon\Carbon;
use App\Models\Paciente;
use App\Models\EstadoSesion;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\Sesion;
use App\Models\Reunion;
use Illuminate\Support\Facades\Auth;
use App\Models\Tutor;
use Spatie\Browsershot\Browsershot;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $this->actualizarPagos();

        $search = $request->input('search');
        $monthFilter = $request->input('month_filter', 'todos');

        // Obtener el usuario autenticado
        $userId = Auth::id();

        $pagos = Pago::with('paciente')
            ->whereHas('paciente', function ($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->orderBy('mes', 'desc')
            ->orderByRaw("FIELD(estado, 'atrasado', 'pendiente', 'pagado')")
            ->get();

        // Filtrado por búsqueda de nombre de paciente
        if (!empty($search)) {
            $pagos = $pagos->filter(function ($pago) use ($search) {
                return stripos($pago->paciente->nombre, $search) !== false;
            })->values();
        }

        // Filtrado por mes (si no es "todos")
        if ($monthFilter !== 'todos') {
            $pagos = $pagos->where('mes', $monthFilter);
        }

        $pendientes = $pagos->where('estado', 'pendiente');
        $pagados    = $pagos->where('estado', 'pagado');
        $atrasados  = $pagos->where('estado', 'atrasado');

        return view('pages.pagos.index', compact('pendientes', 'pagados', 'atrasados', 'pagos', 'search', 'monthFilter'));
    }

    public function actualizarPagos()
    {
        $now = Carbon::now('America/Santiago');
        $mesAnteAnterior = $now->copy()->subMonth(2)->startOfMonth()->format('Y-m-d');

        $pagosPendientes = Pago::where('estado', 'pendiente')
            ->where('mes', '<=', $mesAnteAnterior)
            ->get();

        foreach ($pagosPendientes as $pago) {
            $pago->update([
                'estado' => 'atrasado',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'estado' => 'required|string',
            ]);

            $pago = Pago::findOrFail($id);
            $pago->update([
                'estado' => $validatedData['estado'],
                'fecha_pagado' => Carbon::now('America/Santiago')->format('Y-m-d'),
            ]);

            return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('pagos.index')->with('error', 'Error al actualizar el pago.');
        }
    }

    public function updatePac(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'estado' => 'required|string',
            ]);

            $pago = Pago::findOrFail($id);
            $pago->update([
                'estado' => $validatedData['estado'],
                'fecha_pagado' => Carbon::now('America/Santiago')->format('Y-m-d'),
            ]);

            return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('pagos.index')->with('error', 'Error al actualizar el pago.');
        }
    }

    public function updateShow(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'estado' => 'required|string',
            ]);

            $pago = Pago::findOrFail($id);
            if ($validatedData['estado'] === 'pagado') {
                $pago->update([
                    'estado' => $validatedData['estado'],
                    'fecha_pagado' => Carbon::now('America/Santiago')->format('Y-m-d'),
                ]);
            } else {
                $pago->update([
                    'estado' => $validatedData['estado'],
                    'fecha_pagado' => null,
                ]);
            }

            return redirect()->route('pagos.show', $id)->with('success', 'Pago actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('pagos.show', $id)->with('error', 'Error al actualizar el pago.');
        }
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'mes' => 'required|string',
                'year' => 'required|string',
            ]);

            // MES TIENE EL NUMERO DEL MES EN STRING CONVERTIRLO EN YEAR-MES-PRIMERO DEL MES DONDE AÑO SEA {YEAR}
            $mes = Carbon::create($validatedData['year'], $validatedData['mes'], 1)->format('Y-m-d');

            $pacientes = Paciente::where('id_user', Auth::user()->id)->get();



            foreach ($pacientes as $paciente) {
                $sesion = Sesion::where('id_paciente', $paciente->id_paciente)->first();
                if ($sesion !== null) {


                    // obtener las estadoSesiones del mes de $mes y-m-d
                    $estadoSesiones = EstadoSesion::where('id_sesion', $sesion->id_sesion)
                        ->whereIn('estado', ['no avisó', 'realizada'])
                        ->get();
                    $reuniones = Reunion::where('id_paciente', $paciente->id_paciente)
                        ->where('estado', 'realizada')
                        ->get();

                    $mesComparar = Carbon::parse($mes)->format('Y-m');
                    $valorSesiones = 0;
                    $datainfo = "no entro";
                    foreach ($estadoSesiones as $estadoSesion) {
                        $mesEstado = Carbon::parse($estadoSesion->fecha)->format('Y-m');

                        if ($mesEstado === $mesComparar) {
                            $datainfo = $sesion->valor;
                            $valorSesiones += $sesion->valor;
                        }
                    }
                    $valorReuniones = 0;
                    foreach ($reuniones as $reunion) {
                        $mesReunion = Carbon::parse($reunion->fecha)->format('Y-m');

                        if ($mesReunion === $mesComparar) {
                            $valorReuniones += $reunion->valor;
                        }
                    }

                    $valorTotal = $valorSesiones + $valorReuniones;

                    // buscar pago del paciente de ese mes
                    $pago = Pago::where('id_paciente', $paciente->id_paciente)
                        ->where('mes', $mes)
                        ->first();

                    if ($pago === null && $valorTotal > 0) {
                        Pago::create([
                            'id_paciente' => $paciente->id_paciente,
                            'mes' => $mes,
                            'valor_total' => $valorTotal,
                            'estado' => 'pendiente',
                            'fecha_pagado' => null,
                        ]);
                    } elseif ($pago === null && $valorTotal === 0) {
                    } elseif ($pago->estado === 'pagado') {
                    } elseif ($valorTotal > 0) {
                        $pago->update([
                            'valor_total' => $valorTotal,
                        ]);
                    }
                }
            }

            return redirect()->route('pagos.index')->with('success', 'Pagos creados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('pagos.index')->with('error', 'Error al crear los pagos.');
        }
    }

    public function show($id)
    {
        $pago = Pago::findOrFail($id);

        $sesion = Sesion::where('id_paciente', $pago->id_paciente)->first();
        $estadoSesionesAll = EstadoSesion::with('sesion')->where('id_sesion', $sesion->id_sesion)->get();

        $reunionesAll = Reunion::where('id_paciente', $pago->id_paciente)->get();
        // Filtrar sesiones y reuniones del mes del pago
        $mes = Carbon::parse($pago->mes)->format('Y-m');

        $estadoSesiones = $estadoSesionesAll->filter(function ($estadoSesion) use ($mes) {
            return Carbon::parse($estadoSesion->fecha)->format('Y-m') === $mes;
        });

        $reuniones = $reunionesAll->filter(function ($reunion) use ($mes) {
            return Carbon::parse($reunion->fecha)->format('Y-m') === $mes;
        });

        $apoderados = Tutor::where('id_paciente', $pago->id_paciente)->get();
        $eventos = collect();

        foreach ($reuniones as $reunion) {
            $eventos->push([
                'id' => $reunion->id,
                'tipo' => 'Reunión',
                'fecha' => $reunion->fecha,
                'estado' => $reunion->estado,
                'notas' => "",
                'valor' => $reunion->valor,
                'hora_inicio' => $reunion->hora_inicio,
                'hora_final' => $reunion->hora_final,
            ]);
        }

        foreach ($estadoSesiones as $sesion) {
            $eventos->push([
                'id' => $sesion->id_estado,
                'tipo' => 'Sesión',
                'fecha' => $sesion->fecha,
                'estado' => $sesion->estado,
                'notas' => $sesion->notas,
                'valor' => $sesion->sesion->valor,
                'hora_inicio' => $sesion->hora_inicio,
                'hora_final' => $sesion->hora_final,
            ]);
        }
        $eventos = $eventos->sortBy('fecha');

        return view('pages.pagos.show', compact('pago', 'sesion', 'reuniones', 'apoderados', 'estadoSesiones', 'eventos'));
    }



    public function pagePDF($id)
    {
        $pago = Pago::findOrFail($id);
        $paciente = Paciente::findOrFail($pago->id_paciente);
        $sesion = Sesion::where('id_paciente', $pago->id_paciente)->first();
        $estadoSesionesAll = EstadoSesion::with('sesion')->where('id_sesion', $sesion->id_sesion)->get();

        $reunionesAll = Reunion::where('id_paciente', $pago->id_paciente)->get();
        // Filtrar sesiones y reuniones del mes del pago
        $mes = Carbon::parse($pago->mes)->format('Y-m');

        $estadoSesiones = $estadoSesionesAll->filter(function ($estadoSesion) use ($mes) {
            return Carbon::parse($estadoSesion->fecha)->format('Y-m') === $mes;
        });

        $reuniones = $reunionesAll->filter(function ($reunion) use ($mes) {
            return Carbon::parse($reunion->fecha)->format('Y-m') === $mes;
        });

        $apoderados = Tutor::where('id_paciente', $pago->id_paciente)->get();
        $eventos = collect();

        foreach ($reuniones as $reunion) {
            $eventos->push([
                'id' => $reunion->id,
                'tipo' => 'Reunión',
                'fecha' => $reunion->fecha,
                'estado' => $reunion->estado,
                'notas' => "",
                'valor' => $reunion->valor,
                'hora_inicio' => $reunion->hora_inicio,
                'hora_final' => $reunion->hora_final,
            ]);
        }

        foreach ($estadoSesiones as $sesion) {
            $eventos->push([
                'id' => $sesion->id_estado,
                'tipo' => 'Sesión',
                'fecha' => $sesion->fecha,
                'estado' => $sesion->estado,
                'notas' => $sesion->notas,
                'valor' => $sesion->sesion->valor,
                'hora_inicio' => $sesion->hora_inicio,
                'hora_final' => $sesion->hora_final,
            ]);
        }
        $eventos = $eventos->sortBy('fecha');

        $mes = Carbon::parse($pago->mes)->translatedFormat('F');

        return view('pdf.pago', compact('pago', 'sesion', 'reuniones', 'apoderados', 'estadoSesiones', 'eventos'));
    }

    public function descargarPDF($id)
    {
        $pago = Pago::findOrFail($id);
        $url = route('pdf.pago', $id); // Asegúrate de que esta ruta muestre la vista que deseas capturar

        $pdfPath = storage_path('app/public/Pago_' . $pago->mes . '_' . $pago->paciente->nombre . '.pdf');

        Browsershot::url($url)
            ->setNodeBinary('/usr/local/bin/node') // Ajusta la ruta a tu instalación de Node.js si es necesario
            ->setNpmBinary('/usr/local/bin/npm')   // Ajusta la ruta a tu instalación de npm si es necesario
            ->savePdf($pdfPath);

        return response()->download($pdfPath);
    }
}
