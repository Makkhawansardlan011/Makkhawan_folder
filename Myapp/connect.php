<?php
// 1) กำหนดตัวแปรการเชื่อมต่อ
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'myapp';

// 2) สร้างการเชื่อมต่อ
$conn = mysqli_connect($host, $user, $pass, $db);

// 3) ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . 
mysqli_connect_error());
// ถ้าเชื่อมต่อสำเร็จ จะไม่มีข้อความใดๆ แสดงออกมา