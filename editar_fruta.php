<?php
require_once __DIR__.'/includes/functions.php';

$mensaje = '';
$fruta = null;

// Verificar si se proporcionó un ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

// Obtener la fruta existente
$fruta = obtenerFrutaPorId($_GET['id']);
if (!$fruta) {
    header('Location: index.php');
    exit;
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $disponible = isset($_POST['disponible']) ? true : false;
    
    if ($nombre && $precio && $stock && $categoria) {
        $count = actualizarFruta(
            $_GET['id'], 
            $nombre, 
            $precio, 
            $stock, 
            $categoria, 
            $disponible
        );
        
        if ($count > 0) {
            header('Location: index.php');
            exit;
        } else {
            $mensaje = "No se realizaron cambios o hubo un error al actualizar.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos requeridos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fruta</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Editar Fruta</h1>
    
    <?php if ($mensaje): ?>
        <div class="error"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" 
                   id="nombre" 
                   name="nombre" 
                   value="<?php echo htmlspecialchars($fruta['nombre']); ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="precio">Precio por Kg:</label>
            <input type="number" 
                   id="precio" 
                   name="precio" 
                   step="0.01" 
                   value="<?php echo number_format($fruta['precio'], 2, '.', ''); ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="stock">Stock (Kg):</label>
            <input type="number" 
                   id="stock" 
                   name="stock" 
                   step="0.1" 
                   value="<?php echo number_format($fruta['stock'], 1, '.', ''); ?>" 
                   required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php
                $categorias = ['Cítricos', 'Tropicales', 'Berries', 'Otras'];
                foreach ($categorias as $cat) {
                    $selected = ($cat === $fruta['categoria']) ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="disponible">
                <input type="checkbox" 
                       id="disponible" 
                       name="disponible" 
                       <?php echo $fruta['disponible'] ? 'checked' : ''; ?>>
                Disponible para venta
            </label>
        </div>

        <button type="submit" class="button">Guardar Cambios</button>
        <a href="index.php" class="button">Cancelar</a>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const precio = parseFloat(document.getElementById('precio').value);
        const stock = parseFloat(document.getElementById('stock').value);
        
        if (precio <= 0) {
            e.preventDefault();
            alert('El precio debe ser mayor que 0');
            return;
        }
        
        if (stock < 0) {
            e.preventDefault();
            alert('El stock no puede ser negativo');
            return;
        }
    });
});
</script>
</body>
</html>