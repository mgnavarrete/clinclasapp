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
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('pages.perfil.index', compact('user'));
    }
}
