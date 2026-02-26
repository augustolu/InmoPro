<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idUsuario';
    protected $allowedFields = ['nombre', 'email', 'contraseña', 'rol'];
    protected $useTimestamps = true;
}
