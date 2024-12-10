<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialista extends Model
{
    use HasFactory;

    protected $table = 'Especialistas'; // Nombre de la tabla
    protected $primaryKey = 'id_especialista'; // Clave primaria

    protected $fillable = [
        'nombre',
        'telefono',
        'mail',
        'especialidad',
    ];

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'paciente_especialista', 'id_especialista', 'id_paciente');
    }
}
