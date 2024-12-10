<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'Tutores'; // Nombre de la tabla
    protected $primaryKey = 'id_tutor'; // Clave primaria

    protected $fillable = [
        'id_paciente',
        'nombre',
        'telefono',
        'mail',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }
}
