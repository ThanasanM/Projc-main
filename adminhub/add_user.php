<?php
session_start();
require_once '../config/db.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // รับค่าจากฟอร์ม
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : null; // แก้ไขจาก first_name เป็น firstname
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : null; // แก้ไขจาก last_name เป็น lastname
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
        $urole = isset($_POST['urole']) ? trim($_POST['urole']) : 'user';

        // ตรวจสอบข้อมูล
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        die("กรุณากรอกข้อมูลให้ครบถ้วน");
        }

        // เพิ่มผู้ใช้
        $query = "INSERT INTO users (firstname, lastname, email, password, urole)
        VALUES (:firstname, :lastname, :email, :password, :urole)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
        'firstname' => $firstname, // แก้ไขจาก first_name เป็น firstname
        'lastname' => $lastname, // แก้ไขจาก last_name เป็น lastname
        'email' => $email,
        'password' => $password,
        'urole' => $urole
        ]);

        header('Location: User.php');
        exit();
        }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>เพิ่มผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">เพิ่มผู้ใช้</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input type="text" name="firstname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">นามสกุล</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">อีเมล</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">สถานะ</label>
                <select name="urole" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="member">Member</option>
                    <option value="user">User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">บันทึก</button>
            <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>

</html>