<?php
session_start();
require_once '../config/db.php';

// ตรวจสอบว่าได้รับ ID ของผู้ใช้ที่ต้องการแก้ไข
if (!isset($_GET['id'])) {
    header("Location: Edit_user.php");
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
        'first_name' => $first_name,
        'last_name' => $last_name,
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้ใช้</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>แก้ไขข้อมูลผู้ใช้</h2>

        <!-- ฟอร์มแก้ไขข้อมูลผู้ใช้ -->
        <form method="POST">
            <div class="mb-3">
                <label for="firstname">ชื่อ:</label>
                <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($user['firstname']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="lastname">นามสกุล:</label>
                <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($user['lastname']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email">อีเมล:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="urole">สถานะ:</label>
                <select name="urole" class="form-select">
                    <option value="admin" <?= $user['urole'] == 'admin' ? 'selected' : ''; ?>>admin</option>
                    <option value="teacher" <?= $user['urole'] == 'teacher' ? 'selected' : ''; ?>>teacher</option>
                    <option value="member" <?= $user['urole'] == 'member' ? 'selected' : ''; ?>>member</option>
                    <option value="user" <?= $user['urole'] == 'user' ? 'selected' : ''; ?>>user</option>
                </select>
            </div>

            <a href="Edit_user.php" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</a>
            <a href="Edit_user.php" class="btn btn-secondary">กลับ</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>