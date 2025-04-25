<?php
header('Content-Type: application/json');
require_once __DIR__ . '/service/PositionService.php';
require_once __DIR__ . '/classe/Position.php';

try {
    // Vérification de la méthode HTTP
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new RuntimeException("Méthode non autorisée");
    }

    // Validation des données
    $latitude = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
    $longitude = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);
    $imei = $_POST['imei'] ?? '';

    if ($latitude === false || $longitude === false || empty($imei)) {
        throw new InvalidArgumentException("Données GPS ou IMEI invalides");
    }

    // Création de la date actuelle (côté serveur)
    $date = new DateTimeImmutable();
    
    // Création de l'objet Position
    $position = new Position(null, $latitude, $longitude, $date, $imei);
    
    // Insertion en base
    $service = new PositionService();
    if ($service->create($position)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Position enregistrée avec succès',
            'data' => $position->toArray()
        ]);
    } else {
        throw new RuntimeException("Erreur lors de l'enregistrement");
    }

} catch (InvalidArgumentException $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur serveur: ' . $e->getMessage()
    ]);
}