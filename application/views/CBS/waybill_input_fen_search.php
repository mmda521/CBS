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
 <form action="<?php echo site_url("waybill/ajax_data_hbl_export");?>" method="post">
   <table class="table table-bordered table-hover" id="a">
             <tr> 
                  <td class="tableleft">总运单号</td>
                  <td><input type="text" name="MBL" id="MBL"/></td>	
                 <td class="tableleft">批次号</td>
                  <td><input type="text" name="BATCHNO" id="BATCHNO"/></td>					 
				 <td class="tableleft">分运单号</td>
                  <td><input type="text" name="HBL" id="HBL" value=""/></td>
				 			 
				  
		   </tr>
           <tr>
		          <td class="tableleft">主要货物名称</td>
                  <td><input type="text" name="GOODS_NAME_IMPORT" id="GOODS_NAME_IMPORT" value=""/></td>
                  <td class="tableleft">客户</td>
                  <td><select id="CUSTOMER_CODE" name="CUSTOMER_CODE">
			      <option value="">快递公司</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');					
                    foreach($query->result_array() as $row){
                        if($row['CUSTOMER_NAME']){?>
                            <option value="<?php echo $row['CUSTOMER_CODE'];?>"><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php } }?>
                </select> </td>
				     
				  <td class="tableleft">电商企业名称</td>
                  <td><input type="text" name="E_BUSINESS" id="E_BUSINESS" value=""/></td>							  
		         
           </tr>
            <tr>		         			 
			 <td class="tableleft">申报时间</td>
                  <td colspan="5"><input readonly type="text" name="STA_DATE" id="STA_DATE" class="calendar" value=""/><span>&nbsp;--&nbsp;</span>
                 <input readonly type="text" name="END_DATE" id="END_DATE" class="calendar" value=""/></td>	 	 				  
           </tr>				   
             <tr> 
			  <td></td>	
              <td></td>				  
			  <td colspan="6"><button type="button" class="btn btn-primary" id="btnSave" onclick="common_request(1)">查询</button>&nbsp;&nbsp;
			  <button type="reset" class="btn btn-primary" id="res" >重置</button>
			  
			  </td>
			 </tr>
			 <a class="btn btn-success" href="javascript:void(0);" onclick="add_()" title="新增分单信息">新增</a><a class="btn btn-success" name="success" href="javascript:void(0);" onclick="del()" title="删除分单信息">删除</a><button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
	 </table>
	</form>
 <table class="table table-bordered table-hover definewidth" style="width:2000px;" >
    <thead>
    <tr>
	   <th><input type="checkbox" id="selAll" onclick="selectAll()"/></th>
	    <th>编辑</th>
	    <th>总运单号</th>
		<th>批次号</th>
        <th>分运单号</th>
        <th>英文货物名称</th>
        <th>主要货物名称</th>
        <th>件数</th>
        <th>重量（公斤）</th>
        <th>价值</th>
        <th>币制</th>
		<th>申报时间</th>
        <th>创建时间</th>
        <th>创建人</th>
        <th>收件人</th>
        <th>发件人</th>
        <th>监管场所海关备案编码</th>
        <th>物流企业检验检疫备案编号CIQ</th>
		<th>客户</th>
        <th>物流企业海关备案编号</th>
        <th>电商企业名称</th>	
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
  var url="<?php echo site_url("waybill/ajax_data_search");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
	'BATCHNO':$("#BATCHNO").val(),
	'HBL':$("#HBL").val(),
	'GOODS_NAME_IMPORT':$("#GOODS_NAME_IMPORT").val(),
    'STA_DATE':$("#STA_DATE").val(),
	'END_DATE':$("#END_DATE").val(),
    'CUSTOMER_CODE':$("#CUSTOMER_CODE").val(),
	'E_BUSINESS':$("#E_BUSINESS").val()
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
        BUI.Message.Alert(msg.resultinfo.errmsg,'error');
        return false ;        
      }else{        
         for(var i in list){
          shtml+='<tr>';
		  shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"></td>';  
		   shtml+='<td><a href="javascript:void(0)" onclick=\'edit(\"'+list[i].GUID+'\")\' class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';		 	  
		  shtml+='<td>'+list[i]['MBL']+'</td>';
		  shtml+='<td>'+list[i]['BATCHNO']+'</td>';
          shtml+='<td>'+list[i]['HBL']+'</td>';
          shtml+='<td>'+list[i]['GOODS_NAME_EN']+'</td>';
          shtml+='<td>'+list[i]['GOODS_NAME_IMPORT']+'</td>';
          shtml+='<td>'+list[i]['NUM']+'</td>';
          shtml+='<td>'+list[i]['WEIGHT']+'</td>';
          shtml+='<td>'+list[i]['PRICE']+'</td>';
		  shtml+='<td>'+list[i]['CURRENCY']+'</td>';
          shtml+='<td>'+list[i]['APP_DATE']+'</td>';
          shtml+='<td>'+list[i]['CREATE_DATE']+'</td>';
          shtml+='<td>'+list[i]['CREATE_USER']+'</td>';
          shtml+='<td>'+list[i]['RECV_USER']+'</td>';
          shtml+='<td>'+list[i]['SEND_USER']+'</td>';
		   shtml+='<td>'+list[i]['APPLIEDCOMPANY']+'</td>';
          shtml+='<td>'+list[i]['TRANSFERCOMPANYCIQ']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMER_CODE']+'</td>';   
          shtml+='<td>'+list[i]['GOODSNO']+'</td>';
          shtml+='<td>'+list[i]['E_BUSINESS']+'</td>'; 		  
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


	  //添加子类
  //_typeid 分类ID
  //_id 父级ID
  function add_(){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加分单信息",
       width:800,
      height:350,
      loader : {
        url : '<?php echo site_url('waybill/add_fen_fen');?>',
        autoLoad : false, //不自动加载
        params : {"showpage":"1"},//附加的参数
        lazyLoad : true //不延迟加载
      },
      mask:true,//遮罩层是否开启
      closeAction : 'destroy',
      success:function(){
       submit_add(); //添加处理
       this.close();
		 
      }
    });
    dialog.show();
    dialog.get('loader').load();
  }
   
  function submit_add(){
    var data_ = $("#myform").serializeArray();
    //data_={'MBL':$("#MBL").val()};
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('waybill/doadd_fen_fen');?>?inajax=1" ,
      data: data_,
      cache:false,
      dataType:"json",
      async:false,
      success: function(msg){
		   var shtml = '';
		    var list = msg.resultinfo.list;
        if(msg.resultcode<0){
          BUI.Message.Alert('没有权限执行此操作','error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
          return false ;
        }else{
			BUI.Message.Alert("添加信息成功",'success');
          common_request(1); 
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
        }
      }

    });
  }
	
