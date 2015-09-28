<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101254880"  data-redirecturi="http://www.souii.com/session/qqlogincallback"  charset="utf-8"></script>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div style="text-align: center;"><p><span id="timeSpan">3</span>秒钟后跳转正在跳转……</p>

    <p><a style="color: blue;" onclick="jump()">立即跳转</a></p>
    <div id="qqLoginBtnwin"></div>
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
    QC.Login({
        btnId:"qqLoginBtnwin"    //插入按钮的节点id
    }, function(reqData, opts){//登录成功
        //根据返回数据，更换按钮显示状态方法
        var dom = document.getElementById(opts['btnId']),
                _logoutTemplate=[
                    //头像
                    '<span><img src="{figureurl}" class="{size_key}"/></span>',
                    //昵称
                    '<span>{nickname}</span>',
                    //退出
                    '<span><a href="javascript:QC.Login.signOut();">退出</a></span>'
                ].join(""),
                uid = '',
                token = '';
        dom && (dom.innerHTML = QC.String.format(_logoutTemplate, {
            nickname : QC.String.escHTML(reqData.nickname), //做xss过滤
            figureurl : reqData.figureurl
        }));
        debugger;
        QC.Login.getMe(function(openId, accessToken){
            uid = openId;
            token = accessToken;
            $.ajax({
                url: '/api/qqlogin',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    'uid': uid,
                    'token': token,
                    'name': reqData.nickname,
                    "photo": reqData.figureurl_qq_2//产品id （大于0）已发布的产品ID"
                },
                success: function (data) {
                    debugger;
                    setTimeout(jump, 3000);
                    setInterval(changeTime, 1000);
                }
            });
        });

    }, function(opts){//注销成功
        alert('QQ登录 注销成功');
    });

</script>
</body>
</html>
