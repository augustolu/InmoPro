<?= $this->extend('layouts/main') ?>
<?php 
$bodyClass = 'home-page';
?>
<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden bg-gradient-to-b from-gray-50 to-white">
  <!-- Background Image with Overlay -->
  <div class="absolute inset-0">
    <img src="<?= base_url('assets/img/nieve.jpg') ?>" alt="Background" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/50"></div>
  </div>
  
  <!-- Hero Content -->
  <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight drop-shadow-lg">
      <?= config('TemplateSettings')->heroTitle ?>
    </h1>
    <p class="text-xl md:text-2xl text-gray-100 mb-10 font-light drop-shadow-md max-w-2xl mx-auto">
      <?= config('TemplateSettings')->heroSubtitle ?>
    </p>
    <a href="#propiedades" class="inline-block btn-primary text-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-4 px-8 rounded-lg">
      <span class="flex items-center justify-center gap-2">
        <?= config('TemplateSettings')->heroButtonText ?>
        <span class="material-icons text-lg">arrow_downward</span>
      </span>
    </a>
  </div>
</section>

<!-- Search Bar Removed - Scroll to Properties Below -->

<!-- Featured Properties Section -->
<section id="propiedades" class="py-20 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-2"><?= config('TemplateSettings')->featuredTitle ?></h2>
      <p class="text-gray-600 text-sm md:text-base max-w-xl mx-auto"><?= config('TemplateSettings')->featuredSubtitle ?></p>
    </div>
    
    <?php if (!empty($propiedades)): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($propiedades as $prop): ?>
          <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col hover:-translate-y-1">
            <!-- Image -->
            <div class="relative h-64 overflow-hidden bg-gray-200">
              <?php if (!empty($prop['imagen_principal'])): ?>
                <img src="<?= base_url(esc($prop['imagen_principal'])) ?>" alt="<?= esc($prop['titulo']) ?>" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
              <?php else: ?>
                <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-400">
                  <span class="material-icons text-6xl">image</span>
                </div>
              <?php endif; ?>
            </div>
            
            <!-- Info -->
            <div class="p-6 flex flex-col flex-grow">
              <div class="mb-3">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                  <?= esc($prop['titulo']) ?>
                </h3>
                <!-- Location Badge -->
                <a href="<?= esc('https://www.google.com/maps/search/?api=1&query=' . urlencode($prop['ubicacion'])) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold hover:bg-blue-200 transition-colors">
                  <span class="material-icons text-sm">location_on</span>
                  <span class="truncate"><?= esc($prop['ubicacion']) ?></span>
                  <span class="material-icons text-xs">open_in_new</span>
                </a>
              </div>

              <div class="text-3xl font-bold text-emerald-600 mb-4">
                $<?= number_format($prop['precio'], 0, ',', '.') ?> <span class="text-sm text-gray-500 font-normal">/noche</span>
              </div>

              <!-- Features -->
              <div class="flex gap-4 border-t border-b border-gray-100 py-3 mb-4 text-gray-600 text-sm">
                <span class="flex items-center gap-1">
                  <span class="material-icons text-base">bed</span> 
                  <?= esc($prop['habitaciones']) ?>
                </span>
                <span class="flex items-center gap-1">
                  <span class="material-icons text-base">bathtub</span> 
                  <?= esc($prop['banos']) ?>
                </span>
                <?php if (!empty($prop['metros_cuadrados'])): ?>
                  <span class="flex items-center gap-1">
                    <span class="material-icons text-base">square_foot</span> 
                    <?= esc($prop['metros_cuadrados']) ?>m²
                  </span>
                <?php endif; ?>
              </div>
              
              <!-- Button -->
              <a href="<?= base_url('propiedades/detalle/' . esc($prop['idPropiedad'])) ?>" class="mt-auto w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-3 px-4 rounded-lg transition-colors">
                Ver Detalles
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <!-- Empty State -->
      <div class="flex items-center justify-center py-20">
        <div class="text-center bg-white rounded-lg p-12 max-w-md">
          <span class="material-icons text-6xl text-gray-300 block mb-4">home</span>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">No hay propiedades disponibles</h3>
          <p class="text-gray-600 mb-6">Estamos trabajando para traerte las mejores opciones muy pronto.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
  // Smooth scroll al hacer clic en el botón
  document.querySelectorAll('a[href="#propiedades"]').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.getElementById('propiedades');
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
</script>

<?= $this->endSection() ?>
