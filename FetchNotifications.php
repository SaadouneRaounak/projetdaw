<?php
include 'ServerScripts.php'; // ملف الاتصال بقاعدة البيانات

header('Content-Type: application/json');

$userID = isset($_POST['userID']) ? $_POST['userID'] : null;
if (!$userID) {
    die("Error: userID is required.");
}

$stmt = $conn->prepare("SELECT id, message, created_at FROM notifications WHERE user_id = ? AND is_read = FALSE ORDER BY created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($notifications);

// تحديث الإشعارات كـ "تم قراءتها"
$stmt = $conn->prepare("UPDATE notifications SET is_read = TRUE WHERE user_id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();
$conn->close();
?>
