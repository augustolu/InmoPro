<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
      <!-- Company Info -->
      <div class="md:col-span-2">
        <h2 class="text-2xl font-bold text-white mb-4 uppercase tracking-wider"><?= config('TemplateSettings')->siteName ?></h2>
        <p class="text-gray-400 max-w-sm leading-relaxed mb-6">
          <?= config('TemplateSettings')->aboutText ?>
        </p>
        
        <!-- Social Links -->
        <div class="flex space-x-4">
          <a href="<?= config('TemplateSettings')->socialFacebook ?>" class="text-gray-400 hover:text-emerald-500 transition-colors">
            <span class="material-icons">facebook</span>
          </a>
          <a href="<?= config('TemplateSettings')->socialInstagram ?>" class="text-gray-400 hover:text-emerald-500 transition-colors">
            <span class="material-icons">photo_camera</span>
          </a>
          <a href="<?= config('TemplateSettings')->socialTwitter ?>" class="text-gray-400 hover:text-emerald-500 transition-colors">
            <span class="material-icons">alternate_email</span>
          </a>
        </div>
      </div>
      
      <!-- Quick Links -->
      <div>
        <h4 class="text-lg font-semibold text-white mb-6">Enlaces Rápidos</h4>
        <ul class="space-y-3">
          <li><a href="<?= base_url('/') ?>" class="text-gray-400 hover:text-emerald-500 transition-colors text-sm">Inicio</a></li>
          <li><a href="<?= base_url('propiedades') ?>" class="text-gray-400 hover:text-emerald-500 transition-colors text-sm">Propiedades</a></li>
          <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors text-sm">Nosotros</a></li>
          <li><a href="#" class="text-gray-400 hover:text-emerald-500 transition-colors text-sm">Contacto</a></li>
        </ul>
      </div>
      
      <!-- Contact Info -->
      <div>
        <h4 class="text-lg font-semibold text-white mb-6">Contacto</h4>
        <ul class="space-y-3 text-sm text-gray-400">
          <li class="flex items-start">
            <span class="material-icons text-emerald-500 mr-2 text-lg">location_on</span>
            <span><?= config('TemplateSettings')->contactAddress ?></span>
          </li>
          <li class="flex items-center">
            <span class="material-icons text-emerald-500 mr-2 text-lg">phone</span>
            <span><?= config('TemplateSettings')->contactPhone ?></span>
          </li>
          <li class="flex items-center">
            <span class="material-icons text-emerald-500 mr-2 text-lg">email</span>
            <span><?= config('TemplateSettings')->contactEmail ?></span>
          </li>
        </ul>
      </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
      <p><?= config('TemplateSettings')->footerText ?></p>
      <div class="flex space-x-6 mt-4 md:mt-0">
        <a href="#" class="hover:text-white transition-colors">Privacidad</a>
        <a href="#" class="hover:text-white transition-colors">Términos</a>
      </div>
    </div>
  </div>
</footer>

