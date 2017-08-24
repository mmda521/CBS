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
 
 <h2>客户信息维护</h2>
  <table class="table table-bordered table-hover m10">
             <tr>    
				 <td class="tableleft">主运单号</td>
                  <td><input type="text" name="MBL" id="MBL"/></td>
				   <td class="tableleft">分运单号</td>
                  <td><input type="text" name="HBL" id="HBL"/></td>
				   <td class="tableleft">品名</td>
                  <td><input type="text" name="GOODS_CODE" id="GOODS_CODE"/></td>  			  
              </tr>	
               <tr> 	
                  <td class="tableleft">包装情况</td>
                  <td><input type="text" name="PACKING_CONDITION" id="PACKING_CONDITION"/></td>
                 <td class="tableleft">出库时间</td>
                  <td><input type="text" name="STA_DATE" id="STA_DATE" class="calendar" value=""/></td>
                 <td class="tableleft">至</td>
                  <td><input type="text" name="END_DATE" id="END_DATE" class="calendar" value=""/></td>				  
				  
               </tr>
			   <tr>
			     <td class="tableleft">客户</td>
                  <td>				  
					<!--<input type="radio" name="CUSTOMER_TYPE" value="1" checked/> 快递公司
					<input type="radio" name="CUSTOMER_TYPE" value="2"/> 其他-->
                      <select id="TRANS_COMPANY">
                          <option value="">快递公司</option>
                          <option value="4101986180">河南省圆通速递有限公司</option>
                          <option value="410198Z062">中国邮政速递</option>
						  <option value="4101985807">河南中通快递服务有限公司</option>
                          <option value="4101985823">申通快递</option>
						  <option value="4101986185">顺丰快递</option>
                      </select>
                  </td>
				   <td class="tableleft">电商企业名称</td>
                  <td colspan="4"><input type="text" name="OPERCOM_ID" id="OPERCOM_ID"/></td> 
			  	  </tr>
				 <tr>  
				 <td colspan="2"></td>
			   <td colspan="4"><button type="submit" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp;			   
			   <button type="reset" class="btn btn-primary" id="res">重置</button>
			   </td> 
               		   
			   </tr>

 </table>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
	    <th></th>
        <th>总运单号</th>
        <th>分运单号</th>
        <th>出库件数</th>
        <th>出库计重（KG）</th>
        <th>品名</th>
        <th>包装情况</th>
        <th>出库日期</th>
		<th>库位号</th>
        <th>客户</th>
        <th>电商企业名称</th>    
    </tr>
    </thead>
  <tbody id="result_">
  </tbody> 
 <tr>
            <td colspan="29">
                全选<input type="checkbox" id="selAll" onclick="selectAll()">
                反选:<input type="checkbox" id="inverse" onclick="inverse();">
                <button class="button button-small" type="button" onclick="del()">
                    <i class="icon-remove"></i>
                    删除
                </button>
            </td>
        </tr>  
  </table>
   <div id="page_string" class="form-inline definewidth m1" style="float:right ; text-align:right ; margin:-4px">
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
  var url="<?php echo site_url("outwarehouse/ajax_data");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
    'HBL':$("#HBL").val(),
    'GOODS_CODE':$("#GOODS_CODE").val(),
	'PACKING_CONDITION':$("#PACKING_CONDITION").val(),
	'STA_DATE':$("#STA_DATE").val(),
	'END_DATE':$("#END_DATE").val(),
	'TRANS_COMPANY':$("#TRANS_COMPANY").val(),   
	'OPERCOM_ID':$("#OPERCOM_ID").val()
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
		  shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"></td>';
          shtml+='<td>'+list[i]['MBL']+'</td>';
          shtml+='<td>'+list[i]['HBL']+'</td>';
          shtml+='<td>'+list[i]['IN_PIECES']+'</td>';
          shtml+='<td>'+list[i]['IN_CHARGE_WEIGHT']+'</td>';
		  shtml+='<td>'+list[i]['GOODS_CODE']+'</td>';
          shtml+='<td>'+list[i]['PACKING_CONDITION']+'</td>';
		  shtml+='<td>'+list[i]['IN_DATE']+'</td>';
		  shtml+='<td>'+list[i]['LOCATION_NO']+'</td>';
		  shtml+='<td>'+list[i]['TRANS_COMPANY']+'</td>';
		  shtml+='<td>'+list[i]['OPERCOM_ID']+'</td>';
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
    function del(){
        var selectCount = 0;
        var data = [] ;
        var o = select_data() ;
        selectCount = o.selectCount ;
        data = o.data ;
        if(selectCount == 0 ){
            BUI.Message.Alert('请选择进行删除','error');
            return false ;
        }
        BUI.Message.Confirm('此操作不可恢复,是否确定此操作',function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('customer/delete');?>" ,
                data: {"guid":data},
                cache:false,
                dataType:"json",
                //  async:false,
                success: function(msg){
                    if(msg.resultcode<0){
                        BUI.Message.Alert('没有权限执行此操作','error');
                        return false ;
                    }else if(msg.resultcode == 0 ){
                        BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
                        common_request();
                        return false ;
                    }else{
                        common_request();
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
</script>
