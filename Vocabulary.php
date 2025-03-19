<?php
session_start();
require_once 'config/db.php'; // ปรับ path ให้ถูกต้องตามโครงสร้างไฟล์

// กำหนดชื่อหน้าเป็น 'alphabet_course' หรือ 'vocabulary_grammar_course' ตามที่ต้องการ
$page = 'vocabulary_grammar_course'; // หรือ 'vocabulary_grammar_course' ตามที่ต้องการ

// ดึงข้อมูลวิดีโอที่ตรงกับหน้า 'alphabet_course'
$stmt = $conn->prepare("SELECT * FROM videos WHERE page = ?");
$stmt->execute([$page]);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Vocabulary course</title>

    <!-- เพิ่มการเชื่อมโยงกับ Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="d-flex justify-content-between align-items-center p-3 bg-dark text-white">
        <h1>Learn Japanese</h1>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="homepage.html">Exit</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="Alphabet.php">Alphabet </a></li>
                <li class="nav-item"><a class="nav-link text-white" href="Vocabulary.php">Vocabulary and grammar</a></li>
            </ul>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Vocabulary and grammar</h2>
        <div class="row">
            <?php foreach ($videos as $video) { ?>
                <div class="col-md-6 mb-4">
                    <div class="row g-0">
                        <!-- ตารางด้านข้าง (ชื่อและคำอธิบาย) -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($video['name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- วิดีโอแสดงตรงกลาง -->
                        <div class="col-md-8">
                            <div class="card h-100">
                                <div class="card-body">
                                    <video width="100%" controls>
                                        <source src="uploads/<?php echo htmlspecialchars($video['video_filename']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </main>

    <!-- Script สำหรับ Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn = null; ?>