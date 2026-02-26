<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
  <h2 class="text-2xl font-bold mb-6 text-center">Buscar Disponibilidad</h2>
  
  <div id="form-container" class="form-container">
    <div class="form-header">
        <h3 class="form-title">Detalles de tu estadía</h3>
        <button id="toggle-form" class="toggle-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
            Editar detalles
        </button>
    </div>
    
    <div id="search-summary" class="search-summary">
        <div class="summary-content">
            <div class="summary-item">
                <span>Fechas:</span>
                <p id="dates-summary"></p>
            </div>
            <div class="summary-item">
                <span>Huéspedes:</span>
                <p id="guests-summary"></p>
            </div>
        </div>
    </div>
    
    <form id="formBusqueda" method="get" action="<?= base_url('/reservas/disponibilidad') ?>" class="search-form">
        <div class="form-row">
            <div class="form-group">
                <label for="entrada" class="form-label">Entrada</label>
                <input type="date" id="entrada" name="entrada" value="<?= esc($entrada ?? '') ?>" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="salida" class="form-label">Salida</label>
                <input type="date" id="salida" name="salida" value="<?= esc($salida ?? '') ?>" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="adultos" class="form-label">Adultos</label>
                <input type="number" id="adultos" name="adultos" value="<?= esc($adultos ?? 1) ?>" min="1" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="menores" class="form-label">Menores (0-17 años)</label>
                <input type="number" id="menores" name="menores" value="<?= esc($menores ?? 0) ?>" min="0" class="form-input">
            </div>
        </div>
        
        <!-- Contenedor para edades de niños -->
        <div id="edades-menores-container" class="edades-container">
            <label class="form-label">Edades de los menores:</label>
            <div id="edades-menores" class="edades-grid">
                <!-- Las edades se generan dinámicamente con JavaScript -->
            </div>
        </div>
        
        <button type="submit" class="submit-btn">
            Buscar
        </button>
    </form>
  </div>

  <!-- Listado de habitaciones -->
  <div id="resultado" class="rooms-container">
    <?php if (!empty($habitaciones)): ?>
      <?php foreach ($habitaciones as $h): ?>
        <div class="room-card">
          <!-- Imagen de la habitación -->
          <div class="room-image">
            <?php if (!empty($h['habitacion']['imagen'])): ?>
              <img src="<?= base_url('uploads/' . esc($h['habitacion']['imagen'])) ?>" alt="Imagen habitación" class="room-img">
            <?php else: ?>
              <div class="image-placeholder">
                <span>Imagen no disponible</span>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Información de la habitación -->
          <div class="room-content">
            <div class="room-header">
              <div>
                <h3 class="room-title"><?= esc($h['habitacion']['tipo']) ?></h3>
                <p class="room-description line-clamp-2"><?= esc($h['habitacion']['descripcion'] ?? '') ?></p>
                
                <!-- Características destacadas -->
                <div class="room-features">
                  <?php 
                  $features = [
                    'wifi' => 'Wi-Fi Gratis',
                    'tv' => 'TV Pantalla Plana',
                    'ac' => 'Aire Acondicionado',
                    'breakfast' => 'Desayuno Incluido'
                  ];
                  
                  $randomFeatures = array_rand($features, 4);
                  foreach ($randomFeatures as $featureKey): 
                  ?>
                    <span class="feature-tag"><?= $features[$featureKey] ?></span>
                  <?php endforeach; ?>
                  
                  <button class="details-btn ver-detalles-btn" 
                          data-descripcion="<?= esc($h['habitacion']['descripcion'] ?? '') ?>">
                    Ver más detalles
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- Precio desde -->
              <div class="price-container">
                <p class="price-label">Desde</p>
                <p class="price-amount">
                  $<?= number_format(min(array_column($h['tarifas'], 'precio')), 2) ?>
                </p>
                <p class="price-note">por noche</p>
              </div>
            </div>
            
            <!-- Tarifas disponibles -->
            <div class="tarifas-section">
              <h4 class="tarifas-title">Opciones de tarifa:</h4>
              <div class="tarifas-list">
                <?php foreach ($h['tarifas'] as $t): ?>
                  <div class="tarifa-item">
                    <div class="tarifa-content">
                      <div>
                        <h5 class="tarifa-name"><?= esc($t['nombre']) ?></h5>
                        <p class="tarifa-capacidad">Capacidad: <?= esc($t['capacidad'] ?? '-') ?> personas</p>
                      </div>
                      <div class="tarifa-precio">
                        <p class="tarifa-amount">$<?= number_format($t['precio'], 2) ?></p>
                        <p class="tarifa-note">por noche</p>
                        <a href="<?= base_url('/reservas/reservar/' . $t['idTarifa'] . '?entrada=' . esc($entrada) . '&salida=' . esc($salida) . '&huespedes=' . esc($huespedes)) ?>" 
                           class="select-btn">
                          Seleccionar
                        </a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty-state">
        <p class="empty-text">No se encontraron habitaciones disponibles para las fechas seleccionadas.</p>
        <p class="empty-subtext">Intenta con otras fechas o ajusta el número de huéspedes.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal para detalles de habitación -->
