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
  <form action="<?php echo site_url("order/ajax_data_cus_export");?>" method="post">
 <button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
  <table class="table table-bordered table-hover">
             <tr>    
				  <td class="tableleft">批次号</td>
                  <td><input type="text" name="BATCHNO" id="BATCHNO"/></td>
				   <td class="tableleft">分运单号</td>
                  <td><input type="text" name="HBL" id="HBL"/></td>
				   <td class="tableleft">物流企业代码</td>
                  <td><input type="text" name="LOGISTICSCODE" id="LOGISTICSCODE"/></td>
				   
              </tr>	
               <tr> 	
                  <td class="tableleft">时间</td>
                  <td ><input readonly type="text" name="STA_DATE" id="STA_DATE" class="calendar" value=""/><span>&nbsp;--&nbsp;</span><input readonly type="text" name="END_DATE" id="END_DATE" class="calendar" value=""/></td>			  				  
                   <td class="tableleft">状态</td>
                  <td colspan="5">
                      <select id="DISCHARGED_TYPE" >
                            <option value="">全部</option>                           
                            <option value="4">检验人工审单</option>	
							<option value="11">检验重新申报</option>	
							<option value="1">检验放行</option>	
							<option value="10">检验查验</option>
							<option value="8">检验禁止出境</option>							
                      </select>
                  </td>		  
				 </tr>			 
				 <tr>  
				 <td colspan="2"></td>
			   <td colspan="6"><button type="button" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp;			   
			   <button type="reset" class="btn btn-primary" id="res">重置</button>
			   </td>               		   
			   </tr>
 </table>
  </form>
<table class="table table-bordered table-hover definewidth">
    <thead>
    <tr>
        <th>批次号</th>
        <th>分运单号</th>
		<th>物流企业代码</th>
        <th>状态</th>
        <th>时间</th>
        <th>联检单位</th>
    </tr>
    </thead>
  <tbody id="result_">
  </tbody>  
  
  </table>
  <div id="page_string" style="float:right;">
  
  </div> 

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
$(document).ready(function(){
	
		//重置
		$("#res").click(function(){
			
			$("table :input").val('');

			});
			//end
		});	
$(function () {
  common_request(1);
});
function common_request(page){
  var url="<?php echo site_url("order/ajax_data_insp");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'BATCHNO':$("#BATCHNO").val(),
	'HBL':$("#HBL").val(),
	'LOGISTICSCODE':$("#LOGISTICSCODE").val(),
    'DISCHARGED_TYPE':$("#DISCHARGED_TYPE").val(),
    'STA_DATE':$("#STA_DATE").val(),
    'END_DATE':$("#END_DATE").val()
  } ;
  $.ajax({
       type: "POST",
       url: url,
       data: data_,
       cache:false,
       dataType:"json",
     //  async:false,
       success: function(msg){
      var shtml = '' ;
      var list = msg.resultinfo.list;
      if(msg.resultcode<0){
        BUI.Message.Alert("没有权限执行此操作",'error');
        return false ;
      }else if(msg.resultcode == 0 ){
        BUI.Message.Alert("服务器繁忙",'error');
        return false ;        
      }else{        
        for(var i in list){
          shtml+='<tr>';
          shtml+='<td>'+list[i]['BATCHNO']+'</td>';
          shtml+='<td>'+list[i]['HBL']+'</td>';
		  shtml+='<td>'+list[i]['LOGISTICSCODE']+'</td>';
          shtml+='<td>'+list[i]['DISCHARGED_TYPE']+'</td>';
          shtml+='<td>'+list[i]['DISCHARGED_DATE']+'</td>';
          shtml+='<td>'+list[i]['PASS_TYPE']+'</td>';
          shtml+='</tr>';
        }
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
      }
       },
       beforeSend:function(){
        $("#result_").html('<font color="red"><img src="<?php echo base_url();?>webroot/CBS_Platform/Images/progressbar_microsoft.gif"></font>');
       },
       error:function(){
         BUI.Message.Alert("服务器繁忙",'error');
       }
      
    });   
}
function ajax_data(page){
  common_request(page); 
}

</script>
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>