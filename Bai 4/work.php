<?php
session_start();
if (empty($_SESSION['code'])) {
    header('Location: login.html');
    exit;
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khu vực thành viên</title>
    <style>
        body { margin: 48px auto; padding: 0 18px; max-width: 700px; color: #172033; font: 16px/1.5 Arial, sans-serif; background: #f5f7fb; }
        main { padding: 22px; border: 1px solid #d5dce5; border-radius: 8px; background: #fff; }
        h1 { color: #173f73; }
        a { color: #175a9b; }
    </style>
</head>
<body>
    <main>
        <h1>Đăng nhập thành công</h1>
        <p>Xin chào, <?= htmlspecialchars($_SESSION['info'], ENT_QUOTES, 'UTF-8') ?>.</p>
        <a href="logout.php">Đăng xuất</a>
    </main>
</body>
</html>
