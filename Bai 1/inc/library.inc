<?php
function initClass(mysqli $conn)
{
    $sql = 'SELECT DISTINCT lop FROM sinhvien WHERE lop IS NOT NULL AND lop <> \'\' ORDER BY lop';
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        http_response_code(500);
        exit('Không thể tải danh sách lớp.');
    }

    echo '<label for="lop">Chọn lớp:</label> ';
    echo '<select id="lop" name="lop" onchange="sendajax()">';
    while ($row = mysqli_fetch_assoc($result)) {
        $lop = htmlspecialchars($row['lop'], ENT_QUOTES, 'UTF-8');
        echo '<option value="' . $lop . '">' . $lop . '</option>';
    }
    echo '</select>';
    mysqli_free_result($result);
}
