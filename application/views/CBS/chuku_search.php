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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" />   
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
   <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/admin.js"></script>   
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
 <form action="<?php echo site_url("chuku/ajax_data_export");?>" method="post">
 <button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
  <table class="table table-bordered table-hover">
             <tr>    
				 <td class="tableleft">单证号</td>
                  <td><input type="text" name="TOTALTRANSFERNO" id="TOTALTRANSFERNO"/></td>
				   <td class="tableleft">物流企业备案编码</td>
                  <td><input type="text" name="LOGISTICSCODE" id="LOGISTICSCODE"/></td>
				   <td class="tableleft">审核状态</td>
                  <td><input type="text" name="STATUS" id="STATUS"/></td>  			  
              </tr>	
               <tr> 	
                  <td class="tableleft">海关编码</td>
                  <td><input type="text" name="CUSTOMSCODE" id="CUSTOMSCODE"/></td>
                   <td class="tableleft">审核日期</td>
                  <td><input type="text" name="STA_DATE" id="STA_DATE" class="calendar" value=""/></td>
                 <td class="tableleft">至</td>
                  <td><input type="text" name="END_DATE" id="END_DATE" class="calendar" value=""/></td>					  
               </tr>
			
				 <tr>  
				 <td colspan="2"></td>
			   <td colspan="4"><button type="button" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp;			   
			   <button type="reset" class="btn btn-primary" id="res">重置</button>
			   </td> 		   
			   </tr>

 </table>
</form>
<table class="table table-bordered table-hover definewidth">
    <thead>
    <tr>
        <th>单证号</th>
        <th>物流企业备案编码</th>
        <th>审核状态</th>
        <th>海关编码</th>
        <th>审核日期</th>
        <th>备注</th>    
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
  var url="<?php echo site_url("chuku/ajax_data");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'TOTALTRANSFERNO':$("#TOTALTRANSFERNO").val(),
    'LOGISTICSCODE':$("#LOGISTICSCODE").val(),
    'STATUS':$("#STATUS").val(),
	'CUSTOMSCODE':$("#CUSTOMSCODE").val(),
	'STA_DATE':$("#STA_DATE").val(),
	'END_DATE':$("#END_DATE").val()
  } ;
  $.ajax({
       type: "POST",
       url: url ,
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
          shtml+='<td>'+list[i]['TOTALTRANSFERNO']+'</td>';
          shtml+='<td>'+list[i]['LOGISTICSCODE']+'</td>';
          shtml+='<td>'+list[i]['STATUS']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMSCODE']+'</td>';
		  shtml+='<td>'+list[i]['BIZTIME']+'</td>';
		  shtml+='<td>'+list[i]['COMMENTS']+'</td>';
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
         BUI.Message.Alert("服务器繁忙aaa",'error');
       }
    });   
}
function ajax_data(page){
  common_request(page); 
}
</script>
