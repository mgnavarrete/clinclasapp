<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacienteEspecialista extends Model
{
    use HasFactory;

    protected $table = 'Paciente_Especialista'; // Nombre de la tabla
    protected $primaryKey = 'id_p_e'; // Clave primaria

    protected $fillable = [
        'id_paciente',
        'id_especialista',
    ];
}
