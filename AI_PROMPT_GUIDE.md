# GUÍA PARA AGENTES IA (AI PROMPT GUIDE)

**Propósito:** Este documento contiene las instrucciones exactas que debes copiar y pegar junto a los datos de tu cliente para que una Inteligencia Artificial genere el código de personalización de la plantilla sin romper la estructura.

---

## 🤖 Prompt Maestro para tu IA

**Copia el siguiente texto y pégalo en tu IA (ChatGPT, Claude, etc.) junto a las respuestas del formulario de tu cliente:**

```text
Eres un experto desarrollador trabajando sobre un sistema de CodeIgniter 4. Tu tarea es tomar la siguiente información de un cliente y generar ÚNICAMENTE la clase PHP `TemplateSettings.php` reemplazando los valores por defecto con la información proporcionada.

REGLAS ESTRICTAS:
1. No modifiques la estructura de la clase ni sus propiedades, SOLO los valores de las cadenas de texto (strings).
2. Debes devolver SOLO código PHP válido envuelto en bloques `php`. Sin explicaciones adicionales.
3. Si el cliente no proporciona un dato (ej: Twitter), deja el valor por defecto o un string vacío.

Plantilla base a modificar:
<?php

namespace Config;
use CodeIgniter\Config\BaseConfig;

class TemplateSettings extends BaseConfig
{
    public $siteName        = 'InmoPro';
    public $companyName     = 'InmoPro Bienes Raíces';
    public $contactEmail    = 'contacto@inmopro.com';
    public $contactPhone    = '+54 11 1234-5678';
    public $whatsapp        = '+54 11 1234-5678';
    public $contactAddress  = 'Av. Principal 123, Ciudad, País';

    public $heroTitle       = 'Encontrá tu lugar ideal con InmoPro';
    public $heroSubtitle    = 'Las mejores propiedades, la atención más exclusiva.';
    public $heroButtonText  = 'Ver Propiedades';

    public $aboutTitle      = 'Sobre Nosotros';
    public $aboutText       = 'Somos una empresa líder en el mercado inmobiliario...';

    public $socialFacebook  = 'https://facebook.com/inmopro';
    public $socialInstagram = 'https://instagram.com/inmopro';
    public $socialTwitter   = 'https://twitter.com/inmopro';

    public $footerText      = '© {YEAR} InmoPro. Todos los derechos reservados.';
}

A continuación se encuentran los datos del cliente:
[INSERTA-AQUÍ-LOS-DATOS-DEL-CLIENTE]
```

## 📂 ¿Qué hacer con el código generado?
Simplemente copia el código PHP que te devuelva la IA y pégalo reemplazando el archivo en la ruta:
`app/Config/TemplateSettings.php`

El sistema automáticamente actualizará el nombre, teléfonos, títulos y todos los textos en toda la vista de la página sin necesidad de tocar HTML.
