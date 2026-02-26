<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Agregar Propiedad - Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Panel Admin Header -->
<div style="background-color: #1f2937; padding: 30px 20px; color: white;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 1.8rem;">Agregar Nueva Propiedad</h1>
            <p style="margin: 5px 0 0 0; color: #9ca3af;">Completa los datos para publicar un nuevo inmueble en el catálogo.</p>
        </div>
        <a href="<?= base_url('admin/dashboard') ?>" style="background-color: transparent; border: 1px solid #4b5563; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; transition: background 0.3s;">Volver al Panel</a>
    </div>
</div>

<div style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
    
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="background-color: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #f3f4f6;">
        <form action="<?= base_url('admin/propiedades/guardar') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Título -->
            <div style="margin-bottom: 20px;">
                <label for="titulo" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Título de la Publicación *</label>
                <input type="text" id="titulo" name="titulo" required placeholder="Ej: Hermoso Departamento en el Centro" value="<?= old('titulo') ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;" onfocus="this.style.borderColor='#10b981'; this.style.outline='none'" onblur="this.style.borderColor='#d1d5db'">
            </div>

            <!-- Ubicación con Preview de Google Maps -->
            <div style="margin-bottom: 20px;">
                <label for="ubicacion" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                    Ubicación / Dirección * 
                    <small style="color:#6b7280; font-weight:normal;">(escribe para previsualizar en el mapa)</small>
                </label>
                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 12px;">
                    <input type="text" id="ubicacion" name="ubicacion" required placeholder="Ej: Av. Corrientes 1234, Buenos Aires" value="<?= old('ubicacion') ?>" style="flex: 1; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; transition: border-color 0.3s;" onfocus="this.style.borderColor='#10b981'; this.style.outline='none'" onblur="this.style.borderColor='#d1d5db'" oninput="previewMap(this.value)">
                    <a id="maps-open-link" href="#" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 8px; padding: 12px 16px; background: #4285F4; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem; white-space: nowrap; transition: background 0.2s;" onmouseover="this.style.background='#3367D6'" onmouseout="this.style.background='#4285F4'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        Ver en Maps
                    </a>
                </div>

                <!-- Preview del mapa -->
                <div id="map-preview-container" style="border-radius: 10px; overflow: hidden; border: 2px solid #e5e7eb; height: 280px; position: relative; background: #f3f4f6;">
                    <div id="map-placeholder" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #9ca3af; gap: 12px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="#cbd5e0"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <p style="margin: 0; font-size: 0.95rem;">Escribe una dirección para previsualizar en el mapa</p>
                    </div>
                    <iframe id="map-iframe" src="" style="width: 100%; height: 100%; border: none; display: none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Precio -->
            <div style="margin-bottom: 20px;">
                <label for="precio" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Precio por Noche (USD o Moneda Local) *</label>
                <input type="number" id="precio" name="precio" required step="0.01" min="0" placeholder="Ej: 15000" value="<?= old('precio') ?>" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s;" onfocus="this.style.borderColor='#10b981'; this.style.outline='none'" onblur="this.style.borderColor='#d1d5db'">
            </div>

            <!-- Características -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px; background-color: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #edf2f7;">
                <div>
                    <label for="habitaciones" style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 0.9rem;">Habitaciones *</label>
                    <input type="number" id="habitaciones" name="habitaciones" required min="1" value="<?= old('habitaciones', 1) ?>" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                </div>
                <div>
                    <label for="banos" style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 0.9rem;">Baños *</label>
                    <input type="number" id="banos" name="banos" required min="1" value="<?= old('banos', 1) ?>" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                </div>
                <div>
                    <label for="metros_cuadrados" style="display: block; margin-bottom: 8px; font-weight: 600; color: #4b5563; font-size: 0.9rem;">Mt. Cuadrados</label>
                    <input type="number" id="metros_cuadrados" name="metros_cuadrados" min="1" placeholder="Ej: 80" value="<?= old('metros_cuadrados') ?>" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;">
                </div>
            </div>

            <!-- Descripción -->
            <div style="margin-bottom: 20px;">
                <label for="descripcion" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Descripción detallada</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe los beneficios, estado general, amenities, etc." style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; box-sizing: border-box; transition: border-color 0.3s; font-family: inherit; resize: vertical;" onfocus="this.style.borderColor='#10b981'; this.style.outline='none'" onblur="this.style.borderColor='#d1d5db'"><?= old('descripcion') ?></textarea>
            </div>

            <!-- Imagen Principal -->
            <div style="margin-bottom: 30px;">
                <label for="imagen_principal" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">Imagen Principal *</label>
                <div style="border: 2px dashed #d1d5db; padding: 20px; text-align: center; border-radius: 8px; background-color: #f9fafb; transition: all 0.3s;" id="drop-area">
                    <i class="fas fa-camera" style="font-size: 2rem; color: #9ca3af; margin-bottom: 10px;"></i>
                    <p style="margin: 0 0 10px 0; color: #6b7280;">Sube una imagen atractiva de la propiedad.</p>
                    <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*" style="width: 100%; font-size: 0.9rem; color: #4b5563;" onchange="previewImage(this)">
                    <div id="img-preview" style="margin-top: 15px; display: none;">
                        <img id="img-preview-src" src="" alt="Vista previa" style="max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>

            <!-- Imágenes Adicionales -->
            <div style="margin-bottom: 30px;">
                <label for="imagenes_adicionales" style="display: block; margin-bottom: 8px; font-weight: 600; color: #374151;">
                    <i class="fas fa-images" style="margin-right: 8px;"></i>Imágenes Adicionales (Opcional)
                </label>
                <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 12px;">Puedes subir múltiples imágenes para mostrar diferentes vistas de la propiedad.</p>
                <div style="border: 2px dashed #d1d5db; padding: 20px; text-align: center; border-radius: 8px; background-color: #f9fafb; transition: all 0.3s;" id="drop-area-adicionales">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #9ca3af; margin-bottom: 10px;"></i>
                    <p style="margin: 0 0 10px 0; color: #6b7280;">Sube hasta 10 imágenes adicionales de la propiedad.</p>
                    <input type="file" id="imagenes_adicionales" name="imagenes_adicionales[]" accept="image/*" multiple style="width: 100%; font-size: 0.9rem; color: #4b5563;" onchange="previewAdditionalImages(this)">
                    <div id="img-preview-adicionales" style="margin-top: 15px; display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px;">
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 15px; justify-content: flex-end; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <a href="<?= base_url('admin/dashboard') ?>" style="padding: 12px 24px; color: #4b5563; text-decoration: none; font-weight: 600; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">Cancelar</a>
                <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 12px 24px; font-size: 1rem; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background 0.3s; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">Guardar Propiedad</button>
            </div>
        </form>
    </div>
