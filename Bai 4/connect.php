<?php
$con = mysqli_connect('localhost', 'root', '', 'udn');
if (!$con) {
    http_response_code(500);
    exit('Không thể kết nối cơ sở dữ liệu.');
}
mysqli_set_charset($con, 'utf8mb4');
