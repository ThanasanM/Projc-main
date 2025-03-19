<?php
session_start();
require_once '../config/db.php'; // ปรับ path ให้ถูกต้องตามโครงสร้างไฟล์

// ตรวจสอบว่ามีการส่งข้อมูลฟอร์มเข้ามาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $page = $_POST['page'];
    $video_filename = '';

    // ตรวจสอบว่าอัปโหลดไฟล์หรือไม่
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['video']['name']);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // ตรวจสอบว่าไฟล์เป็น MP4 หรือไม่
        if ($file_type == 'mp4') {
            if (move_uploaded_file($_FILES['video']['tmp_name'], $target_file)) {
                $video_filename = basename($_FILES['video']['name']);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Only MP4 files are allowed.";
        }
    }

    // เพิ่มข้อมูลวิดีโอใหม่ลงในฐานข้อมูล
    if ($video_filename) {
        $stmt = $conn->prepare("INSERT INTO videos (name, description, video_filename, page) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $video_filename, $page]);
        header("Location: Program.php"); // เปลี่ยนเส้นทางกลับไปยังหน้าหลัก
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">เพิ่มวิดีโอใหม่</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อวิดีโอ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="page" class="form-label">หน้าที่แสดงวิดีโอ</label>
                <select class="form-select" id="page" name="page" required>
                    <option value="alphabet_course">Alphabet Course</option>
                    <option value="vocabulary_grammar_course">Vocabulary and Grammar Course</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">เลือกไฟล์วิดีโอ (MP4)</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/mp4" required>
            </div>
            <button type="submit" class="btn btn-primary">เพิ่มวิดีโอ</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>