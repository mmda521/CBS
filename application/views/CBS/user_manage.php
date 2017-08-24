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
   <form id="searchForm" action="<?php echo site_url("user/user_manage_export");?>" method="post">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="tableleft">登录账号</td>
            <td><input type="text" name="login_no" id="login_no"/></td>
            <td class="tableleft">用户名称</td>
            <td><input type="text" name="user_name" id="user_name"/></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center">
                <button type="button" class="btn btn-primary"  id="btnSearch" onclick="common_request(1)">查询</button>&nbsp;
                <button type="reset" class="btn btn-primary" >重置</button>
            </td>
        </tr>
		 <a  class="btn btn-success" href="<?php echo site_url("user/user_manage_add")?>">新增</a> <a class="btn btn-success" type="button" onclick="del()">删除</a><button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
    </table>
</form>
    <table class="table table-bordered table-hover definewidth">
        <thead>
        <tr>
            <th><input type="checkbox" id="selAll" onclick="selectAll()"></th>
            <th>编辑</th>
            <th>公司</th>
            <th>登录账号</th>
            <th>用户名称</th>
            <th>创建日期</th>
            <th>机构管理员</th>
            <th>操作点</th>
            <th>设置密码</th>
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
        var url="<?php echo site_url("user/user_manage_ajax_data");?>?inajax=1";
        var data_ = {
            'page':page,
            'time':<?php echo time();?>,
            'action':'ajax_data',
            'login_no':$("#login_no").val(),
            'user_name':$("#user_name").val()
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
                        shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['USER_ID']+'"></td>';
                        shtml+='<td><a href="<?php echo site_url('user/user_manage_edit');?>?user_id='+list[i]['USER_ID']+'" class="icon-edit"</a></td>';
                        shtml+='<td>'+list[i]['COMPANY_CODE']+'</td>';
                        shtml+='<td>'+list[i]['LOGIN_NO']+'</td>';
                        shtml+='<td>'+list[i]['USER_NAME']+'</td>';
                        shtml+='<td>'+list[i]['CREATE_DATE']+'</td>';
                        shtml+='<td>'+list[i]['EP_ADMIN']+'</td>';
                        shtml+='<td>'+list[i]['UDF1']+'</td>';
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
                url: "<?php echo site_url('user/user_manage_del_ajax_data');?>" ,
                data: {"user_id":data},
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