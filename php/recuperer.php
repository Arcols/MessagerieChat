<?php
session_start();

$host = "localhost";
$dbname = "messagerier4a10";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$salleId = isset($_GET['salle']) ? intval($_GET['salle']) : 0;

try {
    // Récupérer les messages de la salle sélectionnée
    $query = "SELECT id, horaire, auteur, contenu FROM messages WHERE salle = :salle ORDER BY horaire DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':salle', $salleId, PDO::PARAM_INT);
    $stmt->execute();

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les messages en JSON
    header("Content-Type: application/json");
    echo json_encode($messages, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>