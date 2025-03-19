<?php
session_start();
require_once '../config/db.php';

// ดึงข้อมูลวิดีโอที่ต้องการแก้ไข
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([$id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $page = $_POST['page'];

    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $video_tmp = $_FILES['video']['tmp_name'];
        $video_name = $_FILES['video']['name'];
        $video_path = "uploads/" . $video_name;
        move_uploaded_file($video_tmp, $video_path);
    } else {
        $video_name = $video['video_filename'];
        $video_path = $video['video_path'];
    }

    $stmt = $conn->prepare("UPDATE videos SET name = ?, description = ?, video_filename = ?, video_path = ?, page = ? WHERE id = ?");
    $stmt->execute([$name, $description, $video_name, $video_path, $page, $id]);

    header("Location:  Program.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขวิดีโอ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">แก้ไขวิดีโอ</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อวิดีโอ</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($video['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">คำอธิบาย</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($video['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">เลือกไฟล์วิดีโอ (หากต้องการเปลี่ยน)</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/mp4">
            </div>
            <div class="mb-3">
                <label for="page" class="form-label">หน้าที่แสดงวิดีโอ</label>
                <select class="form-select" id="page" name="page" required>
                    <option value="alphabet_course" <?php echo isset($video['page']) && $video['page'] == 'alphabet_course' ? 'selected' : ''; ?>>Alphabet Course</option>
                    <option value="vocabulary" <?php echo isset($video['page']) && $video['page'] == 'vocabulary' ? 'selected' : ''; ?>>Vocabulary and Grammar Course</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">อัปเดตวิดีโอ</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>