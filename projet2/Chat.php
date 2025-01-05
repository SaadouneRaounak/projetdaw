<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Assurez-vous que la session contient userID
if (!isset($_SESSION['userID'])) {
    echo "Vous devez vous connecter d'abord.";
    exit; // Arrête l'exécution du code s'il n'y a pas de userID dans la session
}

$dataBaseName = 'finaldatabase';

// Établir la connexion à la base de données
$connection = mysqli_connect('localhost', 'root', '', $dataBaseName);
if (!$connection) {
    die("Failed to connect to the database.");
}

$usersIdentification = $_SESSION['userID'];

// Vérifier si les champs requis existent dans POST
$userID = isset($_POST['userID']) ? intval($_POST['userID']) : null;
$recipient_id = isset($_POST['recipient_id']) ? intval($_POST['recipient_id']) : null;
$message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : null;

// Si les champs requis sont manquants ou vides
if (empty($userID) || empty($recipient_id) || empty($message)) {
    echo "Tous les champs sont requis !";
    exit; // Arrête l'exécution du code si les données sont incomplètes
}

// Insérer le message dans la base de données
$stmt = $connection->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userID, $recipient_id, $message);

if ($stmt->execute()) {
    echo "Le message a été envoyé.";
} else {
    echo "Erreur : " . $stmt->error;
}

// Enregistrer la notification dans la table notifications
$notification = "Vous avez un nouveau message";
$stmt = $connection->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $recipient_id, $notification);
if ($stmt->execute()) {
    echo "Notification enregistrée avec succès.";
} else {
    echo "Erreur lors de l'enregistrement de la notification : " . $stmt->error;
}

$stmt->close();
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title> Chat</title>
</head>

<body>
    <div class="too-small2">
        <header class="header" id="header">
            <nav class="nav container">
                <?php importNavName(); ?>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list grid">
                        <li class="nav__item">
                            <a href="حطي باج لوقين تاعك" class="nav__link">
                                <i class="uil uil-message nav__icon"></i>Log Out
                            </a>
                        </li>
                        <li class="notifications-container">
                            <!-- سيتم عرض الإشعارات هنا -->
                        </li>
                    </ul>
                    <i class="uil uil-times nav__close nav__icon" id="nav-close"></i>
                </div>

            </nav>
        </header>

        <main class="main">
            <section class="section">
                <h2 class="section__title">Welcome to ConnectEtud <i class="uil uil-comment-lines"></i></h2>
                <div id="result" class="services__container container">
                    <?php
                    printOutMessages($result, $usersIdentification);
                    ?>

                    <script>
                        RefreshChat();
                    </script>

                </div>
            </section>

            <section class="move-down">
                <div class="contact__container container grid">
                    <form id="form" action="Chat.php#ChatBox" method="POST" class="contact__form grid">

                        <div class="contact__content">
                            <label for="" class="contact__label">Email</label>
                            <input type="email" name="email" minlength="8" class="contact__input" required>
                        </div>
                        <div class="contact__content">
                            <label for="" class="contact__label">Message</label>
                            <input type="text" name="message" minlength="1" class="contact__input" required>
                        </div>
                        <input type="text" name="userID" value="<?php echo $usersIdentification; ?>" hidden />
                        <input type="text" name="recipient_id" value="2" hidden />
                        <button type="submit" id="ChatBox" name="submit" class="button button--flex">
                            Send Message
                            <i class="uil uil-message button__icon"></i>
                        </button>
                    </form>
                </div>
            </section>
        </main>
    </div>


    <script src="scripts.js"> </script>
      
   

</body>

</html>

