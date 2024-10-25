<?php
require_once __DIR__.'/includes/functions.php';

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    
    if ($nombre && $precio && $stock && $categoria) {
        $id = crearFruta($nombre, $precio, $stock, $categoria);
        if ($id) {
            header('Location: index.php');
            exit;
        } else {
            $mensaje = "Error al agregar la fruta.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Fruta</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Agregar Nueva Fruta</h1>
    
    <?php if ($mensaje): ?>
        <div class="error"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST" action="agregar_fruta.php">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="precio">Precio por Kg:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock (Kg):</label>
            <input type="number" id="stock" name="stock" step="0.1" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <option value="Cítricos">Cítricos</option>
                <option value="Tropicales">Tropicales</option>
                <option value="Berries">Berries</option>
                <option value="Otras">Otras</option>
            </select>
        </div>

        <button type="submit" class="button">Guardar Fruta</button>
        <a href="index.php" class="button">Cancelar</a>
    </form>
</div>
</body>
</html>