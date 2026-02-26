<?php

// Create propiedad_imagenes table
$host = 'localhost';
$db   = 'inmopro';
$user = 'inmopro_user';
$pass = 'inmopro123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `propiedad_imagenes` (
            `idImagen` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `idPropiedad` INT UNSIGNED NOT NULL,
            `ruta` VARCHAR(500) NOT NULL,
            `orden` TINYINT UNSIGNED DEFAULT 0,
            `created_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`idImagen`),
            CONSTRAINT `imagenes_idPropiedad_foreign`
                FOREIGN KEY (`idPropiedad`) REFERENCES `propiedades`(`idPropiedad`)
                ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    echo "Table propiedad_imagenes created successfully.\n";
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
