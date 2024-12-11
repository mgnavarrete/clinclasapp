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

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $this->actualizarPagos();

        $search = $request->input('search');
        $monthFilter = $request->input('month_filter', 'todos');



        $pagos = Pago::with('paciente')
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
            // $monthFilter viene en formato Y-m-d, el primer día del mes
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
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update([
            'estado' => $validatedData['estado'],
            'fecha_pagado' => Carbon::now('America/Santiago')->format('Y-m-d'),
        ]);

        return redirect()->route('pagos.index')->with('success');
    }
    public function updatePac(Request $request, $id)
    {
        $validatedData = $request->validate([
            'estado' => 'required|string',
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update([
            'estado' => $validatedData['estado'],
            'fecha_pagado' => Carbon::now('America/Santiago')->format('Y-m-d'),
        ]);

        return redirect()->route('pagos.index')->with('success');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'mes' => 'required|string',
            'year' => 'required|string',
        ]);

        // MES TIENE EL NUMERO DEL MES EN STRING CONVERTIRLO EN YEAR-MES-PRIMERO DEL MES DONDE AÑO SEA {YEAR}
        $mes = Carbon::create($validatedData['year'], $validatedData['mes'], 1)->format('Y-m-d');

        $pacientes = Paciente::all();

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

        return redirect()->route('pagos.index')->with('success');
    }
}
