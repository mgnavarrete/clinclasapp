<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\EstadoSesion;
use App\Models\Tutor;
use Carbon\Carbon;
use App\Models\Reunion;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $this->actualizarPagos();
        // Total de pacientes
        $totalPacientes = Paciente::where("id_user", Auth::user()->id)->count();

        // Fecha actual y fechas de meses anteriores
        $now = Carbon::now('America/Santiago');
        $mesActual = $now->format('Y-m');
        $mesAnterior = $now->subMonth()->format('Y-m');

        // Fecha del mes ante anterior
        $mesAnteAnterior = $now->subMonth(2)->format('Y-m');

        // Total ganado el mes pasado
        $totalGanadoMesPasado = Pago::with('paciente')
            ->whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->where('mes', 'LIKE', $mesAnterior . '%')
            ->where('estado', 'pagado')
            ->sum('valor_total');

        // Total ganado aproximado del mes actual
        $estadoSesionesRealizadas = EstadoSesion::with('Sesion')
            ->whereHas('sesion.paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->whereIn('estado', ['realizada', 'no avisó'])
            ->get();

        $estadoSesionesRealizadasMesActual = $estadoSesionesRealizadas->filter(function ($estadoSesion) use ($mesActual) {
            return strpos($estadoSesion->fecha, $mesActual) === 0;
        });

        $reunionesRealizadas = Reunion::where('estado', 'realizada')
            ->where('fecha', 'LIKE', $mesActual . '%')
            ->whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->get();
        $totalReunionesRealizadas = $reunionesRealizadas->sum(function ($reunion) {
            return $reunion->valor;
        });

        $totalGanadoMesActual = $estadoSesionesRealizadasMesActual->sum(function ($estadoSesion) {
            return $estadoSesion->sesion->valor;
        });
        $totalGanadoMesActual += $totalReunionesRealizadas;
        // Total ganado el mes ante anterior
        $totalGanadoMesAnteAnterior = Pago::with('paciente')
            ->whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->where('mes', 'LIKE', $mesAnteAnterior . '%')
            ->where('estado', 'pagado')
            ->sum('valor_total');

        // Diferencia entre el mes anterior y el mes ante anterior
        $diferenciaIngresos = $totalGanadoMesPasado - $totalGanadoMesAnteAnterior;

        // Pagos pendientes
        $pagosPendientes = Pago::with('Paciente')
            ->whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->whereIn('estado', ['pendiente', 'atrasado'])
            ->get();

        $apoderados = Tutor::with(['Paciente' => function ($query) {
            $query->where('id_user', Auth::user()->id);
        }])->get();

        // Próximas sesiones (semana actual)
        $inicioSemana = Carbon::now('America/Santiago')->today();

        $finSemana = Carbon::now('America/Santiago')->endOfWeek();

        $proximasSesiones = EstadoSesion::with('sesion.paciente')
            ->whereHas('sesion.paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->where('fecha', '>=', $inicioSemana)
            ->where('fecha', '<=', $finSemana)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        $proximasReuniones = Reunion::with('paciente')
            ->whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
            ->where('fecha', '>=', $inicioSemana)
            ->where('fecha', '<=', $finSemana)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('Y-m');
            $mesLabel = Carbon::now()->subMonths($i)->format('F Y');

            $ingreso = Pago::whereHas('paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
                ->where('mes', 'LIKE', $mes . '%')
                ->where('estado', 'pagado')
                ->sum('valor_total');

            $sesiones = EstadoSesion::whereHas('sesion.paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
                ->where('fecha', 'LIKE', $mes . '%')
                ->where('estado', 'realizada')
                ->count();

            // Sesiones Pendientes de la semana actual
            $inicioSemana = Carbon::now('America/Santiago')->startOfWeek();
            $finSemana = Carbon::now('America/Santiago')->endOfWeek();

            $sesionesPendientes = EstadoSesion::whereHas('sesion.paciente', function ($query) {
                $query->where('id_user', Auth::user()->id);
            })
                ->where('fecha', '>', Carbon::today())
                ->where('fecha', '<=', $finSemana)
                ->where('estado', 'pendiente')
                ->count();
        }

        $proximasReuniones = Reunion::with('paciente')
            ->where('fecha', '>=', $inicioSemana)
            ->where('fecha', '<=', $finSemana)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        // Pasar los datos a la vista
        return view('pages.index', compact(
            'totalPacientes',
            'totalGanadoMesPasado',
            'totalGanadoMesActual',
            'pagosPendientes',
            'proximasSesiones',
            'sesionesPendientes',
            'totalGanadoMesAnteAnterior',
            'diferenciaIngresos',
            'apoderados',
            'estadoSesionesRealizadas',
            'estadoSesionesRealizadasMesActual',
            'proximasReuniones'
        ));
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
}
