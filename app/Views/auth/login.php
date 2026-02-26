<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; padding: 40px 20px;">
  <div style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 450px; width: 100%; padding: 40px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
      <h1 style="font-size: 1.8rem; color: #1f2937; font-weight: 700; margin-bottom: 10px;">¡Bienvenido de nuevo!</h1>
      <p style="color: #6b7280; font-size: 0.95rem;">Ingresa a tu cuenta para continuar</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
        <ul style="margin: 0; padding-left: 20px;">
          <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Botones Sociales -->
    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
      <a href="#" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px; background-color: white; border: 1px solid #d1d5db; border-radius: 6px; color: #374151; font-weight: 500; text-decoration: none; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='white'">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="width: 20px; height: 20px; margin-right: 10px;">
        Continuar con Google
      </a>
      
      <a href="#" style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 12px; background-color: #1877f2; border: 1px solid #1877f2; border-radius: 6px; color: white; font-weight: 500; text-decoration: none; transition: background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.backgroundColor='#166fe5'" onmouseout="this.style.backgroundColor='#1877f2'">
        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook" style="width: 20px; height: 20px; margin-right: 10px; filter: brightness(0) invert(1);">
        Continuar con Facebook
      </a>
    </div>

    <!-- Divisor -->
    <div style="display: flex; align-items: center; margin-bottom: 25px;">
      <div style="flex-grow: 1; height: 1px; background-color: #e5e7eb;"></div>
      <span style="padding: 0 15px; color: #9ca3af; font-size: 0.85rem; text-transform: uppercase;">O ingresa con tu email</span>
      <div style="flex-grow: 1; height: 1px; background-color: #e5e7eb;"></div>
    </div>

    <!-- Formulario Tradicional -->
    <form action="<?= base_url('auth/processLogin') ?>" method="post">
      <?= csrf_field() ?> 

      <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; color: #4b5563; font-size: 0.9rem; font-weight: 500;">Correo Electrónico</label>
        <input type="email" name="email" value="<?= old('email') ?>" required style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 1rem; transition: border 0.3s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#d1d5db'">
      </div>

      <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 5px; color: #4b5563; font-size: 0.9rem; font-weight: 500;">Contraseña</label>
        <input type="password" name="contraseña" required style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 1rem; transition: border 0.3s;" onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#d1d5db'">
      </div>

      <button type="submit" style="width: 100%; padding: 14px; background-color: #10b981; color: white; border: none; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
        Iniciar Sesión
      </button>
    </form>

    <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #f3f4f6;">
      <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">
        ¿No tienes cuenta? 
        <a href="<?= base_url('auth/register') ?>" style="color: #10b981; font-weight: 600; text-decoration: none;">Regístrate aquí</a>
      </p>
    </div>
  </div>
</div>
<?= $this->endSection() ?>