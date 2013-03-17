<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>水晶100后台</title>
    <link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="./themes/icon.css">
    <script type="text/javascript" src="./js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="./js/jquery.easyui.min.js"></script>
</head>
<body style="height:100%;width:100%;overflow:hidden;border:none;" >
<div id="win"  title="登录" style="width:300px;height:180px;">
    <form style="padding:10px 20px 10px 40px;">
        <p>用户: <input type="text" class="easyui-validatebox"  name="username" id="username" data-options="required:true"></p>
        <p>密码: <input type="password" class="easyui-validatebox" name="password" id="password" data-options="required:true"></p>
        <div style="padding:5px;text-align:center;">
            <a href="javascript:void(0);" class="easyui-linkbutton" icon="icon-ok" id="login">登录</a>
            <a href="javascript:void(0);" class="easyui-linkbutton" icon="icon-cancel" id="clear">清空</a>
        </div>
    </form>
</div>

</body>
<script type="text/javascript">
    var loginWin = $("#win").window();
    var loginForm = loginWin.find("form");
    loginForm.form('clear');
    $("#login").click(function(){
        $.ajax({
            url : "http://localhost/shuijing/index.php/index/check/",
            type : "post",
            data : {username : $("#username").val(),password:$("#password").val()},
            success : function (data) {
                if (data.errorcode==1) {
                    $.messager.alert('错误',data.message,'error');
                } else {
                    window.location.href = window.location.href;
                }
            }
        })
    });
    $("#clear").click(function(){
        loginForm.form('clear');
    });
</script>
</body>
</html>