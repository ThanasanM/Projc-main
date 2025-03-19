<?php
session_start();
require_once '../config/db.php';

// ดึงข้อมูลวิดีโอทั้งหมด
$stmt = $conn->prepare("SELECT * FROM videos");
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- My CSS -->
    <link rel="stylesheet" href="assets\css\style.css">

    <title>AdminHub</title>
</head>

<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="index.php" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Course.html">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">Course</span>
                </a>
            </li>
            <li>
                <a href="Program.php">
                    <i class='bx bxs-book-content'></i>
                    <span class="text">Study program</span>
                </a>
            </li>
            <li>
                <a href="User.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Edit role</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Message</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="..\thhub\index.php" class="th">
                    <i class='bx bxs-graduation'></i>
                    <span class="text">Teacher</span>
                </a>
            </li>
            <li>
                <a href="../homepage.html" class="ho">
                    <i class='bx bxs-home'></i>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">0</span>
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="container mt-5">
                <h2 class="mb-4 text-center">จัดการวิดีโอ</h2>
                <a href="add_video.php" class="btn btn-success mb-3">เพิ่มวิดีโอ</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ชื่อวิดีโอ</th>
                            <th scope="col">คำอธิบาย</th>
                            <th scope="col">วิดีโอ</th>
                            <th scope="col">หน้าที่แสดง</th>
                            <th scope="col">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($videos as $video): ?>
                            <tr>
                                <td><?php echo $video['id']; ?></td>
                                <td><?php echo htmlspecialchars($video['name']); ?></td>
                                <td><?php echo htmlspecialchars($video['description']); ?></td>
                                <td>
                                    <video width="200" controls>
                                        <source src="../uploads/<?php echo htmlspecialchars($video['video_filename']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </td>
                                <td><?php echo htmlspecialchars($video['page']); ?></td>
                                <td>
                                    <a href="edit_video.php?id=<?php echo $video['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <a href="delete_video.php?id=<?php echo $video['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this video?')">ลบ</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="assets\js\script.js"></script>
</body>

</html>
<?php $conn = null; ?>