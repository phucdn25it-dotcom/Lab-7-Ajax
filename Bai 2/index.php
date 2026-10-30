<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP with PHP</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<main class="page">
    <h1>OOP with PHP</h1>
    <label class="select-label" for="chon">Chọn bảng dữ liệu</label>
    <select id="chon" onchange="ajax()">
        <option value="">-- Chọn --</option>
        <option value="giaovien">Giáo viên</option>
        <option value="sinhvien">Sinh viên</option>
        <option value="hocphan">Học phần</option>
    </select>
    <hr>
    <div id="info" aria-live="polite"></div>
</main>
<script>
function ajax() {
    var table = document.getElementById('chon').value;
    var info = document.getElementById('info');

    if (!table) {
        info.innerHTML = '';
        info.hidden = true;
        return;
    }

    info.hidden = false;
    info.innerHTML = '<p class="status">Đang tải dữ liệu...</p>';
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                info.innerHTML = xhr.responseText;
            } else {
                info.innerHTML = '<p class="error">Không tải được dữ liệu.</p>';
            }
        }
    };
    xhr.open('GET', 'showTable.php?table=' + encodeURIComponent(table), true);
    xhr.send();
}
</script>
</body>
</html>
