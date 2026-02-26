<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table            = 'reservas';
    protected $primaryKey       = 'idReserva';
    protected $useAutoIncrement = true;

    // Soft deletes y timestamps
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    // Campos permitidos para insert/update
    protected $allowedFields = [
        'idUsuario',
        'idPropiedad',
        'fechaInicio',
        'fechaFin',
        'cantidadHuespedes',
        'precio_por_noche',
        'total',
        'estado',
        'pago_estado',
        'comentarios'
    ];

    // Reglas de validación
    protected $validationRules = [
        'idUsuario'        => 'required|integer',
        'idPropiedad'      => 'required|integer',
        'fechaInicio'      => 'required|valid_date',
        'fechaFin'         => 'required|valid_date',
        'cantidadHuespedes'=> 'required|integer|greater_than_equal_to[1]',
        'precio_por_noche' => 'permit_empty|decimal',
        'total'            => 'permit_empty|decimal',
        'estado'           => 'in_list[pendiente,confirmada,cancelada]',
        'pago_estado'      => 'in_list[pendiente,pagado,fallido]',
    ];

    protected $validationMessages = [
        'fechaFin' => [
            'valid_date' => 'La fecha de salida no es válida.'
        ],
        'cantidadHuespedes' => [
            'greater_than_equal_to' => 'Debe haber al menos 1 huésped.'
        ]
    ];

    protected $skipValidation = false;
}
