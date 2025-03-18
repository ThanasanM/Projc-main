<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // ลบผู้ใช้จากฐานข้อมูล
    $query = "DELETE FROM users WHERE id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../index.php');
    }
}
