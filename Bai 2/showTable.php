<?php
require_once __DIR__ . '/database.class.php';

header('Content-Type: text/html; charset=utf-8');

$tables = [
    'giaovien' => ['SELECT * FROM giaovien ORDER BY magv', 'Danh sách giáo viên'],
    'sinhvien' => ['SELECT * FROM sinhvien ORDER BY masv', 'Danh sách sinh viên'],
    'hocphan' => ['SELECT * FROM hocphan ORDER BY mahp', 'Danh sách học phần'],
];
$table = $_GET['table'] ?? '';

if (!isset($tables[$table])) {
    http_response_code(400);
    exit('<p class="error">Vui lòng chọn một bảng hợp lệ.</p>');
}

try {
    $dao = new Dao('root', '', 'udn');
    $dao->table($tables[$table][0], $tables[$table][1]);
} catch (Throwable $error) {
    http_response_code(500);
    echo '<p class="error">Không thể tải dữ liệu. Hãy kiểm tra kết nối cơ sở dữ liệu udn.</p>';
}
