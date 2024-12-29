<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// التأكد من أن الجلسة تحتوي على userID
if (!isset($_SESSION['userID'])) {
    echo "تحتاج إلى تسجيل الدخول أولاً.";
    exit; // التوقف عن تنفيذ الكود إذا لم يكن هناك userID في الجلسة
}

require 'IninitalizeDB.php';
include 'ServerScripts.php';

// الحصول على userID من الجلسة
$usersIdentification = $_SESSION['userID'];

// التحقق من وجود الحقول المطلوبة في POST
$userID = isset($_POST['userID']) ? $_POST['userID'] : null;
$recipient_id = isset($_POST['recipient_id']) ? $_POST['recipient_id'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : null;

// إذا كانت الحقول المطلوبة غير موجودة أو فارغة
if (empty($userID) || empty($recipient_id) || empty($message)) {
    echo "جميع الحقول مطلوبة!";
    exit; // التوقف عن تنفيذ الكود في حال كانت البيانات غير كاملة
}

// إدخال الرسالة في قاعدة البيانات
$stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $userID, $recipient_id, $message);

if ($stmt->execute()) {
    echo "Message has been sent.";
} else {
    echo "error: " . $stmt->error;
}

// تسجيل الإشعار في جدول الإشعارات
$notification = "you have a new message";
$stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $recipient_id, $notification);
if ($stmt->execute()) {
    echo "تم تسجيل الإشعار بنجاح.";
} else {
    echo "خطأ في تسجيل الإشعار: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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

    <div class="main resolution__text">
        <section class="section">
            <h2 class="section__title">الشاشة صغيرة جدًا</h2>
            <span class="span section__subtitle">يرجى التبديل إلى جهاز بشاشة أكبر</span>
            <span class="span section__subtitle">نعتذر عن الإزعاج، لكنني لا أتقاضى أجرًا كافيًا لذلك<br> (في الواقع، لا أتقاضى أجرًا على الإطلاق)</span>
        </section>
    </div>

    <script>
        function RefreshChat() {
            setInterval(function () {
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "ReloadChat.php", true);
                xhr.onload = function () {
                    if (this.status == 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                };
                xhr.send();
            }, 2000);
        }

        function fetchNotifications() {
            const userId = <?php echo $usersIdentification; ?>;
            fetch(`FetchNotifications.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('notifications-container');
                    container.innerHTML = ''; // تنظيف الإشعارات السابقة
                    data.forEach(notification => {
                        const div = document.createElement('div');
                        div.classList.add('notification');
                        div.innerHTML = `
                            <p>${notification.message}</p>
                            <small>${new Date(notification.created_at).toLocaleString()}</small>
                        `;
                        container.appendChild(div);
                    });
                })
                .catch(err => console.error('Error fetching notifications:', err));
        }

        // تحديث الإشعارات كل 5 ثوانٍ
        setInterval(fetchNotifications, 5000);
        fetchNotifications(); // استدعاء أولي عند تحميل الصفحة
    </script>

</body>

</html>
