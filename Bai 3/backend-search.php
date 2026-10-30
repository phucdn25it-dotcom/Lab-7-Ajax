<?php
header('Content-Type: text/html; charset=utf-8');

$link = mysqli_connect('localhost', 'root', '', 'udn');
if (!$link) {
    http_response_code(500);
    exit('<p class="message">Không thể kết nối cơ sở dữ liệu.</p>');
}
mysqli_set_charset($link, 'utf8mb4');

$term = isset($_GET['term']) ? trim($_GET['term']) : '';
if ($term === '') {
    mysqli_close($link);
    exit;
}

$sql = 'SELECT tenhp FROM hocphan WHERE tenhp LIKE ? ORDER BY tenhp';
$stmt = mysqli_prepare($link, $sql);
if (!$stmt) {
    http_response_code(500);
    mysqli_close($link);
    exit('<p class="message">Không thể tìm kiếm học phần.</p>');
}

$pattern = $term . '%';
mysqli_stmt_bind_param($stmt, 's', $pattern);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    exit('<p class="message">Không thể tìm kiếm học phần.</p>');
}

$result = mysqli_stmt_get_result($stmt);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['tenhp'] ?? '', ENT_QUOTES, 'UTF-8');
        echo '<p role="option" tabindex="0" data-value="' . $name . '">' . $name . '</p>';
    }
} else {
    echo '<p class="message">Không tìm thấy học phần phù hợp.</p>';
}

if ($result) {
    mysqli_free_result($result);
}
mysqli_stmt_close($stmt);
mysqli_close($link);
