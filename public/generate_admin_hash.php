<?php
// Genera un hash para la contraseña 'admin' y muestra un SQL UPDATE
// Úsalo para pegar el UPDATE en tu cliente MySQL y forzar la contraseña del admin.

$password = 'admin';
$hash = password_hash($password, PASSWORD_DEFAULT);
$email = 'admin@deptos.com';

echo "Hash generado para la contraseña 'admin':\n" . $hash . "\n\n";
echo "SQL para ejecutar (cambia el email si hace falta):\n";
echo "UPDATE usuarios SET `contraseña` = '" . $hash . "' WHERE `email` = '" . $email . "';\n";

echo "\nInstrucciones:\n";
echo "1) Conecta a tu base de datos y ejecuta el UPDATE anterior.\n";
echo "2) Luego probá iniciar sesión con: email = $email, contraseña = $password\n";

?>
