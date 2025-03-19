<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // ตรวจสอบว่ามีผู้ใช้นี้อยู่ในระบบหรือไม่
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ดำเนินการลบผู้ใช้
        $deleteStmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $deleteStmt->execute(['id' => $id]);

        if ($deleteStmt->rowCount()) {
            $_SESSION['success'] = "ลบผู้ใช้สำเร็จ!";
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาด ไม่สามารถลบผู้ใช้ได้!";
        }
    } else {
        $_SESSION['error'] = "ไม่พบผู้ใช้ที่ต้องการลบ!";
    }
}

header("Location: User.php");
exit();
