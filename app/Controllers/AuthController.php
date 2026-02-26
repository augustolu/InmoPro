<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processLogin()
    {
        $validation = $this->validate([
            'email'    => 'required|valid_email',
            'contraseña' => 'required|min_length[5]'
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $contraseña = $this->request->getPost('contraseña');

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            // Regenerar ID de sesión para evitar fixation
            session()->regenerate();

            session()->set([
                'idUsuario' => $usuario['idUsuario'],
                'nombre'    => $usuario['nombre'],
                'rol'       => $usuario['rol'],
                'logged_in' => true
            ]);

            if ($usuario['rol'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/'); 
        }

        
        return redirect()->back()->with('error', 'Credenciales inválidas');
    }

    public function processRegister()
    {
        $validation = $this->validate([
            'nombre'   => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[usuarios.email]',
            'contraseña' => 'required|min_length[5]'
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuarioModel = new UsuarioModel();

        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'email'    => $this->request->getPost('email'),
            'contraseña' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'rol'      => 'cliente' // por defecto todos los nuevos usuarios son clientes
        ];

        $usuarioModel->insert($data);

        return redirect()->to('auth/login')->with('success', 'Registro exitoso. Inicia sesión.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
