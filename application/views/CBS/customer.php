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
	<link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/admin.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script> 	
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/validate/validator.js"></script>
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
  <form action="<?php echo site_url("customer/ajax_data_export");?>" method="post">
 <table class="table table-bordered table-hover" >
             <tr>    
				 <td class="tableleft">检索号</td>
                  <td><input type="text" name="index_no" id="index_no"/></td>
				   <td class="tableleft">客户编码</td>
				   <td><select id="customer_code" name="customer_code">
			      <option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
					
                    foreach($query->result_array() as $row){
                        if($row['CUSTOMER_CODE']){?>
                            <option><?php echo $row['CUSTOMER_CODE'];?></option>
                        <?php } }?>
                </select> </td>			   
				   <td class="tableleft">客户名称</td>                   
                   <td><select id="customer_name" name="customer_name">
			      <option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
					
                    foreach($query->result_array() as $row){
                        if($row['CUSTOMER_NAME']){?>
                            <option><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php } }?>
                </select> </td>			   
              </tr>	
               <tr> 	
                  <td class="tableleft">客户简称</td>
               <td><select id="customer_sname" name="customer_sname">
			      <option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
					
                    foreach($query->result_array() as $row){
                        if($row['CUSTOMER_SNAME']){?>
                            <option><?php echo $row['CUSTOMER_SNAME'];?></option>
                        <?php } }?>
                </select> </td>							  
				   <td class="tableleft">客户类型</td>
                  <td>
                      <select id="customer_type" name="customer_type">
                          <option value="">全部</option>
                          <option value="1">快递公司</option>
                      </select>
                  </td>
				   <td class="tableleft">税务登记号</td>
                  <td><input type="text" name="tax_registid" id="tax_registid"/></td> 
               </tr>
			   <tr>
			     <td class="tableleft">企业海关备案编号</td>
                  <td colspan="5"><input type="text" name="linenoindex" id="linenoindex"/></td>
			  	  </tr>
				 <tr>  
				 <td colspan="2"></td>
			   <td colspan="4"><button type="button" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp;			   
			   <button type="reset" class="btn btn-primary" id="res">重置</button>
			   </td> 	   
			   </tr>
			   	 <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="add_()" title="新增客户信息">新增</a><a class="btn btn-success" name="success" href="javascript:void(0);" onclick="del()" title="删除客户信息">删除</a><button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
 </table>
</form>
<table class="table table-bordered table-hover definewidth" >
    <thead>
    <tr>
	    <th><input type="checkbox" id="selAll" onclick="selectAll()"/></th>
		 <th>编辑</th>  
        <th>检索号</th>
       <th>客户编号</th>
        <th>客户名称</th>
        <th>客户简称</th>
       <!-- <th>英文名称</th>-->
     <!--   <th>客户类型</th>
        <th>业务负责人</th>
		<th>取货地址</th>
        <th>发票抬头</th>
        <th>发票地址</th>
        <th>银行账号</th>
        <th>税务登记号</th>
        <th>业务单位</th>
        <th>注册名称</th>
		<th>注册地址</th>
        <th>邮政编码</th>
        <th>网站</th>
        <th>法人</th>
        <th>注册资金</th>
        <th>电话</th>
        <th>传真</th>
		<th>备注</th>
        <th>操作人员</th>-->
		<th>操作时间</th>
        <th>状态</th>
       <!-- <th>卸货地址码</th>-->
        <th>企业海关备案编号</th>
            
    </tr>
    </thead>
  <tbody id="result_">
  </tbody> 
 
  </table>
   <div id="page_string"  style="float:right;">
  </div> 
</body>
</html>  
<script>
$(function () {
  common_request(1);
});
$(document).ready(function(){
	
		//重置
		$("#res").click(function(){
			
			$("table :input").val('');

			});
			//end
		});	
function common_request(page){
  var url="<?php echo site_url("customer/ajax_data");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'index_no':$("#index_no").val(),
    'customer_code':$("#customer_code").val(),
    'customer_name':$("#customer_name").val(),
	'customer_sname':$("#customer_sname").val(),
	'customer_type':$("#customer_type").val(),
	'tax_registid':$("#tax_registid").val(),
	'linenoindex':$("#linenoindex").val()    
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
		  shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"/></td>';
          shtml+='<td><a href="javascript:void(0)" name="success" onclick=\'edit(\"'+list[i].GUID+'\")\' class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';
		 shtml+='<td>'+list[i]['INDEX_NO']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMER_CODE']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMER_NAME']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMER_SNAME']+'</td>';
		 /* shtml+='<td>'+list[i]['CUSTOMER_ENGLISH']+'</td>';
          shtml+='<td>'+list[i]['CUSTOMER_TYPE']+'</td>';
		  shtml+='<td>'+list[i]['BUSINESS_USER']+'</td>';
		  shtml+='<td>'+list[i]['PICKUP_ADDR']+'</td>';
		  shtml+='<td>'+list[i]['INVOICE_NAME']+'</td>';
		  shtml+='<td>'+list[i]['INVOICE_ADDR']+'</td>';
		  shtml+='<td>'+list[i]['BANK_ACCOUNT']+'</td>';
		  shtml+='<td>'+list[i]['TAX_REGISTID']+'</td>';
		  shtml+='<td>'+list[i]['BUSINESS_ID']+'</td>';
		  shtml+='<td>'+list[i]['COMPANY_NAME']+'</td>';
		  shtml+='<td>'+list[i]['COMPANY_ADDR']+'</td>';
		  shtml+='<td>'+list[i]['POSTCODE']+'</td>';
		  shtml+='<td>'+list[i]['URL']+'</td>';
		  shtml+='<td>'+list[i]['LAWER']+'</td>';
		  shtml+='<td>'+list[i]['REGISTERED_FUND']+'</td>';
		  shtml+='<td>'+list[i]['TEL']+'</td>';
		  shtml+='<td>'+list[i]['FAX']+'</td>';
		  shtml+='<td>'+list[i]['REMARK1']+'</td>';*/
		 // shtml+='<td>'+list[i]['OPERUSER_ID']+'</td>';
		  shtml+='<td>'+list[i]['OPERDATE']+'</td>';
		  shtml+='<td>'+list[i]['STATUS']+'</td>';
		 // shtml+='<td>'+list[i]['DISCHARGE_PLACE']+'</td>';
		  shtml+='<td>'+list[i]['LINENOINDEX']+'</td>';
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

 function add_(){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加客户信息",
      width:850,
      height:400,
      loader : {
        url : '<?php echo site_url('customer/add');?>',
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
    var data_ = $("#add_form").serializeArray();
    //data_={'MBL':$("#MBL").val()};
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('customer/doadd');?>?inajax=1" ,
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

  function edit(GUID){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"编辑客户信息",
       width:850,
      height:400,
      loader : {
        url : '<?php echo site_url("customer/edit");?>',
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
      url: "<?php echo site_url('customer/do_edit');?>?inajax=1",
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
			
        BUI.Message.Alert('编辑成功！');
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
</script>
