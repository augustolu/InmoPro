<?php
$conn = new mysqli('localhost', 'inmopro_user', 'inmopro123', 'inmopro');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS propiedades (
  idPropiedad INT UNSIGNED NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  tipo ENUM('venta', 'alquiler') NOT NULL DEFAULT 'venta',
  ubicacion VARCHAR(255) NOT NULL,
  habitaciones TINYINT UNSIGNED NOT NULL DEFAULT 1,
  banos TINYINT UNSIGNED NOT NULL DEFAULT 1,
  metros_cuadrados INT UNSIGNED,
  imagen_principal VARCHAR(255),
  estado ENUM('disponible', 'reservado', 'vendido', 'alquilado') NOT NULL DEFAULT 'disponible',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (idPropiedad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if ($conn->query($sql) === TRUE) {
    echo "Table propiedades created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
