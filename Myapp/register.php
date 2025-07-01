<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // ตรวจสอบข้อมูลซ้ำ
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $error = "ชื่อผู้ใช้นี้ถูกใช้แล้ว";
    } else {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // บันทึกข้อมูล
        $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ss", $username, $hashed_password);
        
        if (mysqli_stmt_execute($insert_stmt)) {
            $_SESSION['success'] = "ลงทะเบียนสำเร็จ";
            header("Location: login.php");
            exit();
        } else {
            $error = "เกิดข้อผิดพลาดในการลงทะเบียน";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ลงทะเบียน</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>ลงทะเบียน</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" name="password" required>
            </div>
            
            <input type="submit" value="ลงทะเบียน">
        </form>
        
        <div class="login-link">
            <a href="login.php">มีบัญชีแล้ว? เข้าสู่ระบบ</a>
        </div>
    </div>
</body>
</html> 