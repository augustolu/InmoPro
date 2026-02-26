<!-- Header -->
<nav class="fixed w-full top-0 left-0 z-50 bg-white border-b border-gray-200 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <div class="flex-shrink-0">
        <a href="<?= base_url('/') ?>" class="text-2xl font-bold text-gray-900 uppercase tracking-wide">
          <?= config('TemplateSettings')->siteName ?>
        </a>
      </div>
      
      <!-- Desktop Navigation -->
      <div class="hidden md:flex items-center space-x-8">
        <a href="<?= base_url('/') ?>" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Inicio</a>
        <a href="<?= base_url('propiedades') ?>" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Propiedades</a>
        <a href="#" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Nosotros</a>
        <a href="#" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Contacto</a>
      </div>
      
      <!-- User Menu -->
      <div class="flex items-center space-x-4">
        <?php 
          $hideAuthButtons = (bool) preg_match('/\b(login|register)\b/', strtolower($_SERVER['REQUEST_URI'] ?? ''));
        ?>
        
        <?php if (!$hideAuthButtons): ?>
          <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 transition-colors py-2 px-3 rounded">
              <span class="material-icons text-lg">person</span>
              <?php if (session()->get('logged_in')): ?>
                <span class="text-sm font-medium hidden sm:inline"><?= esc(explode(' ', session()->get('nombre'))[0]) ?></span>
              <?php endif; ?>
            </button>
            
            <!-- Dropdown Menu -->
            <div class="hidden absolute right-0 mt-0 w-52 bg-white rounded-lg shadow-lg border border-gray-200 group-hover:block z-50">
              <?php if (!session()->get('logged_in')): ?>
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                  <p class="font-semibold text-sm text-gray-900">¿Aún no tienes cuenta?</p>
                  <p class="text-xs text-gray-500 mt-1">Regístrate para guardar favoritos.</p>
                </div>
                <a href="<?= base_url('auth/login') ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Iniciar Sesión</a>
                <a href="<?= base_url('auth/register') ?>" class="block px-4 py-3 text-sm text-emerald-600 font-semibold hover:bg-gray-50">Registrarse</a>
              <?php else: ?>
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                  <p class="font-semibold text-sm text-gray-900"><?= esc(session()->get('nombre')) ?></p>
                  <p class="text-xs text-gray-500 mt-1"><?= esc(session()->get('email') ?? (session()->get('rol') === 'admin' ? 'Administrador' : 'Cliente')) ?></p>
                </div>
                <?php if (session()->get('rol') === 'admin'): ?>
                  <a href="<?= base_url('admin/dashboard') ?>" class="block px-4 py-3 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700">Dashboard Admin</a>
                <?php else: ?>
                  <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Mis Favoritos</a>
                <?php endif; ?>
                <a href="<?= base_url('perfil') ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">Mi Perfil</a>
                <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium">Cerrar Sesión</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button class="text-gray-600 hover:text-emerald-600 p-2">
          <span class="material-icons">menu</span>
        </button>
      </div>
    </div>
  </div>
</nav>

<script>
  document.body.style.paddingTop = '80px';
</script>

