<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoSesion extends Model
{
    use HasFactory;

    protected $table = 'EstadosSesiones'; // Nombre de la tabla
    protected $primaryKey = 'id_estado'; // Clave primaria

    protected $fillable = [
        'id_sesion',
        'fecha',
        'estado',
        'hora_inicio',
        'hora_final',
        'notas',
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'id_sesion', 'id_sesion');
    }

    /**
     * Scope para obtener solo EstadoSesion futuros
     */
    public function scopeFuturos($query, $fechaDesde = null)
    {
        $fecha = $fechaDesde ?: now()->startOfDay();
        return $query->whereDate('fecha', '>=', $fecha);
    }

    /**
     * Scope para obtener solo EstadoSesion pasados
     */
    public function scopePasados($query, $fechaHasta = null)
    {
        $fecha = $fechaHasta ?: now()->startOfDay();
        return $query->whereDate('fecha', '<', $fecha);
    }
}
