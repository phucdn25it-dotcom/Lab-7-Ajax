<?php
require_once __DIR__ . '/inc/connect.inc';

header('Content-Type: text/html; charset=utf-8');

$lop = isset($_GET['lop']) ? trim($_GET['lop']) : '';
if ($lop === '' || strlen($lop) > 4) {
    http_response_code(400);
    exit('Lớp không hợp lệ.');
}

$stmt = mysqli_prepare($con, 'SELECT masv, hoten, diachi FROM sinhvien WHERE lop = ? ORDER BY masv');
if (!$stmt) {
    http_response_code(500);
    exit('Không thể truy vấn danh sách sinh viên.');
}
mysqli_stmt_bind_param($stmt, 's', $lop);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

echo '<table class="students">';
echo '<thead><tr><th>TT</th><th>Mã số</th><th>Họ tên</th><th>Địa chỉ</th></tr></thead><tbody>';
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr><td>' . $i++ . '</td>';
    echo '<td>' . htmlspecialchars($row['masv'], ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($row['hoten'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($row['diachi'] ?? '', ENT_QUOTES, 'UTF-8') . '</td></tr>';
}
if ($i === 1) {
    echo '<tr><td colspan="4">Lớp này chưa có sinh viên.</td></tr>';
}
echo '</tbody></table>';

mysqli_free_result($result);
mysqli_stmt_close($stmt);
