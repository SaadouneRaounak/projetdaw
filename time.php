<?php
require 'IninitalizeDB.php';

$getFileCreationTime = "SELECT MIN(sended_at) FROM $dataBaseName.Files";
$getMessageTime = "SELECT MIN(sended_at) FROM $dataBaseName.Messages";
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




 