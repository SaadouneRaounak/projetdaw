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

$getFileCreationTime = "SELECT MIN(created_at) FROM $dataBaseName.files";
$getMessageTime = "SELECT MIN(created_at) FROM $dataBaseName.messages";
$fileDateTimeResult = mysqli_query($connection, $getFileCreationTime);
$messageDateTimeResult = mysqli_query($connection, $getMessageTime);
$fileDateTime = strtotime(mysqli_fetch_array($fileDateTimeResult)[0]);
$messageDateTime = strtotime(mysqli_fetch_array($messageDateTimeResult)[0]);
$dataBaseTime = false;

if ($fileDateTime != false) {
    if ($messageDateTime != false) {
        if ($messageDateTime < $fileDateTime) {
            $dataBaseTime = $messageDateTime;
        } else {
            $dataBaseTime = $fileDateTime;
        }
    } else {
        $dataBaseTime = $fileDateTime;
    }
} else {
    $dataBaseTime = $messageDateTime;
}

$timeChecker = time();
$timeDiffirence = $timeChecker - $dataBaseTime;

consolelog($timeDiffirence);

mysqli_close($connection); // Fermer la connexion à la base de données
?>






 