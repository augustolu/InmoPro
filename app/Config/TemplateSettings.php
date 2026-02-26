<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class TemplateSettings extends BaseConfig
{
    // =========================================================================
    // GENERAL COMPANY INFORMATION
    // =========================================================================
    public $siteName        = 'InmoPro';
    public $companyName     = 'InmoPro Bienes Raíces';
    public $tagline         = 'Tu lugar ideal te espera';
    public $contactEmail    = 'contacto@inmopro.com';
    public $contactPhone    = '+54 11 1234-5678';
    public $whatsapp        = '+54 11 1234-5678';
    public $contactAddress  = 'Av. Principal 123, Ciudad, País';

    // =========================================================================
    // HERO SECTION (HOME PAGE)
    // =========================================================================
    public $heroTitle       = 'Encontrá tu lugar ideal con InmoPro';
    public $heroSubtitle    = 'Las mejores propiedades, la atención más exclusiva.';
    public $heroButtonText  = 'Ver Propiedades';
    public $heroImage       = 'assets/img/nieve.jpg';

    // =========================================================================
    // FEATURED SECTION (Home properties header)
    // =========================================================================
    // Texto corto y profesional para la sección de propiedades en el home
    public $featuredTitle   = 'Propiedades';
    public $featuredSubtitle = '';

    // =========================================================================
    // WHY US SECTION
    // =========================================================================
    public $whyUsTitle      = 'Por qué elegirnos';
    public $whyUsFeature1   = ['icon' => 'verified_user', 'title' => 'Confianza Absoluta', 'desc' => 'Transparencia total en cada operación inmobiliaria. Todos nuestros procesos están validados.'];
    public $whyUsFeature2   = ['icon' => 'home_work', 'title' => 'Amplio Catálogo', 'desc' => 'Las propiedades más variadas del mercado en todas las categorías y ubicaciones.'];
    public $whyUsFeature3   = ['icon' => 'support_agent', 'title' => 'Soporte 24/7', 'desc' => 'Agentes disponibles para responder tus consultas en cualquier momento del día.'];

    // =========================================================================
    // COLORS & BRANDING
    // =========================================================================
    public $primaryColor    = '#10b981';  // Emerald 600
    public $primaryHover    = '#059669';  // Emerald 700
    public $secondaryColor  = '#6b7280'; // Gray 500

    // =========================================================================
    // SOCIAL NETWORKS
    // =========================================================================
    public $socialFacebook  = 'https://facebook.com/inmopro';
    public $socialInstagram = 'https://instagram.com/inmopro';
    public $socialTwitter   = 'https://twitter.com/inmopro';
    public $socialWhatsapp  = 'https://wa.me/541112345678';

    // =========================================================================
    // ABOUT & FOOTER
    // =========================================================================
    public $aboutText       = 'Somos una empresa líder en el mercado inmobiliario con más de 10 años de experiencia ayudando a miles de familias a encontrar su hogar ideal.';
    public $footerText      = '© 2026 InmoPro. Todos los derechos reservados.';
    public $footerAbout     = 'Somos una empresa líder en el mercado inmobiliario con más de 10 años de experiencia.';
}
