<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div style="background-color: #f3f4f6; min-height: 100vh; padding: 40px 20px;">
  <div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Header Admin -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
      <div>
        <h1 style="margin: 0; font-size: 1.8rem; color: #1f2937; font-weight: 700;">Panel de Administración</h1>
        <p style="margin: 5px 0 0 0; color: #6b7280; font-size: 0.95rem;">Bienvenido, <?= session()->get('nombre') ?></p>
      </div>
      <a href="<?= base_url('auth/logout') ?>" style="padding: 10px 20px; background-color: #ef4444; color: white; border-radius: 6px; text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
        Cerrar Sesión
      </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
      <div style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
        <span style="font-weight: 500;"><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>

    <!-- Key Metrics Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
      
      <!-- Metric 1 -->
      <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center;">
        <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #d1fae5; color: #10b981; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; margin-right: 20px;">
          <i class="fas fa-home"></i>
        </div>
        <div>
          <p style="margin: 0; color: #6b7280; font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Total Propiedades</p>
          <h3 style="margin: 5px 0 0 0; font-size: 1.8rem; color: #1f2937; font-weight: 700;">124</h3>
        </div>
      </div>

      <!-- Metric 2 -->
      <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center;">
        <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #dbeafe; color: #3b82f6; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; margin-right: 20px;">
          <i class="fas fa-users"></i>
        </div>
        <div>
          <p style="margin: 0; color: #6b7280; font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Usuarios Activos</p>
          <h3 style="margin: 5px 0 0 0; font-size: 1.8rem; color: #1f2937; font-weight: 700;">892</h3>
        </div>
      </div>

      <!-- Metric 3 -->
      <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center;">
        <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #fef3c7; color: #f59e0b; display: flex; justify-content: center; align-items: center; font-size: 1.5rem; margin-right: 20px;">
          <i class="fas fa-envelope-open-text"></i>
        </div>
        <div>
          <p style="margin: 0; color: #6b7280; font-size: 0.9rem; font-weight: 500; text-transform: uppercase;">Consultas Nuevas</p>
          <h3 style="margin: 5px 0 0 0; font-size: 1.8rem; color: #1f2937; font-weight: 700;">45</h3>
        </div>
      </div>

    </div>

    <!-- Quick Actions and Recent Activity -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
      
      <!-- Panel de Actividad -->
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); padding: 30px;">
        <h2 style="margin: 0 0 20px 0; font-size: 1.3rem; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6; padding-bottom: 15px;">Listados Recientes</h2>
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
          <!-- Item 1 -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #f3f4f6; border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 15px;">
              <div style="width: 50px; height: 50px; background-color: #e5e7eb; border-radius: 6px; display: flex; justify-content: center; align-items: center; color: #9ca3af;">
                <i class="fas fa-image"></i>
              </div>
              <div>
                <h4 style="margin: 0; color: #374151; font-weight: 600; font-size: 1rem;">Departamento en el Centro</h4>
                <p style="margin: 3px 0 0 0; color: #6b7280; font-size: 0.85rem;">Ingresado por Juan Pérez</p>
              </div>
            </div>
            <span style="padding: 5px 12px; background-color: #d1fae5; color: #065f46; font-size: 0.8rem; font-weight: 600; border-radius: 99px;">Activo</span>
          </div>
          
          <!-- Item 2 -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #f3f4f6; border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 15px;">
              <div style="width: 50px; height: 50px; background-color: #e5e7eb; border-radius: 6px; display: flex; justify-content: center; align-items: center; color: #9ca3af;">
                <i class="fas fa-image"></i>
              </div>
              <div>
                <h4 style="margin: 0; color: #374151; font-weight: 600; font-size: 1rem;">Casa Quinta c/ Pileta</h4>
                <p style="margin: 3px 0 0 0; color: #6b7280; font-size: 0.85rem;">Ingresado por Ana González</p>
              </div>
            </div>
            <span style="padding: 5px 12px; background-color: #fef3c7; color: #b45309; font-size: 0.8rem; font-weight: 600; border-radius: 99px;">Revisión</span>
          </div>

        </div>
        
        <div style="text-align: center; margin-top: 20px;">
          <a href="#" style="color: #10b981; text-decoration: none; font-weight: 600; font-size: 0.95rem;">Ver todas las propiedades &rarr;</a>
        </div>
      </div>

      <!-- Accesos Rápidos -->
      <div style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); padding: 30px; align-self: start;">
        <h2 style="margin: 0 0 20px 0; font-size: 1.3rem; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6; padding-bottom: 15px;">Accesos Rápidos</h2>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <a href="<?= base_url('admin/propiedades/agregar') ?>" style="display: block; padding: 15px; background-color: #f8f9fa; color: #4b5563; text-decoration: none; border-radius: 8px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f8f9fa'">
            <i class="fas fa-plus-circle" style="color: #10b981; margin-right: 10px;"></i> Agregar Propiedad
          </a>
          <a href="#" style="display: block; padding: 15px; background-color: #f8f9fa; color: #4b5563; text-decoration: none; border-radius: 8px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f8f9fa'">
            <i class="fas fa-users" style="color: #3b82f6; margin-right: 10px;"></i> Gestionar Usuarios
          </a>
          <a href="#" style="display: block; padding: 15px; background-color: #f8f9fa; color: #4b5563; text-decoration: none; border-radius: 8px; font-weight: 500; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f8f9fa'">
            <i class="fas fa-cog" style="color: #6b7280; margin-right: 10px;"></i> Configuración del Sitio
          </a>
        </div>
      </div>

    </div>

  </div>
</div>
<?= $this->endSection() ?>
