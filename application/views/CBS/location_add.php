<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE HTML>
<html>
 <head>
  <title> 搜索表单</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<form  class="definewidth m2"  name="add_form" id="add_form" style="height:330px ; overflow:auto">
<input type="hidden" name="action" value="doadd">
<table class="table table-bordered table-hover m10">

    <tr>	    
        <td class="tableleft"><span>*</span>检索号</td>
        <td><input type="text" name="index_no" id="index_no" /></td>
    </tr>
    <tr>
        <td class="tableleft"><span>*</span>库位号</td>
        <td><input type="text" name="goodssite_no" id="goodssite_no" /></td>
    </tr> 
	 <tr>
        <td class="tableleft"><span>*</span>启用状态</td>
        <td>
            <input type="radio" name="status" value="Y" checked/> 启用
            <input type="radio" name="status" value="N"/> 停用
			<input type="radio" name="status" value="YN"/> 忽略
        </td>
    </tr>    		
    <tr>
        <td class="tableleft" >库位说明</td>
        <td><input type="text" name="goodssite_note" id="goodssite_note" style="width:400px; height:60px;"/></td>
    </tr>
    
</table>
</form>
</body>
</html>  

