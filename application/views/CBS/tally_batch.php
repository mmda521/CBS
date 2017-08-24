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
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/page-min.css" rel="stylesheet" type="text/css" />   <!-- 下面的样式，仅是为了显示代码，而不应该在项目中使用-->
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/prettify.css" rel="stylesheet" type="text/css" />
   <style type="text/css">
    code {
      padding: 0px 4px;
      color: #d14;
      background-color: #f7f7f9;
      border: 1px solid #e1e1e8;
    }
   </style>
 </head>
 <body>
      <form id="searchForm" action="<?php echo site_url("tally/tally_batch_ajax_data_export");?>" method="post">
          <table class="table table-bordered table-hover">
              <tr>
                  <td class="tableleft">总运单号</td>
                  <td><input type="text" name="mbl" id="mbl"/></td>
                  <td class="tableleft">货物抵运日期</td>
                  <td><input type="text" class="calendar" id="tally_sdate" name="tally_sdate" readonly><span> -- </span><input id="tally_edate" name="tally_edate" type="text" class=" calendar" readonly></td>
                  <td class="tableleft">进出口标识</td>
                  <td>
                      <select  id="i_e_type" >
                          <option value="">全部</option>
                          <option value="I">进口</option>
                          <option value="E">出口</option>
                      </select>
                  </td>
              </tr>
              <tr>
                  <td class="tableleft">客户</td>
                  <td><input type="text" name="customer_name" id="customer_name" /></td>
                  <td class="tableleft">电商企业名称</td>
                  <td colspan="3"><input type="text" name="e_business" id="e_business" /></td>
                  </tr>
              <tr>
                  <td colspan="6" style="text-align: center">
                      <button type="button" class="btn btn-primary"  id="btnSearch" onclick="common_request(1)">查询</button>&nbsp;
                      <button type="reset" class="btn btn-primary" >重置</button>
                  </td>
              </tr>
			   <a class="btn btn-success" name="success" href="javascript:void(0);" onclick="add_()" title="新增批次理货信息">新增</a><a class="btn btn-success"  onclick="del()">删除</a><button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
          </table>
      </form>
    <table class="table table-bordered table-hover definewidth" style="width: 1920px">
      <thead>
      <tr>
          <th><input type="checkbox" id="selAll" onclick="selectAll()"></th>
          <th>编辑</th>
        <th>总运单号</th>
          <th>批次号</th>
        <th>分运单号</th>
        <th>品名</th>
        <th>进出口标识</th>
        <th>货物抵运日期</th>
        <th>件数</th>
        <th>重量KG</th>
        <th>理货件数</th>
        <th>理货重量</th>
        <th>库位</th>
        <th>客户</th>
        <th>物流企业海关备案编号</th>
        <th>电商企业名称</th>
        <th>物流企业检验检疫备案编号CTQ</th>
          <th>理货状态</th>
      </tr>
      </thead>
      <tbody id="result_">
      </tbody>
    </table>
    <div id="page_string"  style="float:right;">
    </div>

  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/config-min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/admin.js"></script>
    <script type="text/javascript">
      BUI.use('bui/calendar',function(Calendar){
        var datepicker = new Calendar.DatePicker({
          trigger:'.calendar',
          autoRender : true
        });
      });
    </script>
    <body>
</html>
<script>
    $(function (){
        common_request(1);
    });
    function common_request(page){
        var url="<?php echo site_url("tally/tally_batch_ajax_data");?>?inajax=1";
        var data_ = {
            'page':page,
            'time':<?php echo time();?>,
            'action':'ajax_data',
            'mbl':$("#mbl").val(),
            'customer_name':$("#customer_name").val(),
            'i_e_type':$("#i_e_type").val(),
            'tally_sdate':$("#tally_sdate").val(),
            'tally_edate':$("#tally_edate").val(),
            'e_business':$("#e_business").val()
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
                        shtml+='<td><a href="javascript:void(0)" name="success" onclick=\'edit(\"'+list[i].GUID+'\")\' class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';
                        shtml+='<td>'+list[i]['MBL']+'</td>';
                        shtml+='<td>'+list[i]['BATCHNO']+'</td>';
                        shtml+='<td>'+list[i]['HBL']+'</td>';
                        shtml+='<td>'+list[i]['GOODS_NAME']+'</td>';
                        shtml+='<td>'+list[i]['I_E_TYPE']+'</td>';
                        shtml+='<td>'+list[i]['TALLY_DATE']+'</td>';
                        shtml+='<td>'+list[i]['PIECES']+'</td>';
                        shtml+='<td>'+list[i]['WEIGHT']+'</td>';
                        shtml+='<td>'+list[i]['M_PIECES']+'</td>';
                        shtml+='<td>'+list[i]['M_WEIGHT']+'</td>';
                        shtml+='<td>'+list[i]['STOCKPOSITION']+'</td>';
                        shtml+='<td>'+list[i]['CUSTOMER_CODE']+'</td>';
                        shtml+='<td>'+list[i]['GOODSNO']+'</td>';
                        shtml+='<td>'+list[i]['E_BUSINESS']+'</td>';
                        shtml+='<td>'+list[i]['TRANSFERCOMPANYCIQ']+'</td>';
                        shtml+='<td>批次理货</td>';
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
    //
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
                url: "<?php echo site_url('tally/tally_batch_del_ajax_data');?>" ,
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
                        BUI.Message.Alert('删除成功','success');
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
	
	
	function add_(){
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加批次理货信息",
      width:700,
      height:400,
      loader : {
        url : '<?php echo site_url('tally/tally_batch_add');?>',
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
      url: "<?php echo site_url('tally/tally_batch_add_ajax_data');?>?inajax=1" ,
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
      title:"编辑批次理货信息",
      width:800,
      height:400,
      loader : {
        url : '<?php echo site_url("tally/tally_batch_edit");?>',
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
    var data_ = $("#form").serializeArray();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('tally/tally_batch_edit_ajax_data');?>?inajax=1",
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
</script>