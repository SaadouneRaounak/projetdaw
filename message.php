<?php

header("Content-Type: application/json");

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Connexion à la base de données
$host = 'localhost';
$dbname = 'your_database_name';
$user = 'root'; // Modifiez en fonction de votre configuration
$password = ''; // Modifiez en fonction de votre configuration

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]));
}

// Récupération des informations de la requête
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$input = json_decode(file_get_contents('php://input'), true);

// Fonction pour envoyer une réponse JSON
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// Routes pour gérer les tables

// Table `users`
if (strpos($uri, '/users') !== false) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM users");
        sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO users (email, password, role, name, phone, specialization) VALUES (:email, :password, :role, :name, :phone, :specialization)");
        $stmt->execute([
            ':email' => $input['email'],
            ':password' => $input['password'],
            ':role' => $input['role'],
            ':name' => $input['name'],
            ':phone' => $input['phone'],
            ':specialization' => $input['specialization'] ?? null,
        ]);
        sendResponse(["message" => "Utilisateur créé avec succès"], 201);
    }
}

// Table `projects`
if (strpos($uri, '/projects') !== false) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM projects");
        sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO projects (teacher_id, title, description, keywords, technologies, status) VALUES (:teacher_id, :title, :description, :keywords, :technologies, :status)");
        $stmt->execute([
            ':teacher_id' => $input['teacher_id'],
            ':title' => $input['title'],
            ':description' => $input['description'],
            ':keywords' => $input['keywords'],
            ':technologies' => $input['technologies'],
            ':status' => $input['status'] ?? 'open',
        ]);
        sendResponse(["message" => "Projet créé avec succès"], 201);
    }
}

// Table `applications`
if (strpos($uri, '/applications') !== false) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM applications");
        sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO applications (student_id, project_id, status) VALUES (:student_id, :project_id, :status)");
        $stmt->execute([
            ':student_id' => $input['student_id'],
            ':project_id' => $input['project_id'],
            ':status' => $input['status'] ?? 'pending',
        ]);
        sendResponse(["message" => "Candidature enregistrée avec succès"], 201);
    }
}

// Table `messages`
if (strpos($uri, '/messages') !== false) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM messages");
        sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content, is_read) VALUES (:sender_id, :receiver_id, :content, :is_read)");
        $stmt->execute([
            ':sender_id' => $input['sender_id'],
            ':receiver_id' => $input['receiver_id'],
            ':content' => $input['content'],
            ':is_read' => $input['is_read'] ?? false,
        ]);
        sendResponse(["message" => "Message envoyé avec succès"], 201);
    }
}

// Table `groups` et `group_members`
if (strpos($uri, '/groups') !== false) {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM groups");
        sendResponse($stmt->fetchAll(PDO::FETCH_ASSOC));
    } elseif ($method === 'POST') {
        $stmt = $pdo->prepare("INSERT INTO groups (name) VALUES (:name)");
        $stmt->execute([
            ':name' => $input['name'],
        ]);
        sendResponse(["message" => "Groupe créé avec succès"], 201);
    }
}

// Route par défaut
sendResponse(["error" => "Invalid endpoint"], 404);

?>


