<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>用户管理</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/style.css" />   
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" />   
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
    <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
 
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
<div class="form-inline definewidth m20" >    
    库位号：
    <input type="text" name="username" id="username"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
  <select id="condition">
    <option value="1">模糊搜索</option>
    <option value="2">精确搜索</option>
  </select>
  启用状态：
  <select id="status">
    <option value="">请选择</option>
    <option value="1">启用</option>
    <option value="0">停用</option>
  </select>
    <button type="submit" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp; <a  class="btn btn-success" id="addnew" href="<?php echo site_url("user/add");?>">添加网站用户<span class="glyphicon glyphicon-plus"></span></a>
</div>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>Uid</th>
        <th>用户名称</th>
        <th>状态</th>
    <th>注册日期</th>
    <th>过期日期</th>
        <th>操作</th>
    </tr>
    </thead>
  <tbody id="result_">
  </tbody>  
  
  </table>
  <div id="page_string" class="form-inline definewidth m1" style="float:right ; text-align:right ; margin:-4px">
  
  </div>




</body>
</html>



<script>
$(function () {
  common_request(1);
});
function common_request(page){
  var url="<?php echo site_url("sample2/index");?>?inajax=1";
  var data_ = {
    'page':page,
    'time':<?php echo time();?>,
    'action':'ajax_data',
    'username':$("#username").val(),
    'condition':$("#condition").val(),
    'status':$("#status").val()
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
          shtml+='<td>'+list[i].uid+'</td>';
          shtml+='<td>'+list[i]['username']+'</td>';
          shtml+='<td>'+list[i]['status']+'</td>';
          shtml+='<td>'+list[i]['regdate']+'</td>';
          shtml+='<td>'+list[i]['expire']+'</td>';
          shtml+='<td><a href="<?php echo site_url('user/edit');?>?id='+list[i].uid+'" class="icon-edit" title="编辑'+list[i]['username']+'的基本信息"></a></td>';
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
</script>
<script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>