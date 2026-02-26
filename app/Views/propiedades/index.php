<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div style="background-color: #f3f4f6; padding: 60px 20px; min-height: 80vh;">
  <div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="text-align: center; margin-bottom: 50px;">
      <h1 style="font-size: 2.5rem; color: #1f2937; margin-bottom: 10px; font-weight: 800;">Propiedades Disponibles</h1>
      <p style="color: #6b7280; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Encuentra el hogar de tus sueños entre nuestras exclusivas opciones.</p>
    </div>

    <?php if (empty($propiedades)): ?>
      <!-- Estado Vacío -->
      <div style="display: flex; align-items: center; justify-content: center; padding: 40px 0;">
        <div style="text-align: center; padding: 50px 40px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; width: 100%;">
          <i class="fas fa-home" style="font-size: 4rem; color: #9ca3af; margin-bottom: 20px;"></i>
          <h2 style="font-size: 2rem; color: #1f2937; margin-bottom: 15px; font-weight: 700;">No hay propiedades disponibles</h2>
          <p style="color: #6b7280; font-size: 1.1rem; line-height: 1.6; margin-bottom: 30px;">
            Actualmente no tenemos propiedades listadas en el sistema. Estamos trabajando para traerte las mejores opciones del mercado muy pronto.
          </p>
          <a href="<?= base_url('/') ?>" style="display: inline-block; padding: 12px 25px; background-color: #10b981; color: white; text-decoration: none; border-radius: 6px; font-weight: 600; transition: background-color 0.3s; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
            Volver al Inicio
          </a>
        </div>
      </div>
    <?php else: ?>
      <!-- Grilla de Propiedades -->
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
        <?php foreach ($propiedades as $prop): ?>
          <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease; display: flex; flex-direction: column;">
            
            <!-- Imagen -->
            <div style="position: relative; height: 250px; overflow: hidden;">
              <?php if (!empty($prop['imagen_principal'])): ?>
                <img src="<?= base_url(esc($prop['imagen_principal'])) ?>" alt="<?= esc($prop['titulo']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
              <?php else: ?>
                <div style="width: 100%; height: 100%; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                  <i class="fas fa-image" style="font-size: 3rem;"></i>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Contenido -->
            <div style="padding: 25px; flex-grow: 1; display: flex; flex-direction: column;">
              
              <div style="margin-bottom: 15px;">
                <h3 style="margin: 0 0 10px 0; font-size: 1.4rem; color: #1f2937; font-weight: 700; line-height: 1.3;">
                  <?= esc($prop['titulo']) ?>
                </h3>
                <!-- Ubicacion badge Google Maps -->
                <a href="<?= esc('https://www.google.com/maps/search/?api=1&query=' . urlencode($prop['ubicacion'])) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px; background: #EEF2FF; color: #4F46E5; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600; max-width: 100%; border: 1px solid #C7D2FE; transition: background 0.2s;" onmouseover="this.style.background='#E0E7FF'" onmouseout="this.style.background='#EEF2FF'">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="#4285F4"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                  <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 200px;"><?= esc($prop['ubicacion']) ?></span>
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="#4F46E5"><path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                </a>
              </div>

              <div style="font-size: 1.8rem; font-weight: 800; color: #10b981; margin-bottom: 20px;">
                $<?= number_format($prop['precio'], 0, ',', '.') ?> <span style="font-size: 1rem; color: #6b7280; font-weight: 500;">/ noche</span>
              </div>

              <!-- Características Cortas -->
              <div style="display: flex; gap: 15px; border-top: 1px solid #f3f4f6; border-bottom: 1px solid #f3f4f6; padding: 15px 0; margin-bottom: 20px; color: #4b5563; font-size: 0.95rem;">
                <div style="display: flex; align-items: center; gap: 6px;" title="Habitaciones">
                  <i class="fas fa-bed" style="color: #9ca3af;"></i> <?= esc($prop['habitaciones']) ?>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;" title="Baños">
                  <i class="fas fa-bath" style="color: #9ca3af;"></i> <?= esc($prop['banos']) ?>
                </div>
                <?php if (!empty($prop['metros_cuadrados'])): ?>
                <div style="display: flex; align-items: center; gap: 6px;" title="Metros Cuadrados">
                  <i class="fas fa-vector-square" style="color: #9ca3af;"></i> <?= esc($prop['metros_cuadrados']) ?> m&sup2;
                </div>
                <?php endif; ?>
              </div>
              
              <!-- Botón Ver Detalles -->
              <div style="margin-top: auto;">
                <a href="<?= base_url('propiedades/detalle/' . esc($prop['idPropiedad'])) ?>" style="display: block; text-align: center; width: 100%; padding: 12px 0; background-color: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-weight: 600; border: 1px solid #e5e7eb; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.borderColor='#d1d5db';" onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.borderColor='#e5e7eb';">
                  Ver Detalles
                </a>
              </div>
              
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>

<style>
/* Hover effect for cards */
div[style*="transition: transform 0.3s ease"]:hover {
    transform: translateY(-5px);
}
div[style*="transition: transform 0.3s ease"]:hover img {
    transform: scale(1.05);
}
</style>

<?= $this->endSection() ?>
