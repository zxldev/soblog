<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
</head>
<body>
<div style="text-align: center;"><p><span id="timeSpan">3</span>秒钟后跳转正在跳转……</p>

    <p><a style="color: blue;" onclick="jump()">立即跳转</a></p>
</div>

<script>
    var time = 3;
    function jump() {
        window.opener.location.reload();
        self.close();
    }
    function changeTime() {
        if (time >= 0) {
            time--;
            document.getElementById('timeSpan').innerHTML = time;
        }
    }
    setTimeout(jump, 3000);
    setInterval(changeTime, 1000);
</script>
</body>
</html>
