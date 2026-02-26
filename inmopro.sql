CREATE DATABASE IF NOT EXISTS inmopro CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE inmopro;

CREATE USER IF NOT EXISTS 'inmopro_user'@'localhost' IDENTIFIED BY 'inmopro123';
GRANT ALL PRIVILEGES ON inmopro.* TO 'inmopro_user'@'localhost';
FLUSH PRIVILEGES;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. Tablas Independientes (No tienen llaves foráneas)
-- --------------------------------------------------------

CREATE TABLE `usuarios` (
  `idUsuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `contraseña` VARCHAR(255) NOT NULL,
  `rol` ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `habitaciones` (
  `idHabitacion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(50) NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `estado` ENUM('disponible','ocupada','mantenimiento') NOT NULL DEFAULT 'disponible',
  `imagen` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`idHabitacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` VARCHAR(255) NOT NULL,
  `class` VARCHAR(255) NOT NULL,
  `group` VARCHAR(255) NOT NULL,
  `namespace` VARCHAR(255) NOT NULL,
  `time` INT NOT NULL,
  `batch` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- 2. Tablas Dependientes (Contienen llaves foráneas)
-- --------------------------------------------------------

CREATE TABLE `habitacion_tarifas` (
  `idTarifa` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idHabitacion` INT UNSIGNED NOT NULL, 
  `nombre` VARCHAR(100) NOT NULL,
  `capacidad` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `precio` DECIMAL(10,2) NOT NULL,
  `moneda` VARCHAR(10) NOT NULL DEFAULT 'ARS',
  `descripcion` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `nino` DECIMAL(10,2) DEFAULT 0.00,
  PRIMARY KEY (`idTarifa`),
  CONSTRAINT `habitacion_tarifas_idHabitacion_foreign` 
    FOREIGN KEY (`idHabitacion`) REFERENCES `habitaciones` (`idHabitacion`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reservas` (
  `idReserva` INT NOT NULL AUTO_INCREMENT,
  `idUsuario` INT UNSIGNED NOT NULL, 
  `idHabitacion` INT UNSIGNED NOT NULL, 
  `fechaInicio` DATE NOT NULL,
  `fechaFin` DATE NOT NULL,
  `cantidadHuespedes` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `precio_por_noche` DECIMAL(10,2) DEFAULT NULL,
  `total` DECIMAL(10,2) DEFAULT NULL,
  `estado` ENUM('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
  `pago_estado` ENUM('pendiente','pagado','fallido') NOT NULL DEFAULT 'pendiente',
  `comentarios` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`idReserva`),
  CONSTRAINT `reservas_idUsuario_foreign` 
    FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reservas_idHabitacion_foreign` 
    FOREIGN KEY (`idHabitacion`) REFERENCES `habitaciones` (`idHabitacion`) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
