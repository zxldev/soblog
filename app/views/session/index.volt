
{{ content() }}
<div class="container">
<div class="row">

    <div class="col-md-6 col-md-offset-3">
        <div class="page-header">
            <h2>登录</h2>
        </div>
        {{ form('session/start', 'role': 'form') }}
            <fieldset>
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