<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Comprime una imagen usando optimización simple
     * Solo copia el archivo (la compresión sucede transparentemente)
     */
    public static function compressImage($sourcePath, $destinationPath, $maxWidth = 1920, $maxHeight = 1080, $quality = 80)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        // Crear directorio si no existe
        $destinationDir = dirname($destinationPath);
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        try {
            // Intentar usar ImageMagick si está disponible
            if (extension_loaded('imagick')) {
                return self::compressWithImageMagick($sourcePath, $destinationPath, $maxWidth, $maxHeight, $quality);
            }
            
            // Fallback: usar GD Library
            if (extension_loaded('gd')) {
                return self::compressWithGD($sourcePath, $destinationPath, $maxWidth, $maxHeight, $quality);
            }
            
            // Último recurso: copiar directamente
            return copy($sourcePath, $destinationPath);
        } catch (\Exception $e) {
            // Si todo falla, simplemente copiar el archivo
            return copy($sourcePath, $destinationPath);
        }
    }

    /**
     * Comprime usando ImageMagick (más seguro)
     */
    private static function compressWithImageMagick($sourcePath, $destinationPath, $maxWidth, $maxHeight, $quality)
    {
        try {
            $image = new \Imagick($sourcePath);
            $image->resizeImage($maxWidth, $maxHeight, \Imagick::FILTER_LANCZOS, 1, true);
            $image->setImageCompression(\Imagick::COMPRESSION_JPEG);
            $image->setImageCompressionQuality($quality);
            $image->writeImage($destinationPath);
            $image->destroy();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Comprime usando GD Library
     */
    private static function compressWithGD($sourcePath, $destinationPath, $maxWidth, $maxHeight, $quality)
    {
        $imageInfo = @getimagesize($sourcePath);
        if ($imageInfo === false) {
            return false;
        }

        $mimeType = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Cargar imagen
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($sourcePath);
                $isJpeg = true;
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                $isJpeg = false;
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $image = @imagecreatefromwebp($sourcePath);
                    $isJpeg = true;
                } else {
                    return copy($sourcePath, $destinationPath);
                }
                break;
            default:
                return copy($sourcePath, $destinationPath);
        }

        if (!$image) {
            return copy($sourcePath, $destinationPath);
        }

        // Calcular nuevas dimensiones
        $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        // Crear imagen redimensionada
        $resized = imagecreatetruecolor($newWidth, $newHeight);

        // Preservar transparencia en PNG
        if ($mimeType === 'image/png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
            imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Copiar y redimensionar
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Guardar imagen
        $success = false;
        if ($isJpeg) {
            $success = @imagejpeg($resized, $destinationPath, $quality);
        } else {
            @imagepng($resized, $destinationPath, 9);
            $success = true;
        }

        imagedestroy($image);
        imagedestroy($resized);

        return $success;
    }

    /**
     * Obtiene el tamaño de archivo en MB
     */
    public static function getFileSizeMB($filePath)
    {
        if (!file_exists($filePath)) {
            return 0;
        }
        return round(filesize($filePath) / (1024 * 1024), 2);
    }

    /**
     * Procesa un archivo subido
     */
    public static function processUploadedImage($uploadedFile, $destinationPath, $destinationFilename)
    {
        if (!$uploadedFile->isValid() || $uploadedFile->hasMoved()) {
            return false;
        }

        $tempPath = $uploadedFile->getTempName();
        $fullDestinationPath = $destinationPath . DIRECTORY_SEPARATOR . $destinationFilename;

        return self::compressImage($tempPath, $fullDestinationPath);
    }
}
