//登录页面js
$(function () {

		$("#btnSave").click(function(){
			if($("#name").val() == ''){
				BUI.Message.Alert('用户名不能为空','error');
				return false ;
			}else if($("#passwd").val() == ''){
				BUI.Message.Alert('密码不能为空','error');
				return false ;
			}
		});

});