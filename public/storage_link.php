<?php
/**
 * Script auxiliar para cPanel: Crear symlink de storage sin terminal.
 * Ejecutar una sola vez visitando: https://tudominio.com/storage_link.php
 * Luego de ejecutarlo, ELIMINA este archivo por seguridad.
 */

$target = realpath(__DIR__ . '/../storage/app/public');
$shortcut = __DIR__ . '/storage';

if (!file_exists($target)) {
    @mkdir($target, 0775, true);
}

if (file_exists($shortcut) || is_link($shortcut)) {
    echo "<h1>✓ El enlace simbólico 'storage' ya existe y está activo.</h1>";
    echo "<p>Por seguridad, ya puedes eliminar el archivo <code>public/storage_link.php</code>.</p>";
} else {
    if (@symlink($target, $shortcut)) {
        echo "<h1>✓ ¡Enlace simbólico creado exitosamente!</h1>";
        echo "<p>La carpeta pública ahora está enlazada con <code>storage/app/public</code>.</p>";
        echo "<p><strong>IMPORTANTE:</strong> Por seguridad, elimina ahora mismo el archivo <code>public/storage_link.php</code> de tu cPanel.</p>";
    } else {
        echo "<h1>⚠ No se pudo crear el enlace simbólico automáticamente.</h1>";
        echo "<p>Verifica si tu cuenta de cPanel permite la función <code>symlink</code> o ejecuta <code>php artisan storage:link</code> desde la Terminal de cPanel.</p>";
    }
}
