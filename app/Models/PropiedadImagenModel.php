<?php

namespace App\Models;

use CodeIgniter\Model;

class PropiedadImagenModel extends Model
{
    protected $table            = 'propiedad_imagenes';
    protected $primaryKey       = 'idImagen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'idPropiedad',
        'ruta',
        'orden'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // no updated_at column
    
    /**
     * Get all images for a given property, ordered by orden ASC.
     */
    public function getByPropiedad(int $idPropiedad): array
    {
        return $this->where('idPropiedad', $idPropiedad)
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
}
