<!DOCTYPE html>
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
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/config-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/admin.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/validate/validator.js"></script>
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
 <form id="form">
  <table class="table table-bordered table-hover">
    <tr>
      <td class="tableleft"><s style="color: red">*</s>航次航班号</td>
      <td><input type="text" name="flightno" id="flightno"/></td>
      <td class="tableleft"><s style="color: red">*</s>运输方式代码</td>
      <td><input type="text" name="transfertype" id="transfertype"/></td>
      <td class="tableleft"><s style="color: red">*</s>运输工具代码</td>
      <td><input type="text" name="shipcode" id="shipcode"/></td>
      <td class="tableleft"><s style="color: red">*</s>运输工具名称</td>
      <td><input type="text" name="shipname" id="shipname" /></td>
    </tr>
    <tr>
      <td class="tableleft">集装箱(器)编号</td>
      <td><input type="text" name="boxno" id="boxno"/></td>
      <td class="tableleft">集装箱(器)尺寸和类型</td>
      <td><input type="text" name="bosspec" id="bosspec"/></td>
      <td class="tableleft">重箱或者空箱标识代码</td>
      <td><input type="text" name="boxflag" id="boxflag" /></td>
      <td class="tableleft">封志号码，类型和施加封志人</td>
      <td><input type="text" name="flagno" id="flagno"/></td>
    </tr>
    <tr>
      <td class="tableleft"><s style="color: red">*</s>总提运单号</td>
      <td><input type="text" name="totaltransferno" id="totaltransferno" /></td>
      <td class="tableleft">分提运单号</td>
      <td><input type="text" name="tansferno" id="tansferno"/></td>
      <td class="tableleft">托运货物序号</td>
      <td><input type="text" name="goodsno" id="goodsno" /></td>
      <td class="tableleft"><s style="color: red">*</s>托运货物包装种类</td>
      <td><input type="text" name="goodspacktype" id="goodspacktype" /></td>
    </tr>
    <tr>
      <td class="tableleft"><s style="color: red">*</s>托运货物件数</td>
      <td><input type="text" name="goodsammount" id="goodsammount" /></td>
      <td class="tableleft">货物简要描述</td>
      <td><input type="text" name="description" id="description"/></td>
      <td class="tableleft">货物描述补充信息</td>
      <td><input type="text" name="description2" id="description2"/></td>
      <td class="tableleft"><s style="color: red">*</s>货物总毛重</td>
      <td><input type="text" name="totalweigth" id="totalweigth"/></td>
    </tr>
    <tr>
      <td class="tableleft"><s style="color: red">*</s>卸货地代码</td>
      <td><input type="text" name="unloadingcode" id="unloadingcode"/></td>
      <td class="tableleft"><s style="color: red">*</s>到达卸货地时间</td>
      <td><input type="text" class="calendar" id="arrivetime" name="arrivetime" readonly></td>
      <td class="tableleft"><s style="color: red">*</s>申报地海关代码</td>
      <td><input type="text" name="appliedcustoms" id="appliedcustoms"/></td>
      <td class="tableleft"><s style="color: red">*</s>库位</td>
      <td><select id="stockposition">
          <option value="">请选择</option>
          <?php
          foreach($info as $key=>$row){
            ?>
            <option value="<?php echo $info[$key]['GOODSSITE_NO'];?>"><?php echo $info[$key]['GOODSSITE_NO'];?></option>
          <?php }?>
        </select> </td>
    </tr>
    <tr>
      <td class="tableleft"><s style="color: red">*</s>监管场所海关备案编码</td>
      <td><input type="text" name="appliedcompany" id="appliedcompany"/></td>
      <td class="tableleft">备注</td>
      <td><input type="text" name="comments" id="comments"/></td>
      <td class="tableleft"><s style="color: red">*</s>进出口标记</td>
      <td>
        <select  id="i_e_flag" >
          <option value="">全部</option>
          <option value="I">进口</option>
          <option value="E">出口</option>
        </select>
      </td>
      <td class="tableleft"><s style="color: red">*</s>申报企业检验检疫备案编号CIQ</td>
      <td><input type="text" name="appliedcompanyciq" id="appliedcompanyciq"/></td>
    </tr>
    <tr>
      <td class="tableleft"><s style="color: red">*</s>申报企业检验检代码</td>
      <td><input type="text" name="appliedcustomsinsp" id="appliedcustomsinsp"/></td>
      <td class="tableleft"><s style="color: red">*</s>托运货物包装类代码CIQ</td>
      <td colspan="3"><input type="text" name="goodspacktypeinsp" id="goodspacktypeinsp"/></td>
    </tr>
    <tr>
      <td colspan="8" style="text-align: center">
        <button type="button" class="btn btn-primary"  id="btnSearch2" onclick="common_request(1)">保存</button>&nbsp;
        <button type="reset" class="btn btn-primary" >重置</button>
      </td>
    </tr>
	 <a  class="button button-primary" onClick="javascript:history.go(-1);">返回</a><a  class="button button-primary" onclick="common_send(1)">发送</a>
  </table>
