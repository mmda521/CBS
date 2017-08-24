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
    <a  class="button button-primary" href="<?php echo site_url("user/limit_manage_add")?>">新增</a><a class="button button-primary" type="button" onclick="del()">删除</a><a  class="button button-primary" href="<?php echo site_url("user/limit_manage_add")?>">导出</a>
<form id="searchForm" >
    <table class="table table-bordered table-hover">
        <tr>
            <td class="tableleft">角色名称</td>
            <td><input type="text" name="role_name" id="role_name"/></td>
            <td class="tableleft">角色描述</td>
            <td><input type="text" name="role_desc" id="role_desc"/></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center">
                <button type="button" class="btn btn-primary"  id="btnSearch" onclick="common_request(1)">查询</button>&nbsp;
                <button type="reset" class="btn btn-primary" >重置</button>
            </td>
        </tr>
    </table>
</form>
<table class="table table-bordered table-hover definewidth ">
    <thead>
    <tr>
        <th><input type="checkbox" id="selAll" onclick="selectAll()"></th>
        <th>操作</th>
        <th>公司</th>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>创建日期</th>
        <th>用户数量</th>
        <th>设置权限</th>
        <th>用户</th>
    </tr>
    </thead>
    <tbody id="result_">
    </tbody>
</table>
<div id="page_string" style="float:right;">
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
        var url="<?php echo site_url("user/limit_manage_ajax_data");?>?inajax=1";
        var data_ = {
            'page':page,
            'time':<?php echo time();?>,
            'action':'ajax_data',
            'role_name':$("#role_name").val(),
            'role_name':$("#role_name").val()
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
                        shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['ROLE_ID']+'"></td>';
                        shtml+='<td><a href="<?php echo site_url('user/limit_manage_edit');?>?role_id='+list[i]['ROLE_ID']+'" class="icon-edit"</a></td>';
                        shtml+='<td>'+list[i]['COMPANY_CODE']+'</td>';
                        shtml+='<td>'+list[i]['ROLE_NAME']+'</td>';
                        shtml+='<td>'+list[i]['ROLE_DESC']+'</td>';
                        shtml+='<td>'+list[i]['CREATE_DATE']+'</td>';
                        shtml+='<td>'+list[i]['ROLE_TYPE1']+'</td>';
                        shtml+='<td><a href="<?php echo site_url('user/limit_control');?>?role_id='+list[i]['ROLE_ID']+'">设置权限</a></td>';
                        shtml+='<td><a href="<?php echo site_url('user/password_change');?>">设置密码</a></td>';
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
            BUI.Message.Alert('请选择进行删除','error');
            return false ;
        }
        BUI.Message.Confirm('此操作不可恢复,是否确定此操作',function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('user/limit_manage_del_ajax_data');?>" ,
                data: {"role_id":data},
                cache:false,
                dataType:"json",
                //  async:false,
                success: function(msg){
                    if(msg.resultcode<0){
                        BUI.Message.Alert('没有权限执行此操作','error');
                        return false ;
                    }else if(msg.resultcode == 0 ){
                        BUI.Message.Alert(msg.resultinfo.errmsg ,'success');
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