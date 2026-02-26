<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Mis Reservas de Propiedades<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header -->
<div style="background-color: #1f2937; padding: 40px 20px; color: white;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="margin: 0; font-size: 2.5rem; font-weight: 800;">
            <i class="fas fa-calendar-check" style="margin-right: 10px;"></i>Mis Reservas de Propiedades
        </h1>
        <p style="margin: 10px 0 0 0; color: #d1d5db;">Gestiona todas tus reservas de propiedades</p>
    </div>
</div>

<div style="background-color: #f3f4f6; padding: 60px 20px; min-height: 60vh;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background-color: #ecfdf5; border: 1px solid #86efac; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background-color: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($reservas)): ?>
            <div style="background: white; border-radius: 12px; padding: 60px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <i class="fas fa-inbox" style="font-size: 4rem; color: #d1d5db; margin-bottom: 20px;"></i>
                <h2 style="color: #1f2937; font-size: 1.5rem; margin: 0 0 10px 0;">No tienes reservas aún</h2>
                <p style="color: #6b7280; margin-bottom: 30px;">Comienza a explorar nuestras propiedades y haz tu primera reserva.</p>
                <a href="<?= base_url('propiedades') ?>" style="display: inline-block; padding: 12px 30px; background-color: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
                    <i class="fas fa-search" style="margin-right: 8px;"></i>Ver Propiedades
                </a>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 20px;">
                <?php foreach ($reservas as $reserva): ?>
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: grid; grid-template-columns: 250px 1fr; gap: 20px;">
                    
                    <!-- Imagen de la Propiedad -->
                    <div style="background-color: #e5e7eb; overflow: hidden; height: 200px;">
                        <?php if ($reserva['imagen_principal']): ?>
                            <img src="<?= base_url(esc($reserva['imagen_principal'])) ?>" alt="<?= esc($reserva['titulo']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <i class="fas fa-image" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Detalles de la Reserva -->
                    <div style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                            <div>
                                <h3 style="margin: 0 0 5px 0; color: #1f2937; font-size: 1.3rem; font-weight: 700;">
                                    <?= esc($reserva['titulo']) ?>
                                </h3>
                                <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                                    ID Reserva: #<?= $reserva['idReserva'] ?>
                                </p>
                            </div>
                            <span style="background-color: <?= $reserva['estado'] === 'confirmada' ? '#ecfdf5' : '#fef2f2' ?>; color: <?= $reserva['estado'] === 'confirmada' ? '#166534' : '#991b1b' ?>; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">
                                <?= ucfirst($reserva['estado']) ?>
                            </span>
                        </div>

                        <!-- Fechas y Huéspedes -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb;">
                            <div>
                                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">
                                    <i class="fas fa-calendar-check" style="margin-right: 5px;"></i>Entrada
                                </p>
                                <p style="margin: 0; color: #1f2937; font-size: 1rem; font-weight: 600;">
                                    <?= date('d/m/Y', strtotime($reserva['fechaInicio'])) ?>
                                </p>
                            </div>
                            <div>
                                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">
                                    <i class="fas fa-calendar-times" style="margin-right: 5px;"></i>Salida
                                </p>
                                <p style="margin: 0; color: #1f2937; font-size: 1rem; font-weight: 600;">
                                    <?= date('d/m/Y', strtotime($reserva['fechaFin'])) ?>
                                </p>
                            </div>
                            <div>
                                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; text-transform: uppercase; font-weight: 600;">
                                    <i class="fas fa-users" style="margin-right: 5px;"></i>Huéspedes
                                </p>
                                <p style="margin: 0; color: #1f2937; font-size: 1rem; font-weight: 600;">
                                    <?= $reserva['cantidadHuespedes'] ?> <?= $reserva['cantidadHuespedes'] === 1 ? 'persona' : 'personas' ?>
                                </p>
                            </div>
                        </div>

                        <!-- Precio y Total -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem;">Precio por noche</p>
                                <p style="margin: 0; color: #1f2937; font-weight: 600;">
                                    $<?= number_format($reserva['precio_por_noche'], 0, ',', '.') ?>
                                </p>
                            </div>
                            <div style="text-align: right;">
                                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem;">Total</p>
                                <p style="margin: 0; color: #10b981; font-size: 1.3rem; font-weight: 700;">
                                    $<?= number_format($reserva['total'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Comentarios si existen -->
                        <?php if ($reserva['comentarios']): ?>
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 0.85rem; font-weight: 600;">
                                <i class="fas fa-comment" style="margin-right: 5px;"></i>Comentarios
                            </p>
                            <p style="margin: 0; color: #4b5563; font-size: 0.9rem; font-style: italic;">
                                <?= esc($reserva['comentarios']) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 250px 1fr;"] {
        grid-template-columns: 1fr !important;
    }
    div[style*="grid-template-columns: 1fr 1fr 1fr;"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?= $this->endSection() ?>
