<!DOCTYPE html>
<html>
<head>
<title>郑欧国际陆港跨境场站系统（出口）</title>
<meta charset="UTF-8">
<link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/login.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/sweet-alert.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/common.js"></script>
<!--背景图片自动更换-->
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/supersized.3.2.7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/supersized-init.js"></script>
<!--表单验证-->
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery.validate.min.js?var1.14.0"></script>
	<!--弹窗提醒-->
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/sweet-alert.min.js"></script>
</head>
<body>
<div class="login-container">
		<h1>中浩跨境场站物流信息系统(出口)</h1>
		<div class="connect"> 
				<!--<p >www.zih718.com</p>--> 
		</div>
		<form action="<?php echo site_url("login/dologin");?>" method="post" id="loginForm" class="definewidth m2"  name="myform">
				<div class="view_login_user">
						<input type="text" name="login_no" class="login_no" placeholder="用户名" autocomplete="off"required="true"/>
				</div>
				<div class="view_login_user">
						<input  type="password" name="password" class="password" placeholder="密码" oncontextmenu="return false" onpaste="return false" />
				</div>
				<button id="submit" type="submit">登 陆</button>
		</form>
<div class="ui">
		<button type="button" class="register-tis">还有没有账号？</button>
</div>
</div>

<script>
document.querySelector('div.ui button').onclick = function(){
	swal("请联系系统管理员");
};
</script>
</body>
</html>