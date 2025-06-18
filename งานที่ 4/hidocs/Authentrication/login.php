<?php
session_start();
require 'db_connect.php' ;

$error = ' ';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) empty($password)) {
        $error= 'กรุณากรอกขื่อผู้ใช้และ' ;
    } else {
        $stmt = mysqli_prepare($conn
        "SELECT if, password FROM users WHERE username = ?"
        );
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $hash);
        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hash)) {
                $SESSION['user_id'] = $id;
                $SESSION['username'] = $username;
                header('Location: dashboard.php')
                exit;
            } else {
                $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            }
        else{
            $error = "ไม่พบขื่อผู้ใช้นี้"
        }
            mysqli_stmt_close($stmt)
        }
        mysqli_stmt_close($stmt);
    }
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>
            เข้าสู่ระบบ
        </h1>
        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif ?>
        <form method="post">
            <fieldset>
                <legend>ข้อมูลเข้าสู่ระบบ</legend>
                <label for="usernane">ข้อมูลผู้ใช้</label>
                <input type="text" id="username" name="username" require>

                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" require>
            </fieldset>

            <div class="button-group">
                <input type="submit" balue="เข้าสู่ระบบ">
        <   /div>
        </form>
        <p>ยังไม่มีบัญชี <a href="regixter.php">สมัครสมาชิกที่นี่</a></p>
    </div>
</body>
</html>