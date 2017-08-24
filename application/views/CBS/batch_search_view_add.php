<!DOCTYPE HTML>
<html>
 <head>
  <title> 搜索表单</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/style.css" /> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/window.css" />	
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script> 	
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/validate/validator.js"></script>
	<link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/admin.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/ajaxfileupload.js"></script>
   <script>
	function export_batch(){
        var selectCount = 0;
        var data = [] ;
        var o = select_export() ;
        selectCount = o.selectCount ;
        data = o.data ;
        if(selectCount == 0 ){
            BUI.Message.Alert('请选择数据进行导出','error');
            return false ;
        }      
		  $.ajax({
                type: "POST",
                url: "<?php echo site_url('waybill_fen/ajax_data_export');?>?inajax=1" ,
                data: {"guid":data},
                cache:false,
                dataType:"json",
                //  async:false,				
                success: function(msg){
					var shtml = '' ;
				    var list = msg.resultinfo.list;
                    if(msg.resultcode<0){
                        BUI.Message.Alert('没有权限执行此操作','error');
                        return false ;
                    }else if(msg.resultcode == 0 ){
                        BUI.Message.Alert(msg.resultinfo.errmsg ,'error');                        
                        return false ;
                    }else{
					  document.location.href =("<?php echo base_url();?>"+msg.response.url);
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
    }
    function select_export(){
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
     $('#close2').click(function(){
     $('#hbl').css('display','none');
	  $('#fade').css('display','none');
     });
});
</script>
<script language="javascript">
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
 <div id="fade" class="black_overlay"> </div>
 <div id="hbl" class="dialog1">
		<div  class="dialog_content" ><span class="del_left">运单分单信息录入</span> <span class="del_right" onclick="CloseDiv('hbl','fade')">×</span> </div>
		<br/>
		&nbsp; &nbsp;
		<form id="form2" name="form2" method="post" action="#" style="display:inline;">
				<div class="box_file"><input id="file2" type="file" name="file2" /></div>
				<div class="box_text">
				<input  type="button" value="导入" class="tanchuang" id="buttonUpload2"/>
				&nbsp; &nbsp;
				<input type="button" value="取消"  id="close2" class="tanchuang"/>
				</div>
		</form>
</div>
<form method="post">
     <table class="table table-bordered table-hover" >
         <tr>
         <td class="tableleft"><span>*</span>总单号</td>
         <td><input type="text" name="MBL" id="MBL" class="abc input-default" placeholder="" value=""></td>
             <td class="tableleft"><span>*</span>批次号</td>
             <td><input type="text" name="BATCHNO" id="BATCHNO" class="abc input-default" placeholder="" value=""></td>           
             </tr>
         <tr>
			<td colspan="6" style="text-align: center;"><button type="button" class="btn btn-primary" onclick="common_request(1)">保存</button>&nbsp;&nbsp;
			<button type="reset" class="btn btn-primary" id="res">重置</button></td>
		 </tr>
	<a class="btn btn-success" name="success" href="<?php echo site_url("batch_view/index");?>" title="返回">返回</a>&nbsp;<input id="import_hbl" type="button"  class="btn btn-success" value="运单分单导入" onclick="ShowDiv('hbl','fade')" />&nbsp;<a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/ajax_data_hbl_templet");?>">分单导入模板</a> &nbsp;&nbsp;
     </table>
</form>
<a class="btn btn-success" href="javascript:void(0);" onclick="add_()" title="新增分单信息">新增分单信息</a> <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="del()" title="删除分单信息">删除分单信息</a> <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="export_batch()" title="导出分单信息">导出分单信息</a>
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
    <!-- <tr>
            <td colspan="8">
                全选<input type="checkbox" id="selAll" onclick="selectAll()">
                反选:<input type="checkbox" id="inverse" onclick="inverse();">
                <button class="button button-small" type="button" onclick="del()">
                    <i class="icon-remove"></i>
                    删除
                </button>
            </td>
        </tr>
	-->
  </table>
  <div id="page_string" style="float:right;">
  
  </div> 

</body>
</html>  
<script>
$(document).ready(function(){
	
		//重置
		$("#res").click(function(){
			
			$("form :input").val('');

			});
			//end
		});	


function common_request(page){
  var url="<?php echo site_url("batch_view/ajax_data_batch");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
	'BATCHNO':$("#BATCHNO").val()
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
         BUI.Message.Alert("服务器繁忙",'error');
       }
      
    });   
}

function common_view(page){
  var url="<?php echo site_url("waybill_fen/ajax_data_search");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
	'MBL':$("#MBL").val(),
	'BATCHNO':$("#BATCHNO").val()
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
        url : '<?php echo site_url('waybill_fen/add_fen');?>',
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
	var data1_ = $("#MBL").serializeArray();
    var data2_ = $("#myform").serializeArray();
	var data3_ = $("#BATCHNO").serializeArray();
    var data_= data1_.concat(data2_).concat(data3_);
    //data_={'MBL':$("#MBL").val()};
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('waybill_fen/doadd_fen');?>?inajax=1" ,
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
          common_view(1); 
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
                url: "<?php echo site_url('waybill_fen/delete_hbl');?>" ,
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
						common_view(1);
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
        url : '<?php echo site_url("waybill_fen/waybill_input_fen_edit");?>',
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
	var data1_ = $("#MBL").serializeArray();
    var data2_ = $("#edit_form").serializeArray();
	var data3_ = $("#BATCHNO").serializeArray();
    var data_= data1_.concat(data2_).concat(data3_);
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('waybill_fen/do_waybill_input_fen_edit');?>?inajax=1",
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
         common_view(1);
        $("#result_").html(shtml);
        
        $("#page_string").html(msg.resultinfo.obj);
        }
      }

    });

  }
  
  function ajax_data(page){
  common_view(page); 
}
</script>
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>