<div id="modal-detalles" class="modal hidden">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Detalles de la habitación</h3>
      <button id="close-modal" class="close-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="modal-body">
      <div id="modal-content">
        <!-- El contenido se llenará dinámicamente -->
      </div>
    </div>
  </div>
</div>

<script>
// El JavaScript se mantiene igual, solo cambian los selectores de clase
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('formBusqueda');
  const toggleFormBtn = document.getElementById('toggle-form');
  const searchSummary = document.getElementById('search-summary');
  const datesSummary = document.getElementById('dates-summary');
  const guestsSummary = document.getElementById('guests-summary');
  const modal = document.getElementById('modal-detalles');
  const modalContent = document.getElementById('modal-content');
  const closeModal = document.getElementById('close-modal');
  
  // Mostrar/ocultar formulario
  toggleFormBtn.addEventListener('click', function() {
    const formEl = document.getElementById('formBusqueda');
    const isHidden = formEl.classList.contains('hidden');
    
    if (isHidden) {
      formEl.classList.remove('hidden');
      searchSummary.classList.add('hidden');
    } else {
      formEl.classList.add('hidden');
      updateSearchSummary();
      searchSummary.classList.remove('hidden');
    }
  });
  
  // Actualizar resumen de búsqueda
  function updateSearchSummary() {
    const entrada = document.getElementById('entrada').value;
    const salida = document.getElementById('salida').value;
    const adultos = document.getElementById('adultos').value;
    const menores = document.getElementById('menores').value;
    
    const formatDate = (dateString) => {
      const options = { day: 'numeric', month: 'short' };
      return new Date(dateString).toLocaleDateString('es-ES', options);
    };
    
    datesSummary.textContent = `${formatDate(entrada)} - ${formatDate(salida)}`;
    
    const totalHuespedes = parseInt(adultos) + parseInt(menores);
    guestsSummary.textContent = `${totalHuespedes} ${totalHuespedes == 1 ? 'huésped' : 'huéspedes'}`;
  }
  
  // Botones "Ver detalles"
  document.querySelectorAll('.ver-detalles-btn').forEach(button => {
    button.addEventListener('click', function() {
      const descripcion = this.getAttribute('data-descripcion');
      modalContent.innerHTML = `<p>${descripcion}</p>`;
      modal.classList.remove('hidden');
    });
  });
  
  // Cerrar modal
  closeModal.addEventListener('click', function() {
    modal.classList.add('hidden');
  });
  
  // Cerrar modal al hacer clic fuera
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      modal.classList.add('hidden');
    }
  });
  
  // AJAX para búsqueda (se mantiene igual)
  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (document.getElementById('formBusqueda').classList.contains('hidden')) {
      updateSearchSummary();
    }
    
    // ... resto del código AJAX igual
  });
  
  // Inicializar resumen si hay datos
  if (document.getElementById('entrada').value) {
    updateSearchSummary();
    searchSummary.classList.remove('hidden');
  }
});
</script>

<?= $this->endSection() ?>