</div>

<style>
input[type="number"]::-webkit-inner-spin-button, 
input[type="number"]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>

<script>
let mapDebounce = null;

function previewMap(address) {
    const link = document.getElementById('maps-open-link');
    const iframe = document.getElementById('map-iframe');
    const placeholder = document.getElementById('map-placeholder');

    if (address.trim()) {
        link.href = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(address);
    }

    clearTimeout(mapDebounce);
    if (address.trim().length < 5) {
        iframe.style.display = 'none';
        placeholder.style.display = 'flex';
        return;
    }

    mapDebounce = setTimeout(() => {
        const embedUrl = 'https://maps.google.com/maps?q=' + encodeURIComponent(address) + '&output=embed&hl=es&z=15';
        iframe.src = embedUrl;
        iframe.style.display = 'block';
        placeholder.style.display = 'none';
    }, 800);
}

function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const previewSrc = document.getElementById('img-preview-src');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewSrc.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewAdditionalImages(input) {
    const container = document.getElementById('img-preview-adicionales');
    container.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        Array.from(input.files).slice(0, 10).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = document.createElement('div');
                imgDiv.style.cssText = 'position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width: 100%; height: 100px; object-fit: cover;';
                
                const badge = document.createElement('div');
                badge.style.cssText = 'position: absolute; top: 5px; right: 5px; background-color: rgba(0,0,0,0.7); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
                badge.textContent = (index + 1);
                
                imgDiv.appendChild(img);
                imgDiv.appendChild(badge);
                container.appendChild(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const ubicacion = document.getElementById('ubicacion').value;
    if(ubicacion.trim()) previewMap(ubicacion);
});
</script>

<?= $this->endSection() ?>
