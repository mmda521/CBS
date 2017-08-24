<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>用户编辑__<?php echo $info['username'];?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script> 	
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/bui-min.js"></script>
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Js/validate/validator.js"></script>
	<link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
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
<div class="form-inline definewidth m20" >
   <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("user/index");?>">网站用户管理</a>
</div>
<form action="<?php echo site_url("user/edit");?>" method="post" name="">
<input type="hidden" name="action" value="doedit">
<input type="hidden" name="id" value="<?php echo $info['uid'];?>">
<table class="table table-bordered table-hover m10">
    <tr>
        <td class="tableleft">用户名：</td>
        <td><input type="text" name="username"  value="<?php echo $info['username'];?>" id="username" required="true" errMsg="请输入用户名，必须在3-16位数" tip="请输入用户名，必须在3-16位数"/></td>
    </tr>
    <tr>
        <td class="tableleft">密码</td>
        <td><input type="text" name="passwd" id="passwd" />备注：如果密码不为空将进行修改密码</td>
    </tr> 	
    <tr>
        <td class="tableleft">过期日期</td>
        <td><input type="text" name="expire" id="expire" value="<?php echo ($info['expire'] == 0 )?'0':date("Y-m-d H:i:s",$info['expire']);?>"/>备注：其中0为不过期</td>
    </tr> 	
    <tr>
        <td class="tableleft">状态：</td>
        <td>
			<input type="radio" checked="" value="1" name="status" <?php if($info['status'] == 1 ){echo "checked";}?>>
		启用
		<input type="radio" value="0" name="status" <?php if($info['status'] == 0 ){echo "checked";}?>>
		禁用 
		</td>
    </tr>	  
	
    <tr>
        <td class="tableleft"></td>
        <td>
		<input type="submit" value="提&nbsp;交" class="btn btn-primary">
		</td>
    </tr>	
	  
</table>
</form>	   
</body>
</html>
<!-- script start-->
<script type="text/javascript">
	var Calendar = BUI.Calendar
	var datepicker = new Calendar.DatePicker({
	trigger:'#expire',
	showTime:true,
	autoRender : true
	});
</script>
<!-- script end -->
