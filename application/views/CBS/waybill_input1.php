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
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/ajaxfileupload.js"></script>
	
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
		  .dialog1 {
            display: none;
            position: absolute;
            top: 20%;
            left: 20%;
            width: 40%;
            height: 30%;
            border: 2px solid lightblue;
            background-color: white;
            z-index: 1002;
		  overflow: auto;
		  }
		.black_overlay {
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            background-color:gray;
            z-index: 1001;
            -moz-opacity: 0.8;
            opacity: .80;
            filter: alpha(opacity=80);
        }
		.tanchuang{
			background-color:lightblue;
		}
   </style>
    <script type="text/javascript">
        //弹出隐藏层
        function ShowDiv(show_div, bg_div) {
            document.getElementById(show_div).style.display = 'block';  
            document.getElementById(bg_div).style.display = 'block';			
        };
        //关闭弹出层
        function CloseDiv(show_div, bg_div) {
            document.getElementById(show_div).style.display = 'none';
			document.getElementById(bg_div).style.display = 'none';
        };
		
$(function () {
     $('#close1').click(function(){
     $('#batch').css('display','none');
	  $('#fade').css('display','none');
     });
});		
$(function () {
     $('#close2').click(function(){
     $('#hbl').css('display','none');
	  $('#fade').css('display','none');
     });
});
</script>
<script language="javascript">
  jQuery(function(){   
      $("#buttonUpload1").click(function(){     
         //加载图标   
         /* $("#loading").ajaxStart(function(){
            $(this).show();
         }).ajaxComplete(function(){
            $(this).hide();
         });*/
          //上传文件
		   $("#batch").hide();
		   $("#fade").hide();
        $.ajaxFileUpload({
            url:'<?php echo site_url("import_batch/excel_put_batch");?>',//处理图片脚本			
            secureuri :false,
            fileElementId :'file1',//file控件id
            dataType : 'json',
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
       BUI.Message.Alert("导入成功",'success');
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
    })
   
 }) 
});

  jQuery(function(){   
      $("#buttonUpload2").click(function(){     
         //加载图标   
         /* $("#loading").ajaxStart(function(){
            $(this).show();
         }).ajaxComplete(function(){
            $(this).hide();
         });*/
          //上传文件
		   $("#hbl").hide();
		   $("#fade").hide();
        $.ajaxFileUpload({
            url:'<?php echo site_url('import_hbl/excel_put_hbl');?>',//处理图片脚本			
            secureuri :false,
            fileElementId :'file2',//file控件id
            dataType : 'json',
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
       BUI.Message.Alert("导入成功",'success');
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
    })
   
 }) 
});
</script>

 </head>
 <body>
    <a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/waybill_back");?>">返回</a> 
	<!--<a class="btn btn-success" id="addnew" href="<?php echo site_url("batch/index");?>">查看批次信息</a>-->
   <input id="import_batch" type="button"  class="btn btn-success" value="运单批次导入" onclick="ShowDiv('batch','fade')" />
    <div id="fade" class="black_overlay">
    </div>
	 <div id="batch" class="dialog1">
         <div style="height:25px;background-color:#5c9cfc;">
            <span style="font-size:15px; float:left;" >运单批次信息录入</span>
            <span style="font-size: 15px; float:right;cursor:pointer;" onclick="CloseDiv('batch','fade')">关闭</span>
        </div>
		<br/>
        &nbsp; &nbsp; <form id="form1" name="form1" action="#" method="post" style="display:inline;">   
		   <input id="file1" type="file" name="file1" /><input  type="button" class="tanchuang" value="导入" id="buttonUpload1"/> &nbsp; &nbsp; <input type="button" value="取消"  id="close1" class="tanchuang"/>        
	    </form>
    </div>
	 
	   <div id="hbl" class="dialog1">
        <div style="height:25px;background-color:#5c9cfc;">
            <span style="font-size:15px; float:left;" >运单分单信息录入</span>
            <span style="font-size: 15px; float:right;cursor:pointer;" onclick="CloseDiv('hbl','fade')">关闭</span>
        </div><br/>
        &nbsp; &nbsp;
         <form id="form2" name="form2" method="post" action="#" style="display:inline;">   
         <input id="file2" type="file" name="file2" /><input  type="button" value="导入" class="tanchuang" id="buttonUpload2"/>&nbsp; &nbsp; <input type="button" value="取消"  id="close2" class="tanchuang"/>        
         </form> 
    </div>
     <!-- <a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/waybill_input_add");?>">导出<span class="glyphicon glyphicon-plus"></span></a> &nbsp;&nbsp; -->  
