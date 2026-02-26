<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? config('TemplateSettings')->companyName ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <!-- Custom Styles -->
  <style>
    :root {
      --primary: #10b981;
      --primary-hover: #059669;
    }
    
    body {
      font-family: 'Inter', sans-serif;
    }
    
    .btn-primary {
      @apply bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors;
    }
    
    .btn-secondary {
      @apply bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-2 px-6 rounded-lg transition-colors;
    }
  </style>
</head>

<body class="bg-white text-gray-900 <?= $bodyClass ?? '' ?>">

  <!-- Header -->
  <?= $this->include('layouts/header') ?>

  <!-- Contenido dinámico -->
  <main>
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Footer -->
  <?= $this->include('layouts/footer') ?>

</body>
</html>