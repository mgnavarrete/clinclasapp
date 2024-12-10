<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $monthFilter = $request->input('month_filter', 'todos');

        // Actualizamos los pagos antes de cargar
        $this->actualizarPagos();

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
            ->where('mes', $mesAnteAnterior)
            ->get();

        foreach ($pagosPendientes as $pago) {
            $pago->estado = 'atrasado';
            $pago->save();
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
}
