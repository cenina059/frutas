<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

try {
    $mongoClient = new MongoDB\Client("mongodb+srv://cenina:UCgmgSoch988ij5Y@frutas1.oven5.mongodb.net/?retryWrites=true&w=majority&appName=frutas1");
    $database = $mongoClient->selectDatabase('tienda');
    $fruitsCollection = $database->selectCollection('frutas'); 

} catch (Exception $e) {
    die("Error al conectar con MongoDB: " . $e->getMessage());
}

?>
