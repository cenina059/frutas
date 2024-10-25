<?php
require_once __DIR__ . '/../config/database.php';

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function crearFruta($nombre, $precio, $stock, $categoria) {
    global $fruitsCollection; // Asegúrate de cambiar la colección en database.php
    $resultado = $fruitsCollection->insertOne([
        'nombre' => sanitizeInput($nombre),
        'precio' => floatval($precio),
        'stock' => floatval($stock),
        'categoria' => sanitizeInput($categoria),
        'disponible' => true,
        'fecha_registro' => new MongoDB\BSON\UTCDateTime()
    ]);
    return $resultado->getInsertedId();
}

function obtenerFrutas() {
    global $fruitsCollection;
    return $fruitsCollection->find();
}

function obtenerFrutaPorId($id) {
    global $fruitsCollection;
    return $fruitsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarFruta($id, $nombre, $precio, $stock, $categoria, $disponible) {
    global $fruitsCollection;
    $resultado = $fruitsCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'nombre' => sanitizeInput($nombre),
            'precio' => floatval($precio),
            'stock' => floatval($stock),
            'categoria' => sanitizeInput($categoria),
            'disponible' => $disponible
        ]]
    );
    return $resultado->getModifiedCount();
}

function eliminarFruta($id) {
    global $fruitsCollection;
    $resultado = $fruitsCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $resultado->getDeletedCount();
}