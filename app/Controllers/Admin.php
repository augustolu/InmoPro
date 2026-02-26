<?php
namespace App\Controllers;

use App\Helpers\ImageHelper;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }

    public function agregarPropiedad()
    {
        helper('form');
        return view('admin/agregar_propiedad');
    }

    public function guardarPropiedad()
    {
        helper('form');
        $propiedadModel = new \App\Models\PropiedadModel();
        $propiedadImagenModel = new \App\Models\PropiedadImagenModel();

        // Reglas de validación más permisivas (sin límite de tamaño en validación)
        $rules = [
            'titulo' => 'required|min_length[5]|max_length[255]',
            'ubicacion' => 'required|max_length[255]',
            'precio' => 'required|numeric',
            'habitaciones' => 'required|is_natural_no_zero',
            'banos' => 'required|is_natural_no_zero',
            'imagen_principal' => [
                'rules' => 'uploaded[imagen_principal]|is_image[imagen_principal]|mime_in[imagen_principal,image/jpg,image/jpeg,image/png,image/webp]|max_size[imagen_principal,10240]',
                'errors' => [
                    'uploaded' => 'Debes subir una imagen principal atractiva.',
                    'is_image' => 'El archivo debe ser una imagen.',
                    'mime_in' => 'Formatos permitidos: JPG, PNG, WEBP.',
                    'max_size' => 'La imagen es muy grande (máx 10MB antes de comprimir).'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Procesar la imagen principal
        $img = $this->request->getFile('imagen_principal');
        $newName = '';
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $uploadDir = FCPATH . 'uploads/propiedades';
            $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $newName;
            
            // Comprimir imagen
            if (!ImageHelper::compressImage($img->getTempName(), $uploadPath, 1920, 1080, 85)) {
                return redirect()->back()->withInput()->with('error', 'Error al procesar la imagen principal.');
            }
        }

        // Preparar datos para BD
        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'ubicacion' => $this->request->getPost('ubicacion'),
            'precio' => $this->request->getPost('precio'),
            'habitaciones' => $this->request->getPost('habitaciones'),
            'banos' => $this->request->getPost('banos'),
            'metros_cuadrados' => $this->request->getPost('metros_cuadrados') ?: null,
            'descripcion' => $this->request->getPost('descripcion'),
            'imagen_principal' => 'uploads/propiedades/' . $newName,
            'estado' => 'disponible'
        ];

        if ($propiedadModel->insert($data)) {
            $idPropiedad = $propiedadModel->insertID();
            
            // Procesar imágenes adicionales si existen
            $imagenes = $this->request->getFileMultiple('imagenes_adicionales');
            if ($imagenes) {
                $orden = 1;
                $uploadDir = FCPATH . 'uploads/propiedades';
                
                foreach ($imagenes as $imagen) {
                    if ($imagen->isValid() && !$imagen->hasMoved()) {
                        $nuevoNombre = $imagen->getRandomName();
                        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $nuevoNombre;
                        
                        // Comprimir imagen
                        if (ImageHelper::compressImage($imagen->getTempName(), $uploadPath, 1920, 1080, 85)) {
                            $propiedadImagenModel->insert([
                                'idPropiedad' => $idPropiedad,
                                'ruta' => 'uploads/propiedades/' . $nuevoNombre,
                                'orden' => $orden
                            ]);
                            $orden++;
                        }
                    }
                }
            }
            
            return redirect()->to('/admin/dashboard')->with('success', 'Propiedad agregada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al guardar la propiedad en la base de datos.');
        }
    }

    public function agregarImagenesPropiedad($idPropiedad)
    {
        $propiedadModel = new \App\Models\PropiedadModel();
        $propiedad = $propiedadModel->find($idPropiedad);

        if (!$propiedad) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Propiedad no encontrada.");
        }

        helper('form');
        $propiedadImagenModel = new \App\Models\PropiedadImagenModel();
        $imagenes = $propiedadImagenModel->getByPropiedad($idPropiedad);

        $data = [
            'title' => 'Gestionar Imágenes - ' . esc($propiedad['titulo']),
            'propiedad' => $propiedad,
            'imagenes' => $imagenes
        ];

        return view('admin/agregar_imagenes_propiedad', $data);
    }

    public function guardarImagenesPropiedad($idPropiedad)
    {
        helper('form');
        $propiedadModel = new \App\Models\PropiedadModel();
        $propiedad = $propiedadModel->find($idPropiedad);

        if (!$propiedad) {
            return redirect()->back()->with('error', 'Propiedad no encontrada.');
        }

        $propiedadImagenModel = new \App\Models\PropiedadImagenModel();
        
        // Validar que al menos una imagen fue subida
        $imagenes = $this->request->getFileMultiple('imagenes');
        if (!$imagenes || empty($imagenes[0]->getName())) {
            return redirect()->back()->with('error', 'Debes subir al menos una imagen.');
        }

        $orden = $propiedadImagenModel->where('idPropiedad', $idPropiedad)->countAllResults();
        $uploadDir = FCPATH . 'uploads/propiedades';
        $procesadas = 0;

        foreach ($imagenes as $imagen) {
            if ($imagen->isValid() && !$imagen->hasMoved()) {
                // Validar que sea una imagen
                if (!$imagen->isImage()) {
                    continue;
                }

                $nuevoNombre = $imagen->getRandomName();
                $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $nuevoNombre;
                
                // Comprimir imagen
                if (ImageHelper::compressImage($imagen->getTempName(), $uploadPath, 1920, 1080, 85)) {
                    $propiedadImagenModel->insert([
                        'idPropiedad' => $idPropiedad,
                        'ruta' => 'uploads/propiedades/' . $nuevoNombre,
                        'orden' => $orden
                    ]);
                    $orden++;
                    $procesadas++;
                }
            }
        }

        if ($procesadas > 0) {
            return redirect()->to('/admin/imagenes/' . $idPropiedad)->with('success', $procesadas . ' imagen(es) agregada(s) exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo procesar ninguna imagen.');
        }
    }

    public function eliminarImagenPropiedad($idImagen, $idPropiedad)
    {
        $propiedadImagenModel = new \App\Models\PropiedadImagenModel();
        $imagen = $propiedadImagenModel->find($idImagen);

        if (!$imagen || $imagen['idPropiedad'] != $idPropiedad) {
            return redirect()->back()->with('error', 'Imagen no encontrada.');
        }

        // Eliminar archivo del servidor
        if (file_exists(FCPATH . $imagen['ruta'])) {
            unlink(FCPATH . $imagen['ruta']);
        }

        // Eliminar registro de BD
        $propiedadImagenModel->delete($idImagen);

        return redirect()->to('/admin/imagenes/' . $idPropiedad)->with('success', 'Imagen eliminada exitosamente.');
    }
}
