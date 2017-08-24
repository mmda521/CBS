<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>搜索表单</title>
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
                url: "<?php echo site_url('batch/ajax_data_export');?>?inajax=1" ,
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
                       //BUI.Message.Alert('导出成功！');
						//url1="<?php echo site_url('waybill/index');?>";
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
</head>
<body>
<a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/waybill_back");?>">返回</a> 
<form  id="baseForm" name="baseForm">
		<table class="table table-bordered table-hover">
				<tr>
						<td class="tableleft"><span>*</span>总运单号</td>
						<td><input type="text" name="MBL" id="MBL" value="<?php if(isset($info[0]['MBL'])) echo $info[0]['MBL']; ?>" /></td>
						<td class="tableleft"><span>*</span>航次航班号</td>
						<td><input type="text" name="FLIGHT_NO"  id="FLIGHT_NO" value="<?php if(isset($info[0]['FLIGHT_NO'])) echo $info[0]['FLIGHT_NO']; ?>"/></td>
						<td class="tableleft" ><span>*</span>进出口标志</td>
						 <td>
						  <select id="I_E_FLAG" name="I_E_FLAG">
							<option value="I" <?php $selected='selected=selected'; if(isset($info[0]['I_E_FLAG'])&&($info[0]['I_E_FLAG']=='I')) echo $selected;?>>进口</option>
							<option value="E" <?php $selected='selected=selected'; if(isset($info[0]['I_E_FLAG'])&&($info[0]['I_E_FLAG']=='E')) echo $selected;?>>出口</option>
							</select> 
						</td>
				</tr>
				<tr>
						<td class="tableleft">中文运输工具</td>
						<td><input type="text" name="TRANS_TOOL_CN" id="TRANS_TOOL_CN" value="<?php if(isset($info[0]['TRANS_TOOL_CN'])) echo $info[0]['TRANS_TOOL_CN']; ?>"/></td>
						<td class="tableleft">英文运输工具</td>
						<td><input type="text" name="TRANS_TOOL_EN" id="TRANS_TOOL_EN" value="<?php if(isset($info[0]['TRANS_TOOL_EN'])) echo $info[0]['TRANS_TOOL_EN']; ?>"/></td>
						<td class="tableleft">总件数</td>
						<td><input type="text" name="NUM" id="NUM" value="<?php if(isset($info[0]['NUM'])) echo $info[0]['NUM']; ?>"/></td>
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
						<td class="tableleft"><span>*</span>进港日期</td>
						<td><input readonly type="text" name="IN_DATE" id="IN_DATE" class="calendar" value="<?php if(isset($info[0]['IN_DATE'])) echo $info[0]['IN_DATE']; ?>"/></td>
				</tr>
				<tr>
						<td class="tableleft"><span>*</span>进出口口岸</td>
						<td><input type="text" name="PORT" id="PORT" value="<?php if(isset($info[0]['PORT'])) echo $info[0]['PORT']; ?>"/></td>
						<td class="tableleft">起运港/抵运地</td>
						<td><input type="text" name="PORT_SHIP_DEST" id="PORT_SHIP_DEST" value="<?php if(isset($info[0]['PORT_SHIP_DEST'])) echo $info[0]['PORT_SHIP_DEST']; ?>"/></td>
						<td class="tableleft">分运单份数</td>
						<td><input type="text" name="HBL_NUM" id="HBL_NUM" value="<?php if(isset($info[0]['HBL_NUM'])) echo $info[0]['HBL_NUM']; ?>"/></td>
				</tr>
				<tr>
						<td class="tableleft"><span>*</span>申报时间</td>
						<td><input readonly type="text" name="APP_DATE" id="APP_DATE" class="calendar" value="<?php if(isset($info[0]['APP_DATE'])) echo $info[0]['APP_DATE']; ?>"/></td>
						<td class="tableleft"><span>*</span>申报企业检验检疫备案编号CIQ</td>
						<td><input type="text" name="APPLIEDCOMPANYCIQ" id="APPLIEDCOMPANYCIQ" value="<?php if(isset($info[0]['APPLIEDCOMPANYCIQ'])) echo $info[0]['APPLIEDCOMPANYCIQ']; ?>"/></td>
						<td class="tableleft"><span>*</span>申报地检验检疫代码</td>
						<td><input type="text" name="APPLIEDCUSTOMSINSP"  id="APPLIEDCUSTOMSINSP" value="<?php if(isset($info[0]['APPLIEDCUSTOMSINSP'])) echo $info[0]['APPLIEDCUSTOMSINSP']; ?>"/></td>
				</tr>
				<tr>
						<td class="tableleft">托运货物包装种类代码</td>
						<td><input type="text" name="GOODSPACKTYPE" id="GOODSPACKTYPE" value="<?php if(isset($info[0]['GOODSPACKTYPE'])) echo $info[0]['GOODSPACKTYPE']; ?>" /></td>
						<td class="tableleft"><span>*</span>托运货物包装种类代码CIQ</td>
						<td colspan="3"><input type="text" name="GOODSPACKTYPEINSP" id="GOODSPACKTYPEINSP" value="<?php if(isset($info[0]['GOODSPACKTYPEINSP'])) echo $info[0]['GOODSPACKTYPEINSP']; ?>"/></td>
				</tr>
				<input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/>
				<tr>
						<td></td>
						<td></td>
						<td colspan="6"><button type="button" class="btn btn-primary" id="btnSave" onclick="common_request(1)">保存</button>
								&nbsp;&nbsp;
								<button type="button" class="btn btn-primary" id="res" >重置</button></td>
				</tr>
				
				<!-- <a href="javascript:void(0);" onclick="add_()" class="icon-plus" title="新增分单信息"></a>		-->
		</table>