</form>
 <a href="javascript:void(0);" onclick="add_()" class="button button-primary">新增明细</a> <a class="button button-primary" type="button" onclick="del()">删除明细</a>
<table class="table table-bordered table-hover definewidth" style="width: 1920px;">
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
    <th>物流企业海关备案编号</th>
    <th>物流企业检验检疫备案编号CTQ</th>
    <th>电商企业名称</th>
  </tr>
  </thead>
  <tbody id="result_">
  </tbody>
</table>
<div id="page_string"  style="float:right;">
</div>
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
  function common_send(page){
    var url="<?php echo site_url("tally/tally_report_ensure_send");?>?inajax=1";
    var data_ = {
      'page':page,
      'time':<?php echo time();?>,
      'action':'ajax_data',
      'totaltransferno':$("#totaltransferno").val()
    } ;
    $.ajax({
      type: "POST",
      url: url ,
      data: data_,
      cache:false,
      dataType:"json",
      //  async:false,
      success: function(msg){
        if(msg.resultcode<0){
          BUI.Message.Alert("没有权限执行此操作",'error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
        }else{
          BUI.Message.Alert(msg.resultinfo.errmsg,'success');
        }
      },
      error:function(){
        BUI.Message.Alert("服务器繁忙",'error');
      }

    });
  }
  function common_request(page){
    var url="<?php echo site_url("tally/tally_report_ensure_ajax_data1");?>?inajax=1";
      var data_ = {
      'page':page,
      'time':<?php echo time();?>,
      'action':'ajax_data',
      'flightno':$("#flightno").val(),
      'transfertype':$("#transfertype").val(),
      'shipcode':$("#shipcode").val(),
      'shipname':$("#shipname").val(),
      'boxno':$("#boxno").val(),
      'bosspec':$("#bosspec").val(),
      'boxflag':$("#boxflag").val(),
      'flagno':$("#flagno").val(),
      'totaltransferno':$("#totaltransferno").val(),
      'tansferno':$("#tansferno").val(),
      'goodsno':$("#goodsno").val(),
      'goodspacktype':$("#goodspacktype").val(),
      'goodsammount':$("#goodsammount").val(),
      'description':$("#description").val(),
      'description2':$("#description2").val(),
      'totalweigth':$("#totalweigth").val(),
      'unloadingcode':$("#unloadingcode").val(),
      'arrivetime':$("#arrivetime").val(),
      'appliedcustoms':$("#appliedcustoms").val(),
      'stockposition':$("#stockposition").val(),
      'appliedcompany':$("#appliedcompany").val(),
      'comments':$("#comments").val(),
      'i_e_flag':$("#i_e_flag").val(),
      'appliedcompanyciq':$("#appliedcompanyciq").val(),
      'appliedcustomsinsp':$("#appliedcustomsinsp").val(),
      'goodspacktypeinsp':$("#goodspacktypeinsp").val()
    } ;
    $.ajax({
      type: "POST",
      url: url ,
      data: data_,
      cache:false,
      dataType:"json",
      //  async:false,
      success: function(msg){
        if(msg.resultcode<0){
          BUI.Message.Alert("没有权限执行此操作",'error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
          return false ;
        }else{
          BUI.Message.Alert("保存成功",'success');
        common_search(1);
        }
      },
      error:function(){
        BUI.Message.Alert("服务器繁忙",'error');
      }

    });
  }
  function ajax_data(page){
    common_search(page);
  }
  //
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
        url: "<?php echo site_url('tally/tally_report_ensure_del_ajax_data');?>" ,
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
            BUI.Message.Alert('删除成功','success');
            common_search(1);
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
      title:"编辑确报理货报告",
      width:800,
      height:400,
      loader : {
        url : '<?php echo site_url("tally/tally_report_ensure_edit_no");?>',
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
    dialog.get('loader').load({"guid":GUID});
  }
  function submit_edit(GUID){
    var data_ = $("#myform_edit").serializeArray();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('tally/tally_report_ensure_edit_no_ajax_data');?>?inajax=1" ,
      data: data_,
      cache:false,
      dataType:"json",
      async:false,
      success: function(msg){
        if(msg.resultcode<0){
          BUI.Message.Alert('没有权限执行此操作','error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
          return false ;
        }else{
          guid = GUID ;
          BUI.Message.Alert('更新成功','success');
          common_search(1);
        }
      }

    });

  }
  //添加子类
  //_typeid 分类ID
  //_id 父级ID
  function add_(){
    var data_=$("#totaltransferno").val();
    if(!data_){
      BUI.Message.Alert('请先保存主单信息','error');
      return
    }
    var Overlay = BUI.Overlay
    var dialog = new Overlay.Dialog({
      title:"添加确报理货报告数据",
      width:800,
      height:400,
      loader : {
        url : '<?php echo site_url('tally/tally_report_ensure_add_no');?>',
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
   var data1_ = $("#myform_add").serializeArray();
    var data2_ = $("#totaltransferno").serializeArray();
    var data_= data1_.concat(data2_);
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('tally/tally_report_ensure_add_no_ajax_data');?>?inajax=1" ,
      data: data_,
      cache:false,
      dataType:"json",
      async:false,
      success: function(msg){
        if(msg.resultcode<0){
          BUI.Message.Alert("没有权限执行此操作",'error');
          return false ;
        }else if(msg.resultcode == 0 ){
          BUI.Message.Alert(msg.resultinfo.errmsg,'error');
          return false ;
        }else{
          BUI.Message.Alert("保存成功",'success');
          common_search(1);
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
  function common_search(page){
    var url="<?php echo site_url("tally/tally_report_ensure_search_data");?>?inajax=1";
    var data_ = {
      'page':page,
      'time':<?php echo time();?>,
      'action':'ajax_data',
      'flightno':$("#flightno").val(),
      'transfertype':$("#transfertype").val(),
      'shipcode':$("#shipcode").val(),
      'shipname':$("#shipname").val(),
      'boxno':$("#boxno").val(),
      'bosspec':$("#bosspec").val(),
      'boxflag':$("#boxflag").val(),
      'flagno':$("#flagno").val(),
      'totaltransferno':$("#totaltransferno").val(),
      'tansferno':$("#tansferno").val(),
      'goodsno':$("#goodsno").val(),
      'goodspacktype':$("#goodspacktype").val(),
      'goodsammount':$("#goodsammount").val(),
      'description':$("#description").val(),
      'description2':$("#description2").val(),
      'totalweigth':$("#totalweigth").val(),
      'unloadingcode':$("#unloadingcode").val(),
      'arrivetime':$("#arrivetime").val(),
      'appliedcustoms':$("#appliedcustoms").val(),
      'stockposition':$("#stockposition").val(),
      'appliedcompany':$("#appliedcompany").val(),
      'comments':$("#comments").val(),
      'i_e_flag':$("#i_e_flag").val(),
      'appliedcompanyciq':$("#appliedcompanyciq").val(),
      'appliedcustomsinsp':$("#appliedcustomsinsp").val(),
      'goodspacktypeinsp':$("#goodspacktypeinsp").val()
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
          BUI.Message.Alert("服务器繁忙11",'error');
          return false ;
        }else{
          for(var i in list){
            shtml+='<tr>';
            shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['GUID']+'"></td>';
            shtml+='<td><a href="javascript:void(0)" onclick=\'edit(\"'+list[i].GUID+'\")\' class="icon-edit" title="编辑'+list[i]['GUID']+'"></a></td>';
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
            shtml+='<td>'+list[i]['GOODSNO']+'</td>';
            shtml+='<td>'+list[i]['TRANSFERCOMPANYCIQ']+'</td>';
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
        BUI.Message.Alert("服务器繁忙",'error');
      }

    });


  }
</script>
