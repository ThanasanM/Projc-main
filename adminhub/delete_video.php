<?php
session_start();
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ดึงข้อมูลวิดีโอที่ต้องการลบ
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([$id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);

    // ลบไฟล์วิดีโอจากเซิร์ฟเวอร์
    unlink($video['video_path']);

    // ลบข้อมูลจากฐานข้อมูล
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location:  Program.php");
    exit();
}
