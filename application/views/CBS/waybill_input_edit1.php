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

<form  class="definewidth m2"  name="edit_form" id="edit_form" style="height:330px ; overflow:auto">
<input type="hidden" name="action" value="doadd">
<table class="table table-bordered table-hover m10">

    <tr>
        <td class="tableleft"><span>*</span>总运单号</td>
        <td><input type="text" name="MBL" id="MBL" value="<?php if(isset($info[0]['MBL'])) echo $info[0]['MBL']; ?>"  /></td>
   
        <td class="tableleft"><span>*</span>航次航班号</td>
        <td><input type="text" name="FLIGHT_NO" id="FLIGHT_NO" value="<?php if(isset($info[0]['FLIGHT_NO'])) echo $info[0]['FLIGHT_NO']; ?>" /></td>
    </tr> 
    <tr>
        <td class="tableleft"><span>*</span>进出口标志</td>
        <td>
		  <select id="I_E_FLAG" name="I_E_FLAG">
			<option value="I" <?php $selected='selected=selected'; if(isset($info[0]['I_E_FLAG'])&&($info[0]['I_E_FLAG']=='I')) echo $selected;?>>进口</option>
			<option value="E" <?php $selected='selected=selected'; if(isset($info[0]['I_E_FLAG'])&&($info[0]['I_E_FLAG']=='E')) echo $selected;?>>出口</option>
		    </select> 
		</td>
    
        <td class="tableleft">中文运输工具</td>
        <td><input type="text" name="TRANS_TOOL_CN" id="TRANS_TOOL_CN" value="<?php if(isset($info[0]['TRANS_TOOL_CN'])) echo $info[0]['TRANS_TOOL_CN']; ?>" /></td>
    </tr>
	 <tr>
        <td class="tableleft">英文运输工具</td>
        <td><input type="text" name="TRANS_TOOL_EN" id="TRANS_TOOL_EN" value="<?php if(isset($info[0]['TRANS_TOOL_EN'])) echo $info[0]['TRANS_TOOL_EN']; ?>"  /></td>
   
        <td class="tableleft">总件数</td>
        <td><input type="text" name="NUM" id="NUM" value="<?php if(isset($info[0]['NUM'])) echo $info[0]['NUM']; ?>" /></td>
    </tr> 
    <tr>
        <td class="tableleft">总重量（公斤）</td>
        <td><input type="text" name="WEIGHT" id="WEIGHT" value="<?php if(isset($info[0]['WEIGHT'])) echo $info[0]['WEIGHT']; ?>"/></td>
   
        <td class="tableleft">运输方式</td>
        <td>
		 <select id="TRANS_MODE" name="TRANS_MODE">
		    <option value="">运输方式</option>
			<option value="0" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='0')) echo $selected;?>>非保税区</option>
			<option value="1" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='1')) echo $selected;?>>监管仓库</option>
		    <option value="2" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='2')) echo $selected;?>>水路运输</option>
			<option value="3" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='3')) echo $selected;?>>铁路运输</option>
		   <option value="4" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='4')) echo $selected;?>>公路运输</option>
			<option value="5" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='5')) echo $selected;?>>航空运输</option>
		   <option value="6" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='6')) echo $selected;?>>邮件运输</option>
			<option value="7" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='7')) echo $selected;?>>保税区</option>
		   <option value="8" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='8')) echo $selected;?>>保税仓库</option>
			<option value="9" <?php $selected='selected=selected'; if(isset($info[0]['TRANS_MODE'])&&($info[0]['TRANS_MODE']=='9')) echo $selected;?>>其它运输</option>
		   
			</select> 
		</td>
    </tr>
	 <tr>
        <td class="tableleft"><span>*</span>进港日期</td>
        <td><input readonly type="text" name="IN_DATE" id="IN_DATE" class="calendar" value="<?php if(isset($info[0]['IN_DATE'])) echo $info[0]['IN_DATE']; ?>" /></td>
   
        <td class="tableleft"><span>*</span>进出口口岸</td>
        <td><input type="text" name="PORT" id="PORT" value="<?php if(isset($info[0]['PORT'])) echo $info[0]['PORT']; ?>" /></td>
    </tr> 
    <tr>
        <td class="tableleft">起运港/抵运地</td>
        <td><input type="text" name="PORT_SHIP_DEST" id="PORT_SHIP_DEST" value="<?php if(isset($info[0]['PORT_SHIP_DEST'])) echo $info[0]['PORT_SHIP_DEST']; ?>"/></td>
   
        <td class="tableleft">分运单份数</td>
        <td><input type="text" name="HBL_NUM" id="HBL_NUM" value="<?php if(isset($info[0]['HBL_NUM'])) echo $info[0]['HBL_NUM']; ?>" /></td>
    </tr>
    <tr>
        <td class="tableleft"><span>*</span>申报时间</td>
        <td><input readonly type="text" name="APP_DATE" id="APP_DATE" class="calendar" value="<?php if(isset($info[0]['APP_DATE'])) echo $info[0]['APP_DATE']; ?>"/></td>
    
        <td class="tableleft">创建人</td>
        <td><input type="text" name="CREATE_USER" id="CREATE_USER" value="<?php if(isset($info[0]['CREATE_USER'])) echo $info[0]['CREATE_USER']; ?>" /></td>
    </tr> 
    <tr>
        <td class="tableleft"><span>*</span>申报企业检验检疫备案编号CIQ</td>
        <td><input type="text" name="APPLIEDCOMPANYCIQ" id="APPLIEDCOMPANYCIQ" value="<?php if(isset($info[0]['APPLIEDCOMPANYCIQ'])) echo $info[0]['APPLIEDCOMPANYCIQ']; ?>"/></td>
    
        <td class="tableleft"><span>*</span>申报地检验检疫代码</td>
        <td><input type="text" name="APPLIEDCUSTOMSINSP" id="APPLIEDCUSTOMSINSP" value="<?php if(isset($info[0]['APPLIEDCUSTOMSINSP'])) echo $info[0]['APPLIEDCUSTOMSINSP']; ?>" /></td>
    </tr>
	  <tr>
        <td class="tableleft">托运货物包装种类代码</td>
        <td><input type="text" name="GOODSPACKTYPE" id="GOODSPACKTYPE" value="<?php if(isset($info[0]['GOODSPACKTYPE'])) echo $info[0]['GOODSPACKTYPE']; ?>"/></td>
   
        <td class="tableleft"><span>*</span>托运货物包装种类代码CIQ</td>
        <td><input type="text" name="GOODSPACKTYPEINSP" id="GOODSPACKTYPEINSP" value="<?php if(isset($info[0]['GOODSPACKTYPEINSP'])) echo $info[0]['GOODSPACKTYPEINSP']; ?>" /></td>
    </tr>
       
        <input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/> 
   
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

 