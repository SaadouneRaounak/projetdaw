<?php
$dataBaseName = 'finaldatabase';

// Établir la connexion à la base de données
$connection = mysqli_connect('localhost', 'root', '', $dataBaseName);
if (!$connection) {
    die("Failed to connect to the database.");
}

header('Content-Type: application/json');

$userID = isset($_POST['userID']) ? intval($_POST['userID']) : null;
if (!$userID) {
    die(json_encode(["error" => "userID is required."]));
}

// Requête pour obtenir les notifications non lues
$stmt = $connection->prepare("SELECT id, message, created_at FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$notifications = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($notifications);

// Mettre à jour les notifications comme "lues"
$stmt = $connection->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();
$connection->close();
?>


