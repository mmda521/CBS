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
<form id="searchForm" action="<?php echo site_url("tally/tally_unpacking_batch_export");?>" method="post">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="tableleft">总单号</td>
            <td><input type="text" name="mbl" id="mbl"/></td>
            <td class="tableleft">批次号</td>
            <td><input type="text" name="batchno" id="batchno"/></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">
                <button type="button" class="btn btn-primary"  id="btnSave" onclick="common_request(1)">查询</button>&nbsp;
                <button type="reset" class="btn btn-primary" id="btnSave">重置</button>
            </td>
        </tr>
		<button type="submit" class="btn btn-success" >导出</button>&nbsp;&nbsp;
    </table>
</form>
    <table class="table table-bordered table-hover definewidth">
        <thead>
        <tr>
            <th>总单号</th>
            <th>批次号</th>
            <th>理货类型</th>
            <th>布控状态</th>
            <th>理货状态</th>
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
        var url="<?php echo site_url("tally/tally_unpacking_search_ajax_data");?>?inajax=1";
        var data_ = {
            'page':page,
            'time':<?php echo time();?>,
            'action':'ajax_data',
            'batchno':$("#batchno").val(),
            'mbl':$("#mbl").val(),
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
                        shtml+='<td>'+list[i]['MBL']+'</td>';
                        shtml+='<td>'+list[i]['BATCHNO']+'</td>';
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
    function ajax_data(page){
        common_request(page);
    }
    function inser(){
        /*var data_=$("#MBL").val();
         if(!data_){
         BUI.Message.Alert('请先保存总运单信息','error');
         return
         }*/
        var Overlay = BUI.Overlay
        var dialog = new Overlay.Dialog({
            title:"添加新闻类别数据",
            width:200,
            height:100,
            buttons:[],
            loader : {
                url : '<?php echo site_url('tally/inser');?>',
                autoLoad : false, //不自动加载
                params : {"showpage":"1"},//附加的参数
                lazyLoad : true //不延迟加载
            },
            mask:true,//遮罩层是否开启
            closeAction : 'destroy',
            success:function(){
                submit_inser(); //添加处理
                this.close();

            }
        });
        dialog.show();
        dialog.get('loader').load();
    }

    function submit_inser(){
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
</script>