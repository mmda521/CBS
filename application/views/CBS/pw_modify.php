<!DOCTYPE html>
<html>
<head>
    <title>用户添加</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/style.css" />
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/validate/validator.js"></script>
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>
<form action="<?php echo site_url("user/password_change_edit");?>" method="post"  name="myform" id="myform">
        <table class="table table-bordered table-hover m10">

        <tr>
            <td class="tableleft">登录账号</td>
            <td><input type="text" name="login_no" id="login_no"  value="<?php echo $info['LOGIN_NO'] ?>" readonly/></td>
            <td class="tableleft">用户名</td>
            <td><input type="text" name="username" id="username"  value="<?php echo $info['USER_NAME'] ?>"readonly/></td>
        </tr>
        <tr>
            <td class="tableleft">密码</td>
            <td><input type="password" name="password" id="password" required="true" errMsg="请输入密码" tip="请输入密码" value=""/></td>
            <td class="tableleft">确认密码</td>
            <td><input type="password" name="enpassword" id="enpassword" required="true" errMsg="密码" tip="请输入密码" value=""/></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center;color:red">注:密码区分大小写</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center">
                <button type="submit" class="btn btn-primary"  id="btnSave">保存</button>&nbsp;
                <button type="reset" class="btn btn-primary" id="btnSave">重置</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<script type="text/javascript">
    BUI.use('bui/calendar',function(Calendar){
        var datepicker = new Calendar.DatePicker({
            trigger:'.calendar',
            autoRender : true
        });
    });
</script>
<script>
    $(function () {
        $("#btnSave").click(function(){
            if($("#myform").Valid() == false || !$("#myform").Valid()) {
                return false ;
            }
        });
    });
</script>
