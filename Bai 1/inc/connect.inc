<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'udn';

$con = mysqli_connect($server, $user, $pass, $db);
if (!$con) {
    http_response_code(500);
    exit('Không thể kết nối cơ sở dữ liệu: ' . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8'));
}

mysqli_set_charset($con, 'utf8mb4');
