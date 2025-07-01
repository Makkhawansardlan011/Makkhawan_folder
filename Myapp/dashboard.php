<?php
session_start();
// ตรวจสอบการเข้าสู่ระบบ
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>คุณเข้าสู่ระบบ สำเร็จแล้ว</p>
        <div class="button-group">
            <a href="logout.php"><button>ออกจากระบบ</button></a>
        </div>
    </div>
</body>
</html>