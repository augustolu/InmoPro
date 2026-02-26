<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-2xl font-bold mb-4">Confirmar Reserva</h2>

  <div class="mb-4">
    <h3 class="font-semibold"><?= esc($habitacion['tipo']) ?> — <?= esc($tarifa['nombre']) ?></h3>
    <p class="text-sm text-gray-600"><?= esc($habitacion['descripcion']) ?></p>
  </div>

  <ul class="mb-4">
    <li>Entrada: <strong><?= esc($entrada) ?></strong></li>
    <li>Salida: <strong><?= esc($salida) ?></strong></li>
    <li>Noches: <strong><?= esc($noches) ?></strong></li>
    <li>Huéspedes: <strong><?= esc($huespedes) ?></strong></li>
    <li>Precio por noche: <strong>$<?= number_format($precioNoche,2) ?></strong></li>
    <li>Total: <strong>$<?= number_format($total,2) ?></strong></li>
  </ul>

  <form action="<?= base_url('reservas/confirmar') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="idTarifa" value="<?= esc($tarifa['idTarifa']) ?>">
    <input type="hidden" name="entrada" value="<?= esc($entrada) ?>">
    <input type="hidden" name="salida" value="<?= esc($salida) ?>">
    <input type="hidden" name="huespedes" value="<?= esc($huespedes) ?>">
    <div class="mb-3">
      <label class="block text-sm">Comentarios (opcional)</label>
      <textarea name="comentarios" class="w-full border rounded px-3 py-2" rows="3"></textarea>
    </div>

    <button type="submit" class="bg-[#4C6652] text-white px-4 py-2 rounded">Confirmar Reserva</button>
  </form>
</div>

<?= $this->endSection() ?>
