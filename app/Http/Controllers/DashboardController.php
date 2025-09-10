<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pago;
use App\Models\Paciente;
use App\Models\EstadoSesion;
use App\Models\Reunion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        
        // Métricas principales
        $metricas = $this->getMetricasPrincipales($userId);
        
        // Datos para gráficos
        $ingresosPorMes = $this->getIngresosPorMes($userId);
        $comparacionMensual = $this->getComparacionMensual($userId);
        $estadosPagos = $this->getEstadosPagos($userId);
        $topPacientes = $this->getTopPacientes($userId);
        $tendenciaAnual = $this->getTendenciaAnual($userId);
        $ingresosPorTipo = $this->getIngresosPorTipo($userId);
        
        return view('pages.dashboard.index', compact(
            'metricas',
            'ingresosPorMes',
            'comparacionMensual',
            'estadosPagos',
            'topPacientes',
            'tendenciaAnual',
            'ingresosPorTipo'
        ));
    }
    
    private function getMetricasPrincipales($userId)
    {
        $mesActual = Carbon::now();
        $mesAnterior = Carbon::now()->subMonth();
        
        // Ingresos del mes actual
        $ingresosMesActual = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pagado')
        ->whereMonth('mes', $mesActual->month)
        ->whereYear('mes', $mesActual->year)
        ->sum('valor_total');
        
        // Ingresos del mes anterior
        $ingresosMesAnterior = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pagado')
        ->whereMonth('mes', $mesAnterior->month)
        ->whereYear('mes', $mesAnterior->year)
        ->sum('valor_total');
        
        // Ingresos totales del año
        $ingresosAnuales = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pagado')
        ->whereYear('mes', $mesActual->year)
        ->sum('valor_total');
        
        // Pagos pendientes
        $pagosPendientes = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pendiente')
        ->sum('valor_total');
        
        // Pagos atrasados
        $pagosAtrasados = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'atrasado')
        ->sum('valor_total');
        
        // Cálculo de variación porcentual
        $variacionPorcentual = 0;
        if ($ingresosMesAnterior > 0) {
            $variacionPorcentual = (($ingresosMesActual - $ingresosMesAnterior) / $ingresosMesAnterior) * 100;
        }
        
        // Total de pacientes activos
        $pacientesActivos = Paciente::where('id_user', $userId)->count();
        
        return [
            'ingresos_mes_actual' => $ingresosMesActual,
            'ingresos_mes_anterior' => $ingresosMesAnterior,
            'ingresos_anuales' => $ingresosAnuales,
            'pagos_pendientes' => $pagosPendientes,
            'pagos_atrasados' => $pagosAtrasados,
            'variacion_porcentual' => round($variacionPorcentual, 2),
            'pacientes_activos' => $pacientesActivos,
            'mes_actual_nombre' => $mesActual->translatedFormat('F'),
            'mes_anterior_nombre' => $mesAnterior->translatedFormat('F')
        ];
    }
    
    private function getIngresosPorMes($userId)
    {
        $ingresos = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pagado')
        ->whereYear('mes', Carbon::now()->year)
        ->select(
            DB::raw('MONTH(mes) as mes'),
            DB::raw('SUM(valor_total) as total')
        )
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();
        
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        $datos = [];
        for ($i = 1; $i <= 12; $i++) {
            $ingreso = $ingresos->where('mes', $i)->first();
            $datos[] = [
                'mes' => $meses[$i],
                'total' => $ingreso ? $ingreso->total : 0
            ];
        }
        
        return $datos;
    }
    
    private function getComparacionMensual($userId)
    {
        $mesActual = Carbon::now();
        $ultimosTresMeses = [];
        
        for ($i = 2; $i >= 0; $i--) {
            $fecha = $mesActual->copy()->subMonths($i);
            
            $ingresos = Pago::whereHas('paciente', function($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->where('estado', 'pagado')
            ->whereMonth('mes', $fecha->month)
            ->whereYear('mes', $fecha->year)
            ->sum('valor_total');
            
            $ultimosTresMeses[] = [
                'mes' => $fecha->translatedFormat('F Y'),
                'ingresos' => $ingresos
            ];
        }
        
        return $ultimosTresMeses;
    }
    
    private function getEstadosPagos($userId)
    {
        $estados = Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->select('estado', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(valor_total) as total'))
        ->groupBy('estado')
        ->get();
        
        return $estados->map(function($estado) {
            return [
                'estado' => ucfirst($estado->estado),
                'cantidad' => $estado->cantidad,
                'total' => $estado->total
            ];
        });
    }
    
    private function getTopPacientes($userId)
    {
        return Pago::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'pagado')
        ->with('paciente')
        ->select('id_paciente', DB::raw('SUM(valor_total) as total_pagado'))
        ->groupBy('id_paciente')
        ->orderBy('total_pagado', 'desc')
        ->limit(5)
        ->get()
        ->map(function($pago) {
            return [
                'nombre' => $pago->paciente->nombre,
                'total' => $pago->total_pagado
            ];
        });
    }
    
    private function getTendenciaAnual($userId)
    {
        $añoActual = Carbon::now()->year;
        $añoAnterior = $añoActual - 1;
        
        $tendencia = [];
        
        for ($mes = 1; $mes <= 12; $mes++) {
            $ingresoActual = Pago::whereHas('paciente', function($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->where('estado', 'pagado')
            ->whereMonth('mes', $mes)
            ->whereYear('mes', $añoActual)
            ->sum('valor_total');
            
            $ingresoAnterior = Pago::whereHas('paciente', function($query) use ($userId) {
                $query->where('id_user', $userId);
            })
            ->where('estado', 'pagado')
            ->whereMonth('mes', $mes)
            ->whereYear('mes', $añoAnterior)
            ->sum('valor_total');
            
            $tendencia[] = [
                'mes' => Carbon::create()->month($mes)->translatedFormat('M'),
                'año_actual' => $ingresoActual,
                'año_anterior' => $ingresoAnterior
            ];
        }
        
        return $tendencia;
    }
    
    private function getIngresosPorTipo($userId)
    {
        // Ingresos por sesiones
        $ingresosSesiones = EstadoSesion::whereHas('sesion.paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->whereIn('estado', ['realizada', 'no avisó'])
        ->whereYear('created_at', Carbon::now()->year)
        ->with('sesion')
        ->get()
        ->sum(function($estado) {
            return $estado->sesion->valor ?? 0;
        });
        
        // Ingresos por reuniones
        $ingresosReuniones = Reunion::whereHas('paciente', function($query) use ($userId) {
            $query->where('id_user', $userId);
        })
        ->where('estado', 'realizada')
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('valor');
        
        return [
            ['tipo' => 'Sesiones', 'valor' => $ingresosSesiones],
            ['tipo' => 'Reuniones', 'valor' => $ingresosReuniones]
        ];
    }
}
