<?php

namespace App\Controllers;

use App\Models\HabitacionModel;
use App\Models\ReservaModel;
use App\Models\TarifaModel;
use App\Models\PropiedadReservaModel;
use App\Models\PropiedadModel;

class Reservas extends BaseController
{
    public function index()
    {
        return view('reservas/listado');
    }

    /**
     * API: Obtiene disponibilidad de fechas para una propiedad
     */
    public function disponibilidadPropiedad($idPropiedad)
    {
        $propiedadModel = new PropiedadModel();
        $propiedad = $propiedadModel->find($idPropiedad);

        if (!$propiedad) {
            return $this->response->setJSON(['error' => 'Propiedad no encontrada'])->setStatusCode(404);
        }

        // Obtener rango de fechas (3 meses desde hoy)
        $fechaInicio = date('Y-m-d');
        $fechaFin = date('Y-m-d', strtotime('+3 months'));

        $reservaModel = new PropiedadReservaModel();
        $disponibilidad = $reservaModel->obtenerDisponibilidad($idPropiedad, $fechaInicio, $fechaFin);

        return $this->response->setJSON([
            'propiedad' => $propiedad,
            'disponibilidad' => $disponibilidad,
            'precio_noche' => $propiedad['precio']
        ]);
    }

    /**
     * Muestra form de reserva de propiedad
     */
    public function reservarPropiedad($idPropiedad)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Debes iniciar sesión para hacer una reserva.');
        }

        $propiedadModel = new PropiedadModel();
        $propiedad = $propiedadModel->find($idPropiedad);

        if (!$propiedad || $propiedad['estado'] !== 'disponible') {
            return redirect()->back()->with('error', 'Propiedad no encontrada o no disponible.');
        }

        // Obtener disponibilidad
        $fechaInicio = date('Y-m-d');
        $fechaFin = date('Y-m-d', strtotime('+3 months'));

        $reservaModel = new PropiedadReservaModel();
        $disponibilidad = $reservaModel->obtenerDisponibilidad($idPropiedad, $fechaInicio, $fechaFin);

        $data = [
            'title' => 'Reservar: ' . esc($propiedad['titulo']),
            'propiedad' => $propiedad,
            'disponibilidad' => $disponibilidad,
            'fechaInicioMin' => $fechaInicio
        ];

        return view('reservas/reservar_propiedad', $data);
    }

    /**
     * Confirma reserva de propiedad
     */
    public function confirmarReservaPropiedad()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Debes iniciar sesión.');
        }

        $data = $this->request->getPost();
        
        $rules = [
            'idPropiedad' => 'required|integer',
            'fechaInicio' => 'required|valid_date',
            'fechaFin' => 'required|valid_date',
            'cantidadHuespedes' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $propiedadModel = new PropiedadModel();
        $propiedad = $propiedadModel->find($data['idPropiedad']);

        if (!$propiedad) {
            return redirect()->back()->with('error', 'Propiedad no encontrada.');
        }

        // Validar fechas
        $fechaInicio = new \DateTime($data['fechaInicio']);
        $fechaFin = new \DateTime($data['fechaFin']);
        $hoy = new \DateTime();

        if ($fechaInicio < $hoy || $fechaFin <= $fechaInicio) {
            return redirect()->back()->withInput()->with('error', 'Las fechas son inválidas.');
        }

        // Calcular noches
        $noches = $fechaInicio->diff($fechaFin)->days;
        if ($noches <= 0) {
            return redirect()->back()->with('error', 'Debe haber al menos 1 noche.');
        }

        // Verificar disponibilidad
        $reservaModel = new PropiedadReservaModel();
        if ($reservaModel->hayConflictoFechas($data['idPropiedad'], $data['fechaInicio'], $data['fechaFin'])) {
            return redirect()->back()->withInput()->with('error', 'Las fechas seleccionadas no están disponibles.');
        }

        // Calcular total
        $precioNoche = (float)$propiedad['precio'];
        $total = $precioNoche * $noches;

        // Crear reserva
        $reservaId = $reservaModel->insert([
            'idPropiedad' => $data['idPropiedad'],
            'idUsuario' => session()->get('idUsuario'),
            'fechaInicio' => $data['fechaInicio'],
            'fechaFin' => $data['fechaFin'],
            'cantidadHuespedes' => (int)$data['cantidadHuespedes'],
            'precio_por_noche' => $precioNoche,
            'total' => $total,
            'estado' => 'confirmada',
            'pago_estado' => 'pendiente',
            'comentarios' => $data['comentarios'] ?? null
        ]);

        if (!$reservaId) {
            return redirect()->back()->with('error', 'No se pudo crear la reserva.');
        }

        return redirect()->to('/mis-reservas-propiedades')->with('success', 'Reserva realizada con éxito.');
    }

    /**
     * Mis reservas de propiedades
     */
    public function misReservasPropiedades()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $reservaModel = new PropiedadReservaModel();
        $reservas = $reservaModel->getReservasUsuario(session()->get('idUsuario'));

        $data = [
            'title' => 'Mis Reservas de Propiedades',
            'reservas' => $reservas
        ];

        return view('reservas/mis_reservas_propiedades', $data);
    }

    /**
     * Métodos originales para habitaciones
     */
{
    $entrada = $this->request->getGet('entrada');
    $salida  = $this->request->getGet('salida');
    $huespedes = (int)$this->request->getGet('huespedes');

    $habitacionModel = new \App\Models\HabitacionModel();
    $rows = $habitacionModel->buscarDisponibles($entrada, $salida, $huespedes);

    $grouped = [];
    foreach ($rows as $r) {
        $id = $r['idHabitacion'];
        if (!isset($grouped[$id])) {
            $grouped[$id] = [
                'habitacion' => [
                    'idHabitacion' => $r['idHabitacion'],
                    'tipo' => $r['tipo'],
                    'descripcion' => $r['descripcion'] ?? '',
                    'imagen' => $r['imagen'] ?? '',
                ],
                'tarifas' => []
            ];
        }

        $grouped[$id]['tarifas'][] = [
            'idTarifa' => $r['idTarifa'],
            'nombre' => $r['tarifa_nombre'] ?? '',
            'precio' => $r['tarifa_precio'] ?? 0,
            'capacidad' => $r['tarifa_capacidad'] ?? null
        ];
    }

    if ($this->request->isAJAX()) {
        return $this->response->setJSON(['habitaciones' => $grouped]);
    }

    return view('reservas/listado', [
        'habitaciones' => $grouped,
        'entrada' => $entrada,
        'salida' => $salida,
        'huespedes' => $huespedes
    ]);
}


    /**
     * Mostrar confirmación de reserva para una tarifa concreta
     * URL: /reservas/reservar/{idTarifa}?entrada=...&salida=...&huespedes=...
     */
    public function reservar($idTarifa = null)
    {
        $entrada = $this->request->getGet('entrada');
        $salida = $this->request->getGet('salida');
        $huespedes = (int)$this->request->getGet('huespedes');

        if (! $idTarifa) {
            return redirect()->back()->with('error', 'Tarifa inválida');
        }

        $tarifaModel = new TarifaModel();
        $tarifa = $tarifaModel->find($idTarifa);

        if (! $tarifa) {
            return redirect()->back()->with('error', 'Tarifa no encontrada');
        }

        // Calcular noches
        $d1 = new \DateTime($entrada);
        $d2 = new \DateTime($salida);
        $interval = $d1->diff($d2);
        $noches = (int)$interval->format('%a');
        if ($noches <= 0) {
            return redirect()->back()->with('error', 'Fechas inválidas');
        }

        $precioNoche = (float)$tarifa['precio'];
        $total = $precioNoche * $noches;

        $habitacionModel = new HabitacionModel();
        $habitacion = $habitacionModel->find($tarifa['idHabitacion']);

        return view('reservas/confirmar', [
            'tarifa' => $tarifa,
            'habitacion' => $habitacion,
            'entrada' => $entrada,
            'salida' => $salida,
            'noches' => $noches,
            'precioNoche' => $precioNoche,
            'total' => $total,
            'huespedes' => $huespedes
        ]);
    }

    public function confirmar()
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error','Debes iniciar sesión para confirmar la reserva');
        }

        $data = $this->request->getPost();
        // Validar mínimamente
        $rules = [
            'idTarifa' => 'required|integer',
            'entrada' => 'required|valid_date',
            'salida' => 'required|valid_date',
            'huespedes' => 'required|integer|greater_than_equal_to[1]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tarifaModel = new TarifaModel();
        $tarifa = $tarifaModel->find($data['idTarifa']);

        if (! $tarifa) {
            return redirect()->back()->with('error','Tarifa inválida');
        }

        // Calcular noches y total
        $d1 = new \DateTime($data['entrada']);
        $d2 = new \DateTime($data['salida']);
        $noches = (int)$d1->diff($d2)->format('%a');
        if ($noches <= 0) return redirect()->back()->with('error','Fechas inválidas');

        $precioNoche = (float)$tarifa['precio'];
        $total = $precioNoche * $noches;

        $reservaModel = new ReservaModel();

        $insertId = $reservaModel->insert([
            'idUsuario' => session()->get('idUsuario'),
            'idHabitacion' => $tarifa['idHabitacion'],
            'idTarifa' => $tarifa['idTarifa'],
            'fechaInicio' => $data['entrada'],
            'fechaFin' => $data['salida'],
            'cantidadHuespedes' => (int)$data['huespedes'],
            'precio_por_noche' => $precioNoche,
            'total' => $total,
            'estado' => 'pendiente',
            'pago_estado' => 'pendiente',
            'comentarios' => $data['comentarios'] ?? null
        ]);

        if ($insertId === false) {
            return redirect()->back()->with('error','No se pudo crear la reserva');
        }

        return redirect()->to('/mis-reservas')->with('success','Reserva realizada con éxito');
    }
}

    


