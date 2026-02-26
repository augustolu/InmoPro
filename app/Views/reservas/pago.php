<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold mb-4">Pago de la Reserva</h2>

  <p>Reserva Nº <?= esc($reserva['idReserva']) ?></p>
  <p>Habitación: <?= esc($habitacion['tipo']) ?> (<?= esc($tarifa['nombre']) ?>)</p>
  <p>Total a pagar: <strong>$<?= number_format($reserva['total'],2) ?></strong></p>

  <div class="mt-4">
    <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded">Pagar con MercadoPago</a>
    <a href="#" class="px-4 py-2 bg-green-600 text-white rounded">Pagar con Tarjeta</a>
  </div>
</div>

<?= $this->endSection() ?>
