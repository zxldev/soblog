{{ content() }}
{{ form("systems/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("systems", "返回","class":"btn btn-primary") }}</td>
    </tr>
</table>

<div align="center">
    <h1>修改密码</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="cate">旧密码</label>
        </td>
        <td align="left">
            {{ password_field("oldpassword", "class":"form-control _oldpwd") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="system_name">新密码</label>
        </td>
        <td align="left">
            {{ password_field("newpassword", "size" : 30,"class":"form-control _newpwd") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="system_value">确认密码</label>
        </td>
        <td align="left">
            {{ password_field("confirmpassword","size" : 30,"class":"form-control _confirmpwd") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td><input type="button" class="btn btn-primary _updatepwd" value="修改密码"></td>
    </tr>
</table>

{{ endForm() }}

<script>

    require(['domready'], function (domready) {
        domready(function () {
            require(['jquery', 'userconfig'], function ($, user) {
                $(document).on('click', '._updatepwd', function () {
                    user.updatePwd();
                });
            });
        });
    });


</script>
