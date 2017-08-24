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

<form action="#" method="post" class="definewidth m2"  name="edit_form" id="edit_form" style="height:330px ; overflow:auto">
<table class="table table-bordered table-hover m10">

    <tr>
        <td class="tableleft"><span>*</span>总单号</td>
        <td><input type="text" name="MBL" id="MBL" value="<?php if(isset($info[0]['MBL'])) echo $info[0]['MBL']; ?>"  /></td>
    </tr>
    <tr>
        <td class="tableleft"><span>*</span>批次号</td>
        <td><input type="text" name="BATCHNO" id="BATCHNO" value="<?php if(isset($info[0]['BATCHNO'])) echo $info[0]['BATCHNO']; ?>" /></td>
    </tr> 
	<!-- <tr>
        <td class="tableleft"><span>*</span>启用状态</td>
        <td>
             <select id="status" name="status">
			<option value="Y" <?php $selected='selected=selected'; if(isset($info[0]['STATUS'])&&($info[0]['STATUS']=='Y')) echo $selected;?>>启用</option>
			<option value="N" <?php $selected='selected=selected'; if(isset($info[0]['STATUS'])&&($info[0]['STATUS']=='N')) echo $selected;?>>停用</option>
		    </select> 
	   </td>
    </tr>   --> 
   
        <input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/>
    
      
</table>
</form>
</body>
</html>  


 