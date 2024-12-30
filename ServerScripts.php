<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dataBaseName = 'basedaw';

// تأكد من وجود الاتصال بقاعدة البيانات
$connection = mysqli_connect('localhost', 'root', '', $dataBaseName);
if (!$connection) {
    die("Failed to connect to the database.");
}

// دالة لطباعة النصوص
function println(string $string = '')
{
    print($string . PHP_EOL);
}

// دالة لعرض الرسائل في الكونسول
function consolelog($data)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('$output');</script>";
}

// دالة لعرض اسم المستخدم في شريط التنقل
function importNavName(){
    print("<a href='#' class='nav__logo'>" . ucwords($_SESSION['userName']) . "</a>");
}

// دالة لعرض الرسائل
function printOutMessages($result, $usersIdentification){
    while ($row = mysqli_fetch_row($result)) {
        $messageFromSender   =  $row[0];
        $sendersName =  $row[1];
        $sendersId = $row[3];

        if ($usersIdentification == $sendersId) {
            $messageType = "Messages__self";
        } else {
            $messageType = "Messages__other";
        }

        print("
        <div class='$messageType'>
            <a class='button__special button--flex'>
                " . ucwords($sendersName) . ":  " . $messageFromSender . "
            </a>
        </div>
        ");
    }
}

// تأكد من استلام البريد الإلكتروني مع الرسالة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['message'])) {
        $email = $_POST['email'];
        $message = $_POST['message'];
        $usersIdentification = 1; // افترض معرف المستخدم
        $currentDate = date('Y-m-d H:i:s');

        // التحقق من صحة البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format!");
        }

        // إدخال الرسالة في قاعدة البيانات
        $stmt = $connection->prepare("INSERT INTO messages (message, users_id, email, sended_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $message, $usersIdentification, $email, $currentDate);
        $stmt->execute();

        // إرسال البريد الإلكتروني
        $subject = "New Message Received";
        $headers = "From: yourapp@example.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Message sent and email notification dispatched.";
        } else {
            echo "Failed to send email.";
        }

        // وضع علامة على الرسالة كتم إرسالها
        $_SESSION['submitted'] = true;

        // إعادة التوجيه لتجنب الإرسال المزدوج عند تحديث الصفحة
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// إذا تم الإرسال من قبل، لا تقم بإدخال الرسالة مرة أخرى
if (isset($_SESSION['submitted']) && $_SESSION['submitted'] === true) {
    echo "الرسالة تم إرسالها بالفعل.";
    // إزالة الجلسة بعد العرض
    unset($_SESSION['submitted']);
}

// إغلاق الاتصال بعد الانتهاء من العمليات
mysqli_close($connection);
?>
