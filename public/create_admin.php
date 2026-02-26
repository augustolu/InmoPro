<?php
// Script temporal para insertar el admin
$db = new mysqli('localhost', 'inmopro_user', 'inmopro123', 'inmopro');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if admin exists
$result = $db->query("SELECT * FROM usuarios WHERE email = 'admin@deptos.com'");
if ($result->num_rows == 0) {
    // Hashear la contraseña 'admin'
    $hashed_password = password_hash('admin', PASSWORD_DEFAULT);
    
    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, contraseña, rol, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $nombre = 'Administrador General';
    $email = 'admin@deptos.com';
    $rol = 'admin';
    
    $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $rol);
    
    if ($stmt->execute()) {
        echo "Admin user created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Admin user already exists.";
}

$db->close();
?>
