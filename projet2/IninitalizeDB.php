<?php
require 'ServerScripts.php';

$connection = mysqli_connect('localhost', 'root', '');
if ($connection) {
    consolelog("Connected To DataBase Server!");
}


$createDB = "CREATE DATABASE IF NOT EXISTS `$dataBaseName`";
if(!mysqli_query($connection, $createDB)){
    consolelog("Failed To Create DB!");
}

$connection = mysqli_connect('localhost', 'root', '',$dataBaseName);
if ($connection) {
    consolelog("DB Connected!");
}


// إغلاق الاتصال بعد تنفيذ الاستعلامات
mysqli_close($connection);
?>