<a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/ajax_data_batch_templet");?>">批次导入模板</a> 
 
 <form  id="baseForm" name="baseForm">
   <table class="table table-bordered table-hover">
             <tr>    
				 <td class="tableleft"><span>*</span>总运单号</td>
                  <td><input type="text" name="MBL" id="MBL"/></td>
				   <td class="tableleft"><span>*</span>航次航班号</td>
                  <td><input type="text" name="FLIGHT_NO"  id="FLIGHT_NO" /></td>				 
				   <td class="tableleft" ><span>*</span>进出口标志</td>
					<td>
						 <select id="I_E_FLAG" name="I_E_FLAG">
							<option value="">请选择</option>
							<option value="I">进口</option>
							<option value="E">出口</option>
						  </select>
					</td>	  
			</tr>	
			<tr>
			      <td class="tableleft">中文运输工具</td>
                  <td><input type="text" name="TRANS_TOOL_CN" id="TRANS_TOOL_CN"/></td>
                  <td class="tableleft">英文运输工具</td>
                  <td><input type="text" name="TRANS_TOOL_EN" id="TRANS_TOOL_EN" /></td>
                  <td class="tableleft">总件数</td>
                  <td><input type="text" name="NUM" id="NUM" /></td>
			</tr>
           <tr>
		          <td class="tableleft">总重量（公斤）</td>
                  <td><input type="text" name="WEIGHT" id="WEIGHT" /></td>
				   <td class="tableleft">运输方式</td>
                  <td>
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
                  <td class="tableleft"><span>*</span>进港日期</td>
                  <td><input readonly type="text" name="IN_DATE" id="IN_DATE" class="calendar" /></td>
                 </tr>	
            <tr>
			      <td class="tableleft"><span>*</span>进出口口岸</td>
                  <td><input type="text" name="PORT" id="PORT" /></td>
				   <td class="tableleft">起运港/抵运地</td>
                  <td><input type="text" name="PORT_SHIP_DEST" id="PORT_SHIP_DEST" /></td>
				   <td class="tableleft">分运单份数</td>
                  <td><input type="text" name="HBL_NUM" id="HBL_NUM" /></td>		  
                   </tr>
           <tr>
		          <td class="tableleft"><span>*</span>申报时间</td>
                  <td><input readonly type="text" name="APP_DATE" id="APP_DATE" class="calendar"/></td>
                  <td class="tableleft"><span>*</span>申报企业检验检疫备案编号CIQ</td>
                  <td><input type="text" name="APPLIEDCOMPANYCIQ" id="APPLIEDCOMPANYCIQ" /></td>
				   <td class="tableleft"><span>*</span>申报地检验检疫代码</td>
                  <td><input type="text" name="APPLIEDCUSTOMSINSP"  id="APPLIEDCUSTOMSINSP" /></td>	  
           </tr>	
			<tr>
			 <td class="tableleft">托运货物包装种类代码</td>
                  <td><input type="text" name="GOODSPACKTYPE" id="GOODSPACKTYPE"  /></td>		 
                  <td class="tableleft"><span>*</span>托运货物包装种类代码CIQ</td>
                  <td colspan="3"><input type="text" name="GOODSPACKTYPEINSP" id="GOODSPACKTYPEINSP" />
				</td>
			</tr>		   
             <tr> 
			  <td></td>
			  <td></td>			   
			  <td colspan="6"><button type="button" class="btn btn-primary" id="btnSave" onclick="common_request(1)">保存</button>&nbsp;&nbsp;
              <button type="button" class="btn btn-primary" id="res" >重置</button>
			  </td>
			 </tr>
			 
            <!-- <a href="javascript:void(0);" onclick="add_()" class="icon-plus" title="新增分单信息"></a>		-->	  
   </table>
 </form>
 
