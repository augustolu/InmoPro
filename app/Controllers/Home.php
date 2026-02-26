<?php

namespace App\Controllers;

use App\Models\PropiedadModel;

class Home extends BaseController
{
    public function index()
    {
        $propiedadModel = new PropiedadModel();
        $propiedades = $propiedadModel->where('estado', 'disponible')->orderBy('created_at', 'DESC')->findAll();
        
        return view('home/index', [
            'propiedades' => $propiedades
        ]);
    }
}
