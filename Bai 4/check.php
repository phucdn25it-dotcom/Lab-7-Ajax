<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Phương thức không được hỗ trợ.');
}

$us = trim($_POST['user'] ?? '');
$pw = $_POST['pass'] ?? '';
if ($us === '' || $pw === '') {
    http_response_code(400);
    exit('<span class="notice-error">Vui lòng nhập tên đăng nhập và mật khẩu.</span>');
}

require __DIR__ . '/connect.php';
$stmt = mysqli_prepare($con, 'SELECT masv, hoten, lop FROM sinhvien WHERE masv = ? AND matkhau = ?');
if (!$stmt) {
    http_response_code(500);
    mysqli_close($con);
    exit('<span class="notice-error">Không thể kiểm tra thông tin đăng nhập.</span>');
}

mysqli_stmt_bind_param($stmt, 'ss', $us, $pw);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row) {
    session_regenerate_id(true);
    $_SESSION['code'] = $row['masv'];
    $_SESSION['info'] = $row['masv'] . ' - ' . $row['hoten'] . ' - ' . $row['lop'];
    echo '<span class="notice-success">Đăng nhập thành công: ';
    echo htmlspecialchars($row['masv'] . ' - ' . $row['hoten'], ENT_QUOTES, 'UTF-8');
    echo ' | <a href="work.php">Tiếp tục</a></span>';
} else {
    http_response_code(401);
    echo '<span class="notice-error">Tên đăng nhập hoặc mật khẩu không đúng.</span>';
}

mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($con);
