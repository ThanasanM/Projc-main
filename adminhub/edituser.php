<?php
session_start();
require_once '../config/db.php';

// ตรวจสอบว่าได้รับ ID ของผู้ใช้ที่ต้องการแก้ไข
if (!isset($_GET['id'])) {
    header("Location:  User.php");
    exit();
}

$id = $_GET['id'];

// ดึงข้อมูลผู้ใช้ที่ต้องการแก้ไขจากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: Edit_user.php");
    exit();
}

// อัปเดตข้อมูลผู้ใช้
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $urole = isset($_POST['urole']) ? trim($_POST['urole']) : 'user';

    // ตรวจสอบข้อมูลที่กรอก
    if (empty($first_name) || empty($last_name) || empty($email)) {
        die("กรุณากรอกข้อมูลให้ครบถ้วน");
    }

    // อัปเดตข้อมูลในฐานข้อมูล
    $update_query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, urole = :urole WHERE id = :id";
    $stmt = $conn->prepare($update_query);
    $stmt->execute([
        'first_name' => $firstname,
        'last_name' => $lastname,
        'email' => $email,
        'urole' => $urole,
        'id' => $id
    ]);

    header("Location: Edit_user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>แก้ไขผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">แก้ไขผู้ใช้</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">ชื่อ</label>
                <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($user['firstname']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">นามสกุล</label>
                <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($user['lastname']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">อีเมล</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">สถานะ</label>
                <select name="urole" class="form-select" required>
                    <option value="admin" <?= $user['urole'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="teacher" <?= $user['urole'] == 'teacher' ? 'selected' : '' ?>>Teacher</option>
                    <option value="member" <?= $user['urole'] == 'member' ? 'selected' : '' ?>>Member</option>
                    <option value="user" <?= $user['urole'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <a href=" User.php" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</a>
            <a href=" User.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>

</html>