<a class="btn btn-success" href="javascript:void(0);" onclick="add_()" title="新增分单信息">新增分单信息</a> 
<a class="btn btn-success" name="success" href="javascript:void(0);" onclick="del()" title="删除分单信息">删除分单信息</a>   
 <input id="import_hbl" type="button"  class="btn btn-success" value="运单分单导入" onclick="ShowDiv('hbl','fade')" />  
<a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/ajax_data_hbl_templet");?>">分单导入模板</a> &nbsp;&nbsp; 
 <table class="table table-bordered table-hover definewidth " style="width:2000px;">
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
        <!--<th>创建人</th> -->
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
 
 <div id="page_string"  style="float:right;">
  
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
			
			$("form :input").val('');

			});
			//end
		});	
$(function () {
  //common_request(1);
});

function common_request(page){
	/* var total=document.getElementsByName("total");
	 for (var i = 0;i < total.length; i++)
	 {
      if(total[i].value=='')
	  {
		alert("必填项不能为空哦！");
	    return;
      }
     }*/
  var url="<?php echo site_url("waybill/ajax_data_mbl");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
	'FLIGHT_NO':$("#FLIGHT_NO").val(),
	'I_E_FLAG':$("#I_E_FLAG").val(),
	'TRANS_TOOL_CN':$("#TRANS_TOOL_CN").val(),
	'TRANS_TOOL_EN':$("#TRANS_TOOL_EN").val(),
	'NUM':$("#NUM").val(),
	'WEIGHT':$("#WEIGHT").val(),
	'TRANS_MODE':$("#TRANS_MODE").val(),
	'IN_DATE':$("#IN_DATE").val(),
	'PORT':$("#PORT").val(),
	'PORT_SHIP_DEST':$("#PORT_SHIP_DEST").val(),
	'HBL_NUM':$("#HBL_NUM").val(),
	'APP_DATE':$("#APP_DATE").val(),
	'APPLIEDCOMPANYCIQ':$("#APPLIEDCOMPANYCIQ").val(),
	'APPLIEDCUSTOMSINSP':$("#APPLIEDCUSTOMSINSP").val(),
	'GOODSPACKTYPE':$("#GOODSPACKTYPE").val(),
	'GOODSPACKTYPEINSP':$("#GOODSPACKTYPEINSP").val(),
  } ;
  $.ajax({
       type: "POST",
       url: url,
       data: data_,
       cache:false,
       dataType:"json",
     //  async:false,
       success: function(msg){
        var shtml = '';
		 var list = msg.resultinfo.list;
      if(msg.resultcode<0){
        BUI.Message.Alert("没有权限执行此操作",'error');
        return false ;
      }else if(msg.resultcode == 0 ){
        BUI.Message.Alert(msg.resultinfo.errmsg,'error');
        return false ;        
      }else{  
      BUI.Message.Alert("保存成功",'success');
       common_view(1);	   
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
  var data_=$("#MBL").val();
    if(!data_){
      BUI.Message.Alert('请先保存总运单信息','error');
      return
    }
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加分单信息",
      width:700,
      height:350,
      loader : {
        url : '<?php echo site_url('waybill/add_fen');?>',
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
      url: "<?php echo site_url('waybill/doadd_fen');?>?inajax=1" ,
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
			BUI.Message.Alert("添加成功",'success');
            common_view(1);
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
        }
      }

    });
  }

   

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
                url: "<?php echo site_url('waybill/delete_hbl');?>",
                data: {"guid":data},
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
                         common_view(1);
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
	function edit(GUID){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"编辑分单信息",
      width:800,
      height:400,
      loader : {
        url : '<?php echo site_url("waybill/waybill_input_fen_edit");?>',
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
      url: "<?php echo site_url('waybill/do_waybill_input_fen_edit');?>?inajax=1" ,
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
         common_view(1);
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
        }
      }

    });

  }
  
  function common_view(page){
  var url="<?php echo site_url("waybill/ajax_data_hbl");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
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
         // shtml+='<td>'+list[i]['CREATE_USER']+'</td>';
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

function ajax_data(page){
  common_view(page); 
}
</script>