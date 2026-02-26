<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Agregar Imágenes - <?= esc($propiedad['titulo']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Panel Admin Header -->
<div style="background-color: #1f2937; padding: 30px 20px; color: white;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 1.8rem;">Gestionar Imágenes</h1>
            <p style="margin: 5px 0 0 0; color: #9ca3af;">Propiedad: <?= esc($propiedad['titulo']) ?></p>
        </div>
        <a href="<?= base_url('admin/dashboard') ?>" style="background-color: transparent; border: 1px solid #4b5563; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; transition: background 0.3s;">Volver al Panel</a>
    </div>
</div>

<div style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
    
    <?php if (session()->getFlashdata('success')): ?>
        <div style="background-color: #ecfdf5; border: 1px solid #86efac; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="background-color: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Sección de Carga de Imágenes -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 40px; border: 1px solid #f3f4f6;">
        <h2 style="font-size: 1.4rem; color: #1f2937; margin: 0 0 20px 0; font-weight: 700;">Agregar Nuevas Imágenes</h2>
        <p style="color: #6b7280; margin-bottom: 20px;">Sube múltiples imágenes de la propiedad. Cada imagen se ordenará automáticamente.</p>
        
        <form action="<?= base_url('admin/imagenes/guardar/' . $propiedad['idPropiedad']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div style="border: 2px dashed #d1d5db; padding: 40px; text-align: center; border-radius: 8px; background-color: #f9fafb; margin-bottom: 20px;" id="drop-area">
                <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #9ca3af; margin-bottom: 15px;"></i>
                <h4 style="margin: 0 0 10px 0; color: #1f2937; font-size: 1.1rem;">Arrastra tus imágenes aquí</h4>
                <p style="margin: 0 0 15px 0; color: #6b7280;">O haz clic para seleccionar archivos</p>
                <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple style="width: 100%; font-size: 0.9rem; color: #4b5563;" onchange="previewImages(this)">
                <p style="margin: 15px 0 0 0; color: #9ca3af; font-size: 0.85rem;">Puedes seleccionar hasta 10 imágenes de una vez</p>
            </div>

            <!-- Preview de Imágenes Seleccionadas -->
            <div id="preview-container" style="display: none; margin-bottom: 20px;">
                <h4 style="color: #1f2937; margin: 0 0 15px 0; font-weight: 600;">Vista previa de imágenes seleccionadas:</h4>
                <div id="images-preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px;"></div>
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <a href="<?= base_url('admin/dashboard') ?>" style="padding: 12px 24px; color: #4b5563; text-decoration: none; font-weight: 600; border-radius: 6px; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">Cancelar</a>
                <button type="submit" style="background-color: #10b981; color: white; border: none; padding: 12px 24px; font-size: 1rem; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background 0.3s; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">Guardar Imágenes</button>
            </div>
        </form>
    </div>

    <!-- Galería Actual de Imágenes -->
    <?php if (!empty($imagenes)): ?>
    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #f3f4f6;">
        <h2 style="font-size: 1.4rem; color: #1f2937; margin: 0 0 20px 0; font-weight: 700;">Imágenes Actuales (<?= count($imagenes) ?>)</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px;">
            <?php foreach ($imagenes as $index => $imagen): ?>
            <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="position: relative; width: 100%; height: 150px; background-color: #f3f4f6; overflow: hidden;">
                    <img src="<?= base_url(esc($imagen['ruta'])) ?>" alt="Imagen <?= $index + 1 ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 5px; left: 5px; background-color: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">
                        #<?= $index + 1 ?>
                    </div>
                </div>
                <div style="padding: 12px; background-color: #f9fafb;">
                    <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 10px; word-break: break-all;">
                        <?= esc(basename($imagen['ruta'])) ?>
                    </div>
                    <a href="<?= base_url('admin/imagenes/eliminar/' . $imagen['idImagen'] . '/' . $propiedad['idPropiedad']) ?>" style="display: block; text-align: center; padding: 8px; background-color: #fee2e2; color: #b91c1c; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 0.85rem; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#fecaca'" onmouseout="this.style.backgroundColor='#fee2e2'" onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?');">
                        <i class="fas fa-trash-alt" style="margin-right: 5px;"></i>Eliminar
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div style="background: #f0fdf4; border: 1px solid #86efac; padding: 20px; border-radius: 8px; text-align: center;">
        <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #16a34a; margin-bottom: 10px;"></i>
        <p style="color: #166534; margin: 10px 0 0 0;">Esta propiedad aún no tiene imágenes adicionales. ¡Comienza por agregar algunas!</p>
    </div>
    <?php endif; ?>
</div>

<script>
function previewImages(input) {
    const container = document.getElementById('preview-container');
    const previewDiv = document.getElementById('images-preview');
    previewDiv.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        container.style.display = 'block';
        Array.from(input.files).slice(0, 10).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.style.cssText = 'position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #10b981;';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width: 100%; height: 120px; object-fit: cover;';
                
                const badge = document.createElement('div');
                badge.style.cssText = 'position: absolute; top: 5px; right: 5px; background-color: #10b981; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;';
                badge.textContent = (index + 1);
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(badge);
                previewDiv.appendChild(imgWrapper);
            };
            reader.readAsDataURL(file);
        });
    } else {
        container.style.display = 'none';
    }
}

// Drag and drop
const dropArea = document.getElementById('drop-area');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropArea.style.backgroundColor = '#ecfdf5';
    dropArea.style.borderColor = '#10b981';
}

function unhighlight(e) {
    dropArea.style.backgroundColor = '#f9fafb';
    dropArea.style.borderColor = '#d1d5db';
}

dropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    document.getElementById('imagenes').files = files;
    previewImages(document.getElementById('imagenes'));
}
</script>

<?= $this->endSection() ?>
