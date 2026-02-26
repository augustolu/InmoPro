<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si hay sesión activa
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión.');
        }

        // Si el filtro requiere admin y el usuario no lo es
        if ($arguments && in_array('admin', $arguments)) {
            if (session()->get('rol') !== 'admin') {
                return redirect()->to('/')->with('error', 'Acceso no autorizado.');
            }
        }

        return null; // Deja pasar
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos nada acá por ahora
    }
}