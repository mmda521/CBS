<?php
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>用户添加</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/style.css" />
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/validate/validator.js"></script>
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
    <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("tally/tally_unpacking_search_add");?>">拆包理货查询</a>
</div>
<form action="<?php echo site_url("tally/tally_unpacking_search_add_ajax_data");?>" method="post" class="definewidth m2"  name="myform" id="myform">
    <table class="table table-bordered table-hover m10">
        <tr>
            <td class="tableleft">总运单号</td>
            <td><input type="text" name="mbl" id="mbl"/></td>
            <td class="tableleft">批次号</td>
            <td><input type="text" name="batchno" id="batchno"/></td>
            </tr>
        <tr>
            <td class="tableleft">理货类型</td>
            <td>
                <select  name="batchtype" >
                    <option value="0">批次理货</option>
                    <option value="1">拆包理货</option>
                </select>
            </td>
            <td class="tableleft">布控状态</td>
            <td>
                <select  name="batchcontrol" >
                    <option value="0">未布控</option>
                    <option value="1">布控</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center;">
                <button type="submit" class="btn btn-primary"  id="btnSave">保存</button>&nbsp;
                <button type="reset" class="btn btn-primary" id="btnSave">重置</button>
            </td>
        </tr>
    </table>
</form>
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
    $(function () {
        $("#btnSave").click(function(){
            if($("#myform").Valid() == false || !$("#myform").Valid()) {
                return false ;
            }
        });
    });
</script>
