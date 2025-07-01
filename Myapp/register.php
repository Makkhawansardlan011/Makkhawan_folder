<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'connect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (empty($username) || empty($password)) {
        $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่านให้ครบ';
    } elseif ($password !== $confirm) {
        $error = 'รหัสผ่านทั้งสองช่องไม่ตรงกัน';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT ID FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'ชื่อผู้ใช้นี้มีคนใช้แล้ว';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, 'ss', $username, $hash);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: login.php');
                exit;
            } else {
                $error = 'เกิดข้อผิดพลาดในการสมัคร';
            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="container">
    <h1>สมัครสมาชิก</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <form method="post">
      <fieldset>
        <legend>ข้อมูลผู้ใช้</legend>

        <label for="username">ชื่อผู้ใช้</label>
        <input type="text" id="username" name="username" required>

        <label for="password">รหัสผ่าน</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">ยืนยันรหัสผ่าน</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </fieldset>

      <div class="button-group">
        <input type="reset" value="ล้างข้อมูล">
        <input type="submit" value="สมัครสมาชิก">
      </div>
    </form>
    <p>หากมีบัญชีแล้ว <a href="login.php">เข้าสู่ระบบที่นี่</a></p> 
   </div> 
</body>
</html>