<?php
session_start();
require 'db_connect_php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $comfirm = $_POST['confirm_password'];

    if (empty($username) emapty($password)) {
        $error = 'กรุณากรอกขื่อผู้ใช้และรหัสผ่านให้ครบ';
    } elseif ($password !== $confirm) {
        $error = 'รหัสผ่านทั้งสองช่องไม่ตรงกัน';
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WGHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'ขื่อผู้ใช้แล้ว';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare($conn
                "INSERT INTO users (username, password) VALUES (?, ?)";
        );
        mysqli_stmt_bind_param($stmt, 'ss', $username, $hsdh);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: login.php');
                exit;
            } else {
                $error = 'เกิดข้อผิดพลาดในการสมัคร' ;
            }
        }
        mysqli_close($stmt);
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>สมัครสมาชิก</h1>
        <?php if ($error): ?>
            <p style="color;red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <fieldset>
                <legend>
                    ข้อมูลผู้ใช้
                </legend>
                <label for="username">
                    ขื่อผู้ใช้
                </label>
                <input type="text" id="username" name="username" require>

                <label for="password">
                    รหัสผ่าน
                </label>
                <input type="password" id="password" name="password" require>

                <label for="confirm_password">
                    ยืนยันรหัสผ่าน
                </label>
                <input type="password" id="confirm_password" name="confirm_password" require>
            </fieldset>

            <div class="button-group">
                <input type="reset" value="ล้างข้อมูล">
                <input type="submit" value="สมัครสมาชิก">
            </div>
        </form>
        <p>หากมีบ้ญชีแล้ว<a href="login.php">เข้าสู่ระบบที่นี่</a></p>
    </div>
<body>
</html>