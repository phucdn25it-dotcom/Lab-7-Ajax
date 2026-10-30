<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm tên học phần</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 40px; color: #172033; font: 15px/1.5 Arial, sans-serif; background: #f5f7fb; }
        h1 { margin: 0 0 18px; color: #173f73; font-size: 24px; }
        .search-box { position: relative; display: inline-block; width: min(420px, 100%); }
        .search-box input { width: 100%; height: 40px; padding: 8px 12px; border: 1px solid #9aa9bc; border-radius: 5px; font: inherit; }
        .result { position: absolute; z-index: 2; top: 100%; left: 0; width: 100%; overflow: hidden; border-radius: 0 0 5px 5px; background: #fff; box-shadow: 0 4px 10px rgb(15 23 42 / 12%); }
        .result:empty { display: none; }
        .result p { margin: 0; padding: 9px 12px; border: 1px solid #d5dce5; border-top: 0; cursor: pointer; }
        .result p:hover, .result p:focus { outline: none; background: #edf4fc; }
        .result .message { color: #526174; cursor: default; }
        .result .message:hover { background: #fff; }
    </style>
</head>
<body>
    <main>
        <h1>Tìm kiếm tên học phần</h1>
        <div class="search-box">
            <label for="term">Tên học phần</label>
            <input id="term" type="text" autocomplete="off" placeholder="Nhập tên học phần..." aria-controls="results" aria-autocomplete="list">
            <div id="results" class="result" role="listbox" aria-live="polite"></div>
        </div>
    </main>
    <script>
        (function () {
            var input = document.getElementById('term');
            var results = document.getElementById('results');
            var timer;
            var request;

            input.addEventListener('input', function () {
                window.clearTimeout(timer);
                if (request) request.abort();
                var term = input.value.trim();
                if (!term) {
                    results.replaceChildren();
                    return;
                }
                results.innerHTML = '<p class="message">Đang tìm...</p>';
                timer = window.setTimeout(function () {
                    request = new XMLHttpRequest();
                    request.onreadystatechange = function () {
                        if (request.readyState === XMLHttpRequest.DONE) {
                            if (request.status === 200) {
                                results.innerHTML = request.responseText;
                            } else {
                                results.innerHTML = '<p class="message">Không thể tải kết quả.</p>';
                            }
                        }
                    };
                    request.open('GET', 'backend-search.php?term=' + encodeURIComponent(term), true);
                    request.send();
                }, 200);
            });

            results.addEventListener('click', function (event) {
                if (event.target.matches('p[data-value]')) {
                    input.value = event.target.dataset.value;
                    results.replaceChildren();
                    input.focus();
                }
            });

            document.addEventListener('click', function (event) {
                if (!event.target.closest('.search-box')) results.replaceChildren();
            });
        }());
    </script>
</body>
</html>
