<?php
$dataBaseName = 'finaldatabase';

// Établir la connexion à la base de données
$connection = mysqli_connect('localhost', 'root', '', $dataBaseName);
if (!$connection) {
    die("Failed to connect to the database.");
}

// Délégation de fonctions
function println(string $string = '')
{
    print($string . PHP_EOL);
}

function consolelog($data)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('$output');</script>";
}


$getMessageTime = "SELECT MIN(created_at) FROM $dataBaseName.messages";
$messageDateTimeResult = mysqli_query($connection, $getMessageTime);
$row = mysqli_fetch_array($messageDateTimeResult);
$messageDateTime = null;

if ($row && !is_null($row[0])) {
    $messageDateTime = strtotime($row[0]);
} else {
    // Handle the case where there is no minimum created_at value found
    echo "No messages found in the database.";
}

$dataBaseTime = false;

$timeChecker = time();
$timeDifference = $timeChecker - $dataBaseTime;

consolelog($timeDifference);

mysqli_close($connection); // Fermer la connexion à la base de données
?>