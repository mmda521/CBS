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
    <a  class="button button-primary" href="<?php echo site_url("tally/tally_batch_add")?>">导出</a>
<form id="searchForm" >
    <table class="table table-bordered table-hover">
        <tr>
            <td class="tableleft" style="text-align:center">分单号</td>
            <td><input type="text" name="hbl" id="hbl" style="align:center"/></td>
            <td class="tableleft">联检单位</td>
            <td>
                <select  id="pass_type" >
                    <option value="">全部</option>
                    <option value="A">海关</option>
                    <option value="B">国检</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center">
                <button type="button" class="btn btn-primary"  id="btnSearch" onclick="common_request(1)">查询</button>&nbsp;
                <button type="reset" class="btn btn-primary" >重置</button>
            </td>
        </tr>
    </table>
</form>
    <table class="table table-bordered table-hover definewidth">
        <thead>
        <tr>
            <th>批次号</th>
            <th>分单号</th>
            <th>状态</th>
            <th>时间</th>
            <th>联检单位</th>
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
        var url="<?php echo site_url("package/package_sort_ajax_data");?>?inajax=1";
        var data_ = {
            'page':page,
            'time':<?php echo time();?>,
            'action':'ajax_data',
            'hbl':$("#hbl").val(),
            'pass_type':$("#pass_type").val()
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
                        shtml+='<td>'+list[i]['BATCHNO']+'</td>';
                        shtml+='<td>'+list[i]['HBL']+'</td>';
                        shtml+='<td>'+list[i]['DISCHARGED_TYPE']+'</td>';
                        shtml+='<td>'+list[i]['DISCHARGED_DATE']+'</td>';
                        shtml+='<td>'+list[i]['PASS_TYPE']+'</td>';
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

</script>