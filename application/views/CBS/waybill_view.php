<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}//为了防止跨站攻击，直接通过访问文件路径用的
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
 <form action="<?php echo site_url("waybill/ajax_data_mbl_export");?>" method="post">
   <table class="table table-bordered table-hover" id="a">
             <tr>    
				 <td class="tableleft">总运单号</td>
                  <td><input type="text" name="MBL" id="MBL" value=""/></td>
				   <td class="tableleft">航次航班号</td>
                  <td><input type="text" name="FLIGHT_NO" id="FLIGHT_NO" value=""/></td>				 
				   <td class="tableleft">进出口标志</td>
					<td>						
						 <select id="I_E_FLAG">
							<option value="">请选择</option>
							<option value="I">进口</option>
							<option value="E">出口</option>
						  </select>
					</td>
		   </tr>
           <tr>
		          <td class="tableleft">申报时间</td>
                  <td><input readonly type="text" name="STA_DATE" id="STA_DATE" class="calendar" value=""/>&nbsp;--
                
                  <input readonly type="text" name="END_DATE" id="END_DATE" class="calendar" value=""/></td>
				   <td class="tableleft">运输方式</td>
                  <td colspan="3">
				   <select id="TRANS_MODE" name="TRANS_MODE">
                          <option value="">运输方式</option>
                          <option value="0">非保税区</option>
                          <option value="1">监管仓库</option>
						  <option value="2">水路运输</option>
                          <option value="3">铁路运输</option>
						  <option value="4">公路运输</option>
						  <option value="5">航空运输</option>
                          <option value="6">邮件运输</option>
						  <option value="7">保税区</option>
                          <option value="8">保税仓库</option>
						  <option value="9">其它运输</option>
                   </select>
				  </td>
           </tr>						   
             <tr> 
			  <td></td>	
              <td></td>				  
			  <td colspan="6"><button type="button" class="btn btn-primary" id="btnSave" onclick="common_request(1)">查询</button>&nbsp;&nbsp;
			  <button type="reset" class="btn btn-primary" id="res" >重置</button>
			  
			  </td>
			 </tr>
			  <a class="btn btn-success" id="addnew0" href="<?php echo site_url("waybill/index");?>">新增<span class="glyphicon glyphicon-plus"></span></a><a class="btn btn-success" href="javascript:void(0);" onclick="del()" title="删除总单信息">删除</a> <button type="submit" class="btn btn-success" >导出</button>			  
   </table>
   </form>
 <table class="table table-bordered table-hover definewidth" style="width:2000px;" >
    <thead>
    <tr>
	    <th><input type="checkbox" id="selAll" onclick="selectAll()"/></th>
	   <!-- <th>删除</th> -->
		<th>编辑</th>
        <th>总运单号</th>
        <th>航次航班号</th>
        <th>进出口标志</th>
        <th>中文运输工具</th>
        <th>英文运输工具</th>
        <th>总件数</th>
		<th>总重量（公斤）</th>
        <th>运输方式</th>
        <th>进港日期</th>
        <th>进出口口岸</th>
        <th>起运港/抵运地</th>
        <th>分运单份数</th>
        <th>申报时间</th>
		<th>创建人</th>
		<th>创建时间</th>
		<th>申报企业检验检疫备案编号CIQ</th>
        <th>申报地检验检疫代码</th>
        <th>托运货物包装种类代码</th>	
		<th>托运货物包装种类代码CIQ</th>
		 
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
    $(function (){
        common_request(1);
    });
