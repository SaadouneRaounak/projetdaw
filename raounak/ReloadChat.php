<?php
$dataBaseName = 'finaldatabase';

// Établir la connexion à la base de données
$connection = mysqli_connect('localhost', 'root', '', $dataBaseName);
if (!$connection) {
    die("Failed to connect to the database.");
}

$usersIdentification = $_SESSION['userID'];

$getMessages = "SELECT `M`.`content`, `U`.`name`, `M`.`created_at`,`U`.`id` FROM `messages` AS M
    INNER JOIN `users` AS U 
    ON `M`.`sender_id` = `U`.`id`
    ORDER BY `M`.`created_at`";

$result = mysqli_query($connection, $getMessages);
if (!$result) {
    error_log("Failed To Get Data From Table Containing Messages!");
}

while ($row = mysqli_fetch_row($result)) {
    $messageFromSender =  $row[0];
    $sendersName =  $row[1];
    $sendersId = $row[3];

    if ($usersIdentification == $sendersId) {
        $messageType = "Messages__self";
    } else {
        $messageType = "Messages__other";
    }

    echo "
        <div class='$messageType'>
            <a class='button__special button--flex'>
                " . ucwords($sendersName) . ":  " . htmlspecialchars($messageFromSender) . "
            </a>
        </div>
    ";
}

mysqli_close($connection); // Fermer la connexion à la base de données
?>

