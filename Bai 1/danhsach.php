<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax - Danh sách sinh viên theo lớp</title>
    <link rel="stylesheet" href="style/style.css">
    <script>
        function sendajax() {
            var lop = document.getElementById('lop').value;
            var bang = document.getElementById('ds');
            var xhr = new XMLHttpRequest();

            bang.innerHTML = '<p class="status">Đang tải danh sách...</p>';
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        bang.innerHTML = xhr.responseText;
                    } else {
                        bang.innerHTML = '<p class="error">Không tải được danh sách sinh viên.</p>';
                    }
                }
            };
            xhr.open('GET', 'ds.php?lop=' + encodeURIComponent(lop), true);
            xhr.send();
        }
    </script>
</head>
<body>
    <main class="page">
        <h1>Ajax: In danh sách sinh viên theo từng lớp</h1>
        <section class="panel" aria-label="Danh sách sinh viên">
            <div class="controls">
                <strong>In danh sách theo lớp</strong>
                <div>
                    <?php
                    require_once __DIR__ . '/inc/connect.inc';
                    require_once __DIR__ . '/inc/library.inc';
                    initClass($con);
                    ?>
                </div>
            </div>
            <div id="ds" aria-live="polite"></div>
        </section>
    </main>
    <script>sendajax();</script>
</body>
</html>