</form>
<a class="btn btn-success" href="javascript:void(0);" onclick="add_()" title="新增批次信息">新增批次信息</a> <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="del()" title="删除批次信息">删除批次信息</a> <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="export_batch()" title="导出批次信息">导出批次信息</a>
<table class="table table-bordered table-hover definewidth ">
		<thead>
				<tr>
						<th><input type="checkbox" id="selAll" onclick="selectAll()"/></th>
						<th>编辑</th>
						<th>总单号</th>
						<th>批次号</th>
						<th>创建时间</th>
		                <th>创建人</th>
						<th>理货类型</th>
						<th>批次布控</th>
						<th>理货状态</th>   
				</tr>
		</thead>
		<tbody id="result_">
		</tbody>
</table>
<div id="page_string"  style="float:right;"> </div>
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
  common_view(1);
});

function common_request(page){
	
  var url="<?php echo site_url("waybill/ajax_data_mbl_edit");?>?inajax=1";
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
      BUI.Message.Alert('编辑成功！');	  
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


function common_view(page){
  var url="<?php echo site_url("batch/ajax_data_batch");?>?inajax=1";
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
		  shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"/></td>';   
          shtml+='<td><a href="javascript:void(0)" name="success" onclick=\'edit(\"'+list[i].GUID+'\")\' class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';		  		  
          shtml+='<td>'+list[i]['MBL']+'</td>';
          shtml+='<td>'+list[i]['BATCHNO']+'</td>';
		   shtml+='<td>'+list[i]['CREATE_DATE']+'</td>';
          shtml+='<td>'+list[i]['CREATE_USER']+'</td>';
          shtml+='<td>'+list[i]['BATCHTYPE']+'</td>';
          shtml+='<td>'+list[i]['BATCHCONTROL']+'</td>';
          shtml+='<td>'+list[i]['TALLY_STATUS']+'</td>';
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
	
	  //添加子类
  //_typeid 分类ID
  //_id 父级ID
  function add_(){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加批次信息",
      width:400,
      height:200,
      loader : {
        url : '<?php echo site_url('batch/add');?>',
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
    var data2_ = $("#add_form").serializeArray();
    var data_= data1_.concat(data2_);
    //data_={'MBL':$("#MBL").val()};
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('batch/doadd');?>?inajax=1" ,
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
                url: "<?php echo site_url('batch/delete');?>" ,
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
      title:"编辑批次信息",
      width:400,
      height:200,
      loader : {
        url : '<?php echo site_url("batch/edit");?>',
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
    var data_= data1_.concat(data2_);
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('batch/do_edit');?>?inajax=1",
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