<?php

// Create propiedad_reservas table
$host = 'localhost';
$db   = 'inmopro';
$user = 'inmopro_user';
$pass = 'inmopro123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `propiedad_reservas` (
            `idReserva` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `idPropiedad` INT UNSIGNED NOT NULL,
            `idUsuario` INT UNSIGNED NOT NULL,
            `fechaInicio` DATE NOT NULL,
            `fechaFin` DATE NOT NULL,
            `cantidadHuespedes` TINYINT UNSIGNED NOT NULL DEFAULT 1,
            `precio_por_noche` DECIMAL(10,2) NOT NULL,
            `total` DECIMAL(10,2) NOT NULL,
            `estado` ENUM('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
            `pago_estado` ENUM('pendiente','pagado','fallido') NOT NULL DEFAULT 'pendiente',
            `comentarios` TEXT DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`idReserva`),
            KEY `idx_propiedad` (`idPropiedad`),
            KEY `idx_usuario` (`idUsuario`),
            KEY `idx_fechas` (`fechaInicio`, `fechaFin`),
            CONSTRAINT `propiedad_reservas_idPropiedad_foreign`
                FOREIGN KEY (`idPropiedad`) REFERENCES `propiedades`(`idPropiedad`)
                ON DELETE CASCADE ON UPDATE CASCADE,
            CONSTRAINT `propiedad_reservas_idUsuario_foreign`
                FOREIGN KEY (`idUsuario`) REFERENCES `usuarios`(`idUsuario`)
                ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ");
    
    echo "Table propiedad_reservas created successfully.\n";
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
