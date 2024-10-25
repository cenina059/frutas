<?php
require_once __DIR__.'/includes/functions.php';
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $count = eliminarFruta($_GET['id']);
    $mensaje = $count > 0 ? "Fruta eliminada con éxito." : "No se pudo eliminar la fruta.";
}

$frutas = obtenerFrutas();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Venta de Frutas</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Sistema de Venta de Frutas</h1>

    <?php if (isset($mensaje)): ?>
        <div class="<?php echo $count > 0 ? 'success' : 'error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <a href="agregar_fruta.php" class="button">Agregar Nueva Fruta</a>

    <h2>Inventario de Frutas</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Precio/Kg</th>
            <th>Stock (Kg)</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($frutas as $fruta): ?>
        <tr>
            <td><?php echo htmlspecialchars($fruta['nombre']); ?></td>
            <td>$<?php echo number_format($fruta['precio'], 2); ?></td>
            <td><?php echo htmlspecialchars($fruta['stock']); ?></td>
            <td><?php echo htmlspecialchars($fruta['categoria']); ?></td>
            <td><?php echo $fruta['disponible'] ? 'Disponible' : 'No disponible'; ?></td>
            <td class="actions">
                <a href="editar_fruta.php?id=<?php echo $fruta['_id']; ?>" class="button">Editar</a>
                <a href="index.php?accion=eliminar&id=<?php echo $fruta['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar esta fruta?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>