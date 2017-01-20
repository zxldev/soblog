define("userconfig", ['jquery','alertify'], function ($,alertify) {
    'use strict';
    var exports = {
        updatePwd: function () {
            var oldpwd = $('._oldpwd').val(),
                newpwd = $('._newpwd').val(),
                confirmpwd = $('._confirmpwd').val();
            if(oldpwd==''||newpwd==''||confirmpwd==''){
                alertify.error("密码格式错误。");
            }
            if(newpwd!=confirmpwd){
                alertify.error("两次输入的密码不一致。");
                return;
            }
            $.ajax({
                url: '/api/updatepwd',
                type: 'post',
                data:{
                    oldpwd:oldpwd,
                    newpwd:newpwd,
                    confirmpwd:confirmpwd
                },
                dataType: 'json',
                cache: false,
                success: function (data) {
                    alertify.success("更新密码成功");
                }
            });
        }
    };
    return exports;
});
