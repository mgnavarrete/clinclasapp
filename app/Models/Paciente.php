<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'Pacientes'; // Especifica el nombre de la tabla
    protected $primaryKey = 'id_paciente'; // Clave primaria

    protected $fillable = [
        'id_user',
        'nombre',
        'fecha_nacimiento',
        'curso',
        'colegio',
        'rut',
        'sexo',
        'info_adicional',
        'direccion',
    ];

    public function tutores()
    {
        return $this->hasMany(Tutor::class, 'id_paciente', 'id_paciente');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class, 'id_paciente', 'id_paciente');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_paciente', 'id_paciente');
    }

    public function especialistas()
    {
        return $this->belongsToMany(Especialista::class, 'paciente_especialista', 'id_paciente', 'id_especialista');
    }
}
