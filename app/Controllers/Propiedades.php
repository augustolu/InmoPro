<?php

namespace App\Controllers;

class Propiedades extends BaseController
{
    public function index()
    {
        // Redirigir al home que ahora contiene todas las propiedades
        return redirect()->to(base_url('/'));
    }

    public function detalle($id)
    {
        $propiedadModel = new \App\Models\PropiedadModel();
        $propiedadImagenModel = new \App\Models\PropiedadImagenModel();
        
        $propiedad = $propiedadModel->find($id);

        if (!$propiedad || $propiedad['estado'] !== 'disponible') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Propiedad no encontrada o no disponible.");
        }

        // Obtener las imágenes adicionales de la propiedad
        $imagenes = $propiedadImagenModel->getByPropiedad($id);

        $data = [
            'title' => esc($propiedad['titulo']) . ' | ' . config('TemplateSettings')->siteName,
            'propiedad' => $propiedad,
            'imagenes' => $imagenes
        ];

        return view('propiedades/detalle', $data);
    }
}
