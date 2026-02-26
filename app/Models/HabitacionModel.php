<?php
namespace App\Models;

use CodeIgniter\Model;

class HabitacionModel extends Model
{
    protected $table            = 'habitaciones';
    protected $primaryKey       = 'idHabitacion';
    protected $allowedFields    = [
        'tipo', 'descripcion', 'estado', 'imagen'
    ];
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;
    protected $deletedField     = 'deleted_at';

    /**
     * Obtener todas las tarifas de una habitación
     * opcionalmente filtrando por cantidad mínima de huéspedes
     */
    public function getTarifas($idHabitacion, $minHuespedes = 1)
    {
        $tarifaModel = new \App\Models\TarifaModel();

        return $tarifaModel->where('idHabitacion', $idHabitacion)
                           ->where('capacidad >=', (int)$minHuespedes)
                           ->orderBy('capacidad', 'ASC')
                           ->findAll();
    }

    /**
     * Buscar habitaciones disponibles según fechas y cantidad de huéspedes
     * Retorna una lista con la información de la habitación + tarifas
     */
    public function buscarDisponibles($entrada, $salida, $huespedes)
{
    $sql = "
        SELECT 
            h.*, 
            t.idTarifa, 
            t.nombre AS tarifa_nombre, 
            t.precio AS tarifa_precio, 
            t.capacidad AS tarifa_capacidad
        FROM habitaciones h
        JOIN habitacion_tarifas t ON t.idHabitacion = h.idHabitacion
        WHERE t.capacidad >= ?
          AND h.estado = 'disponible'
          AND h.idHabitacion NOT IN (
              SELECT r.idHabitacion
              FROM reservas r
              WHERE r.estado != 'cancelada'
                AND (
                    (r.fechaInicio <= ? AND r.fechaFin >= ?)
                    OR (r.fechaInicio <= ? AND r.fechaFin >= ?)
                    OR (r.fechaInicio >= ? AND r.fechaFin <= ?)
                )
          )
        ORDER BY h.tipo, t.capacidad ASC
    ";

    $query = $this->db->query($sql, [
        (int)$huespedes,
        $entrada, $entrada,
        $salida, $salida,
        $entrada, $salida
    ]);

    return $query->getResultArray();
}
}
