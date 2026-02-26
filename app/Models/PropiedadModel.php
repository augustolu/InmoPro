<?php

namespace App\Models;

use CodeIgniter\Model;

class PropiedadModel extends Model
{
    protected $table            = 'propiedades';
    protected $primaryKey       = 'idPropiedad';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Todos los campos de la base de datos permitidos para inserción o actualización
    protected $allowedFields    = [
        'titulo',
        'descripcion',
        'precio',
        'ubicacion',
        'habitaciones',
        'banos',
        'metros_cuadrados',
        'imagen_principal',
        'estado'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Basic Rules
    protected $validationRules      = [
        'titulo'       => 'required|min_length[5]|max_length[255]',
        'precio'       => 'required|numeric',
        'ubicacion'    => 'required|max_length[255]',
        'habitaciones' => 'required|is_natural_no_zero',
        'banos'        => 'required|is_natural_no_zero'
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
