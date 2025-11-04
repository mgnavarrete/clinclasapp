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
use Illuminate\Support\Facades\Log;
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
                try {
                    Log::info("=== Procesando paciente ID: {$paciente->id_paciente} - {$paciente->nombre} ===");

                    $sesionesPaciente = Sesion::where('id_paciente', $paciente->id_paciente)->get();
                    Log::info("Sesiones encontradas: " . $sesionesPaciente->count());

                    if ($sesionesPaciente->isNotEmpty()) {
                        $sesionValor = $sesionesPaciente->first()->valor;
                        Log::info("Valor de sesión: " . $sesionValor);

                        // obtener las estadoSesiones del mes de $mes y-m-d
                        $estadoSesiones = EstadoSesion::whereIn('id_sesion', $sesionesPaciente->pluck('id_sesion'))
                            ->whereIn('estado', ['no avisó', 'realizada'])
                            ->get();

                        Log::info("Estados de sesión encontrados: " . $estadoSesiones->count());
                        $reuniones = Reunion::where('id_paciente', $paciente->id_paciente)
                            ->where('estado', 'realizada')
                            ->get();

                        $mesComparar = Carbon::parse($mes)->format('Y-m');
                        $valorSesiones = 0;
                        $datainfo = "no entro";
                        foreach ($estadoSesiones as $estadoSesion) {
                            $mesEstado = Carbon::parse($estadoSesion->fecha)->format('Y-m');

                            if ($mesEstado === $mesComparar) {
                                $datainfo = $sesionValor;
                                $valorSesiones += $sesionValor;
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

                        Log::info("Mes a comparar: {$mesComparar}, Valor sesiones: {$valorSesiones}, Valor reuniones: {$valorReuniones}, Valor total: {$valorTotal}");

                        // buscar pago del paciente de ese mes
                        $pago = Pago::where('id_paciente', $paciente->id_paciente)
                            ->where('mes', $mes)
                            ->first();

                        Log::info("Pago existente: " . ($pago ? "SI (ID: {$pago->id_pago}, Estado: {$pago->estado})" : "NO"));

                        if ($pago === null && $valorTotal > 0) {
                            Log::info("CREANDO NUEVO PAGO para paciente {$paciente->id_paciente}");
                            Pago::create([
                                'id_paciente' => $paciente->id_paciente,
                                'mes' => $mes,
                                'valor_total' => $valorTotal,
                                'estado' => 'pendiente',
                                'fecha_pagado' => null,
                            ]);
                        } elseif ($pago === null && $valorTotal === 0) {
                            Log::info("No se crea pago: valorTotal es 0");
                        } elseif ($pago->estado === 'pagado') {
                            Log::info("No se actualiza pago: ya está pagado");
                        } elseif ($valorTotal > 0) {
                            Log::info("ACTUALIZANDO PAGO existente {$pago->id_pago}");
                            $pago->update([
                                'valor_total' => $valorTotal,
                            ]);
                        }
                    } else {
                        Log::info("Paciente sin sesiones, se omite.");
                    }
                } catch (\Exception $e) {
                    Log::error("ERROR procesando paciente {$paciente->id_paciente}: " . $e->getMessage());
                    Log::error("Stack trace: " . $e->getTraceAsString());
                    continue; // Continuar con el siguiente paciente
                }
            }

            return redirect()->route('pagos.index')->with('success', 'Pagos creados correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('pagos.index')->with('error', 'Error al crear los pagos: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pago = Pago::findOrFail($id);

        $sesionesPaciente = Sesion::where('id_paciente', $pago->id_paciente);
        $estadoSesionesAll = EstadoSesion::with('sesion')->whereIn('id_sesion', $sesionesPaciente->pluck('id_sesion'))->get();

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
                'id' => $reunion->id_reunion,
                'tipo' => 'Reunión',
                'fecha' => $reunion->fecha,
                'estado' => $reunion->estado,
                'notas' => "",
                'valor' => $reunion->valor,
                'hora_inicio' => $reunion->hora_inicio,
                'hora_final' => $reunion->hora_final,
                'modal' => 'editReunion',
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
                'modal' => 'editEstado',
            ]);
        }
        $eventos = $eventos->sortBy('fecha');
        $total_reuniones = 0;
        $total_valor = 0;
        $total_sesiones = 0;
        foreach ($eventos as $evento) {
            if ($evento['tipo'] === 'Reunión' && $evento['estado'] === 'realizada') {
                $total_reuniones += intval($evento['valor']);
            }
            if ($evento['tipo'] === 'Sesión' && $evento['estado'] === 'realizada') {
                $total_sesiones += intval($evento['valor']);
            }
            if ($evento['tipo'] === 'Sesión' && $evento['estado'] === 'no avisó') {
                $total_sesiones += intval($evento['valor']);
            }
        }
        $total_valor = $total_reuniones + $total_sesiones;

        $pago->update([
            'valor_total' => $total_valor,
        ]);

        return view('pages.pagos.show', compact('pago', 'sesionesPaciente', 'reuniones', 'apoderados', 'estadoSesiones', 'eventos', 'total_reuniones', 'total_sesiones', 'total_valor'));
    }



    public function pagePDF($id)
    {
        $pago = Pago::findOrFail($id);
        $paciente = Paciente::findOrFail($pago->id_paciente);
        $sesionesPaciente = Sesion::where('id_paciente', $pago->id_paciente);
        $estadoSesionesAll = EstadoSesion::with('sesion')->whereIn('id_sesion', $sesionesPaciente->pluck('id_sesion'))->get();

        $reunionesAll = Reunion::where('id_paciente', $pago->id_paciente)->get();
        // Filtrar sesiones y reuniones del mes del pago
        $mes = Carbon::parse($pago->mes)->format('Y-m');

        $estadoSesiones = $estadoSesionesAll->filter(function ($estadoSesion) use ($mes) {
            return Carbon::parse($estadoSesion->fecha)->format('Y-m') === $mes;
        });
        // Eliminar los estadoSesiones que sean cancelada
        $estadoSesiones = $estadoSesiones->filter(function ($estadoSesion) {
            return $estadoSesion->estado !== 'cancelada';
        });

        $reuniones = $reunionesAll->filter(function ($reunion) use ($mes) {
            return Carbon::parse($reunion->fecha)->format('Y-m') === $mes;
        });

        $reuniones = $reuniones->filter(function ($reunion) {
            return $reunion->estado !== 'cancelada';
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

        return view('pdf.pago', compact('pago', 'sesionesPaciente', 'reuniones', 'apoderados', 'estadoSesiones', 'eventos'));
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