function common_request(page){
  var url="<?php echo site_url("waybill/ajax_data");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
	'FLIGHT_NO':$("#FLIGHT_NO").val(),
    'I_E_FLAG':$("#I_E_FLAG").val(),
	'TRANS_MODE':$("#TRANS_MODE").val(),
    'STA_DATE':$("#STA_DATE").val(),
	'END_DATE':$("#END_DATE").val(),
    'CREATE_COMPANY':$("#CREATE_COMPANY").val()
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
		  shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"></td>';  
          //shtml+='<td><a href="javascript:void(0)" onclick=\'delete_mbl(\"'+list[i].GUID+'\")\' class="icon-remove" title="删除'+list[i]['GUID']+'的基本信息"></a></td>';
          shtml+='<td><a  href="<?php echo site_url("waybill/waybill_edit");?>?GUID='+list[i]['GUID']+'" class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';		 		  		           
		  shtml+='<td>'+list[i]['MBL']+'</td>';
          shtml+='<td>'+list[i]['FLIGHT_NO']+'</td>';
          shtml+='<td>'+list[i]['I_E_FLAG']+'</td>';
          shtml+='<td>'+list[i]['TRANS_TOOL_CN']+'</td>';
          shtml+='<td>'+list[i]['TRANS_TOOL_EN']+'</td>';
          shtml+='<td>'+list[i]['NUM']+'</td>';
		  shtml+='<td>'+list[i]['WEIGHT']+'</td>';
          shtml+='<td>'+list[i]['TRANS_MODE']+'</td>';
          shtml+='<td>'+list[i]['IN_DATE']+'</td>';
          shtml+='<td>'+list[i]['PORT']+'</td>';
          shtml+='<td>'+list[i]['PORT_SHIP_DEST']+'</td>';
          shtml+='<td>'+list[i]['HBL_NUM']+'</td>';
		  shtml+='<td>'+list[i]['APP_DATE']+'</td>';
		  shtml+='<td>'+list[i]['CREATE_USER']+'</td>';
		  shtml+='<td>'+list[i]['CREATE_DATE']+'</td>';
          shtml+='<td>'+list[i]['APPLIEDCOMPANYCIQ']+'</td>';
          shtml+='<td>'+list[i]['APPLIEDCUSTOMSINSP']+'</td>';
          shtml+='<td>'+list[i]['GOODSPACKTYPE']+'</td>';
          shtml+='<td>'+list[i]['GOODSPACKTYPEINSP']+'</td>';
         // shtml+='<td><a href="<?php echo site_url('waybill/waybill_input_edit');?>?id='+list[i]['GUID']+'" class="icon-edit" title="编辑'+list[i]['GUID']+'的基本信息"></a></td>';
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
         BUI.Message.Alert("服务器繁忙aa",'error');
       }
      
    });   
}



//删除操作
function delete_mbl(GUID){
  var url="<?php echo site_url("waybill/delete_mbl");?>?inajax=1";
  var data_ = {
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'GUID':GUID,
  } ;
   BUI.Message.Confirm('删除后不可恢复,是否确定删除操作',function(){
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
        BUI.Message.Alert('删除成功！');
        common_request(1); 
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
      }
       },
       beforeSend:function(){
        $("#result_").html('<font color="red"><img src="<?php echo base_url();?>webroot/CBS_Platform/Images/progressbar_microsoft.gif"></font>');
       },
       error:function(){
         BUI.Message.Alert("服务器繁忙aa",'error');
       }
      
    }); 
  },'question');

}


//删除操作
 function del(){
        var selectCount = 0;
        var data = [];
        var o = select_data() ;
        selectCount = o.selectCount ;
        data = o.data ;
        if(selectCount == 0 ){
            BUI.Message.Alert('请选择数据进行删除','error');
            return false ;
        }
        BUI.Message.Confirm('删除后不可恢复,是否确定删除操作',function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('waybill/delete_mbl_mbl');?>" ,
                data: {"GUID":data},
                cache:false,
                dataType:"json",
                //  async:false,
                success: function(msg){
					var shtml = '';
		            var list = msg.resultinfo.list;
                    if(msg.resultcode<0){
                        BUI.Message.Alert('没有权限执行此操作','error');
                        return false ;
                    }else if(msg.resultcode == 0 ){
                        BUI.Message.Alert(msg.resultinfo.errmsg ,'error');                     
                        return false ;
                    }else{
						 BUI.Message.Alert('删除成功！');
                         common_request(1); 
					$("#result_").html(shtml);        
					$("#page_string").html(msg.resultinfo.obj);
                    }
                },
                beforeSend:function(){
                    $("#result_").html('<font color="red"><img src="<?php echo base_url();?>webroot/CBS_Platform/Images/progressbar_microsoft.gif"></font>');
                },
                error:function(){
                    BUI.Message.Alert('服务器繁忙请稍后','error');
                }

            });
        },'question');

    }
    function select_data(){
        var obj=document.getElementsByName("checkAll[]");
        var count = obj.length;
        var selectCount = 0;
        var data = [] ;
        for(var i = 0; i < count; i++)
        {
            if(obj[i].checked == true)
            {
                selectCount++;
                data.push(obj[i].value);
            }
        }
        var o = {
            'selectCount':selectCount ,
            'data':data
        } ;
        return o ;
    }


	
  function ajax_data(page){
  common_request(page); 
}
</script>