function del(){
        var selectCount = 0;
        var data = [] ;
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
                url: "<?php echo site_url('waybill/delete_hbl');?>" ,
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
                        return false ;
                    }else{
                        BUI.Message.Alert('删除成功！');
						common_request(1);
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
		
	
	 function edit(GUID){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"编辑分单信息",
      width:700,
      height:330,
      loader : {
        url : '<?php echo site_url("waybill/waybill_input_fen_fen_edit");?>',
        autoLoad : false, //不自动加载
        params : {"showpage":"1"},//附加的参数
        lazyLoad : true //不延迟加载
      },
      mask:true,//遮罩层是否开启
      closeAction : 'destroy',
      success:function(){
        submit_edit(GUID); //编辑级别分类处理
        this.close();
      }
    });
    dialog.show();
    dialog.get('loader').load({"GUID":GUID});
  }
  function submit_edit(GUID){
    var data_ = $("#edit_form").serializeArray();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('waybill/do_waybill_input_fen_fen_edit');?>?inajax=1",
      data: data_,
      cache:false,
      dataType:"json",
      async:false,
      success: function(msg){
		  var shtml = '' ;
         var list = msg.resultinfo.list;
        if(msg.resultcode<0){
          BUI.Message.Alert('没有权限执行此操作','error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
          return false ;
        }else{
			GUID=GUID;
        BUI.Message.Alert('编辑成功！');
         common_request(1);
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
        }
      }

    });

  }


function ajax_data(page){
  common_request(page); 
}

</script>