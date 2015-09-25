
{{ content() }}
<div class="container">
<div class="row">

    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>登录</h2>
        </div>
        {{ form('session/start', 'role': 'form') }}
            <fieldset>
                {{ hidden_field('callback', 'class': "form-control") }}
                <div class="form-group">
                    <label for="email">用户名/Email</label>
                    <div class="controls">
                        {{ text_field('email', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <div class="controls">
                        {{ password_field('password', 'class': "form-control") }}
                    </div>
                </div>
                <div class="form-group">
                    {{ submit_button('登录', 'class': 'btn btn-primary btn-large') }}
                    <a class="_weiboLogin"><img src="http://timg.sjs.sinajs.cn/t4/appstyle/widget/images/loginButton/loginButton_24.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" /></a>
                    <span id="qqLoginBtn"></span>

                </div>
            </fieldset>
        </form>
    </div>

    <div class="col-md-5" style="display: none  ">

        <div class="page-header">
            <h2>没有账号?</h2>
        </div>

        <p>申请账号开启功能：</p>
        <ul>
            <li>评论博客</li>
        </ul>

        <div class="clearfix center">
            {{ link_to('register', '注册', 'class': 'btn btn-primary btn-large btn-success') }}
        </div>
    </div>

</div>
</div>
<script type="text/javascript">
    require(['domready','jquery'], function (domready,$) {
        domready(function () {
            //github登陆按钮
            //微博登陆按钮
            $(document).on('click','._weiboLogin',function(){
                return window.open('{{ weiboCallBack }}', 'oauth2Login_weibo' ,'height=525,width=585, toolbar=no, menubar=no, scrollbars=no, status=no, location=yes, resizable=yes');
            });
            //qq登陆按钮
            QC.Login({
                btnId:"qqLoginBtn"    //插入按钮的节点id
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
                        ].join("");
                dom && (dom.innerHTML = QC.String.format(_logoutTemplate, {
                    nickname : QC.String.escHTML(reqData.nickname), //做xss过滤
                    figureurl : reqData.figureurl
                }));
            }, function(opts){//注销成功
                alert('QQ登录 注销成功');
            });
        });
    });


</script>