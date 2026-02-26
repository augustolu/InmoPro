<?php

namespace App\Models;

use CodeIgniter\Model;

class PropiedadReservaModel extends Model
{
    protected $table            = 'propiedad_reservas';
    protected $primaryKey       = 'idReserva';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'idPropiedad',
        'idUsuario',
        'fechaInicio',
        'fechaFin',
        'cantidadHuespedes',
        'precio_por_noche',
        'total',
        'estado',
        'pago_estado',
        'comentarios'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'idPropiedad'       => 'required|integer',
        'idUsuario'         => 'required|integer',
        'fechaInicio'       => 'required|valid_date',
        'fechaFin'          => 'required|valid_date',
        'cantidadHuespedes' => 'required|integer|greater_than[0]',
        'precio_por_noche'  => 'required|numeric',
        'total'             => 'required|numeric'
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtiene reservas confirmadas de una propiedad entre dos fechas
     */
    public function getReservasConfirmadas($idPropiedad, $fechaInicio, $fechaFin)
    {
        return $this->where('idPropiedad', $idPropiedad)
                    ->where('estado', 'confirmada')
                    ->where('fechaInicio <=', $fechaFin)
                    ->where('fechaFin >=', $fechaInicio)
                    ->findAll();
    }

    /**
     * Verifica si hay conflicto de fechas
     */
    public function hayConflictoFechas($idPropiedad, $fechaInicio, $fechaFin, $excludeIdReserva = null)
    {
        $query = $this->where('idPropiedad', $idPropiedad)
                      ->whereIn('estado', ['confirmada', 'pendiente'])
                      ->where('fechaInicio <', $fechaFin)
                      ->where('fechaFin >', $fechaInicio);

        if ($excludeIdReserva) {
            $query = $query->where('idReserva !=', $excludeIdReserva);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Obtiene fechas ocupadas de una propiedad
     */
    public function getFechasOcupadas($idPropiedad)
    {
        return $this->select('fechaInicio, fechaFin')
                    ->where('idPropiedad', $idPropiedad)
                    ->where('estado', 'confirmada')
                    ->findAll();
    }

    /**
     * Obtiene reservas de un usuario
     */
    public function getReservasUsuario($idUsuario)
    {
        return $this->where('idUsuario', $idUsuario)
                    ->join('propiedades', 'propiedades.idPropiedad = propiedad_reservas.idPropiedad')
                    ->select('propiedad_reservas.*, propiedades.titulo, propiedades.imagen_principal')
                    ->orderBy('propiedad_reservas.fechaInicio', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene disponibilidad de una propiedad para un rango de fechas
     */
    public function obtenerDisponibilidad($idPropiedad, $fechaInicio, $fechaFin)
    {
        $reservas = $this->getReservasConfirmadas($idPropiedad, $fechaInicio, $fechaFin);
        
        $fechasOcupadas = [];
        foreach ($reservas as $reserva) {
            $inicio = new \DateTime($reserva['fechaInicio']);
            $fin = new \DateTime($reserva['fechaFin']);
            
            while ($inicio < $fin) {
                $fechasOcupadas[] = $inicio->format('Y-m-d');
                $inicio->modify('+1 day');
            }
        }

        // Generar todas las fechas del rango
        $todas = [];
        $actual = new \DateTime($fechaInicio);
        $final = new \DateTime($fechaFin);
        
        while ($actual <= $final) {
            $fecha = $actual->format('Y-m-d');
            $todas[$fecha] = !in_array($fecha, $fechasOcupadas);
            $actual->modify('+1 day');
        }

        return $todas;
    }
}
