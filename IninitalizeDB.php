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

// إنشاء جدول المستخدمين
$createUsers = "CREATE TABLE IF NOT EXISTS `$dataBaseName`.`Users`(
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(191) NOT NULL UNIQUE,
  password VARCHAR(191) NOT NULL,
  role ENUM('student', 'teacher', 'admin') NOT NULL,
  name VARCHAR(191) NOT NULL,
  phone VARCHAR(20),
  specialization VARCHAR(191),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!mysqli_query($connection, $createUsers)) {
    consolelog("Failed To Create Users Table!");
} else {
    consolelog("Users Table Created Successfully!");
}

// إنشاء جدول الرسائل
$createMessagesTable = "CREATE TABLE IF NOT EXISTS `$dataBaseName`.`Messages`(
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  content TEXT NOT NULL,
  is_read BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (receiver_id) REFERENCES users(id)
)";
if (!mysqli_query($connection, $createMessagesTable)) {
    consolelog("Failed To Create Messages Table!");
} else {
    consolelog("Messages Table Created Successfully!");
}

// إنشاء جدول الإشعارات
$createNotificationsTable = "CREATE TABLE IF NOT EXISTS `$dataBaseName`.`notifications`(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message TEXT NOT NULL,
  is_read BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
)";
if (!mysqli_query($connection, $createNotificationsTable)) {
    consolelog("Failed To Create Notifications Table!");
} else {
    consolelog("Notifications Table Created Successfully!");
}

// إغلاق الاتصال بعد تنفيذ الاستعلامات
mysqli_close($connection);
?>

