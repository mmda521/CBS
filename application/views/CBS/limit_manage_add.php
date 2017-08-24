<?php
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
?>
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
    <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("user/limit_manage");?>">返回</a>
<form action="<?php echo site_url("user/limit_manage_add_ajax_data");?>" method="post"  name="myform" id="myform">
    <input type="hidden" name="action" value="doadd">
    <table class="table table-bordered table-hover">

        <tr>
            <td class="tableleft">公司</td>
            <td><input type="text" name="company_code" id="company_code" required="true" errMsg="请输入公司名称" tip="请输入公司名称"/></td>
            <td class="tableleft">角色名称</td>
            <td><input type="text" name="role_name" id="role_name" required="true" errMsg="请输入角色名称" tip="请输入角色名称"/></td>
        </tr>
        <tr>
            <td class="tableleft" >角色描述</td>
            <td colspan="3"><input type="text" name="role_desc" id="role_desc" required="true" errMsg="请输入描述" tip="请输入描述"/></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center">
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
