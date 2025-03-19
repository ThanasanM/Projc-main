<?php
session_start();
require_once '../config/db.php';

// ดึงข้อมูลผู้ใช้ทั้งหมด
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// อัปเดตสถานะ
if (isset($_GET['update_status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_status = $_GET['update_status'];

    $update_query = "UPDATE users SET urole = :urole WHERE id = :id";
    $stmt = $conn->prepare($update_query);
    $stmt->execute(['urole' => $new_status, 'id' => $id]);

    header("Location: User.php");
    exit();
}

// ลบผู้ใช้
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($delete_query);
    $stmt->execute(['id' => $id]);

    header("Location: User.php");
    exit();
}
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
                <a href="../page_login\logout.php" class="logout">
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
        <main class="container mt-5">
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>รายชื่อผู้ใช้ทั้งหมด</h3>
                        <i class='bx bx-search'></i>
                        <i class='bx bx-filter'></i>
                        <a href="add_user.php" class="btn btn-primary">เพิ่มผู้ใช้ใหม่</a>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>อีเมล</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <?php if ($user['urole'] == 'admin') continue; ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['firstname']); ?></td>
                                    <td><?= htmlspecialchars($user['lastname']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <!-- เปลี่ยนสถานะ -->
                                        <form method="GET" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                            <select name="update_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <?php
                                                $roles = ['teacher', 'member', 'user'];
                                                foreach ($roles as $role) {
                                                    $selected = $user['urole'] === $role ? 'selected' : '';
                                                    echo "<option value='$role' $selected>$role</option>";
                                                }
                                                ?>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- ปุ่มแก้ไข -->
                                        <a href="edituser.php?id=<?= $user['id']; ?>" class="btn btn-success btn-sm">แก้ไข</a>
                                        <!-- ปุ่มลบ -->
                                        <a href="delete_user_action.php?id=<?= $user['id']; ?>"
                                            onclick="return confirm('ยืนยันการลบผู้ใช้นี้?');"
                                            class="btn btn-danger btn-sm">
                                            ลบ
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets\js\script.js"></script>
</body>

</html>