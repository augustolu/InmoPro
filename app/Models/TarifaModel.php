<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifaModel extends Model
{
    protected $table      = 'habitacion_tarifas';
    protected $primaryKey = 'idTarifa';
    protected $allowedFields = [
        'idHabitacion', 'nombre', 'capacidad', 'precio', 'moneda', 'descripcion', 'nino'
    ];
    protected $useTimestamps = true;
}