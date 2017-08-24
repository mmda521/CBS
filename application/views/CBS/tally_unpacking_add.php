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
<form method="post" name="myform" id="myform">
    <input type="hidden" name="action" value="doadd">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>总运单号</td>
            <td><input type="text" name="mbl" id="mbl" /></td>
            <td class="tableleft"><s style="color:red;">*</s>分运单号</td>
            <td><input type="text" name="hbl" id="hbl"  /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>批次号</td>
            <td><input type="text" name="batchno" id="batchno" /></td>
            <td class="tableleft">货物抵运日期</td>
            <td><input readonly type="text" class=" calendar" name="tally_date" id="tally_date" /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>进出口标识</td>
            <td>
                <input type="radio" name="i_e_type" value="I" checked/> 进口
                <input type="radio" name="i_e_type" value="E"/> 出口
            </td>
            <td class="tableleft">品名</td>
            <td><input type="text" name="goods_name" id="goods_name" /></td>
        </tr>
        <tr>
            <td class="tableleft" ><s style="color:red;">*</s>件数</td>
            <td><input type="text" name="pieces" id="pieces" /></td>
            <td class="tableleft" ><s style="color:red;">*</s>重量KG</td>
            <td><input type="text" name="weight" id="weight" /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>理货件数</td>
            <td>
                <input type="text" name="m_pieces" id="m_pieces" />
            </td>
            <td class="tableleft"><s style="color:red;">*</s>理货重量</td>
            <td>
                <input type="text" name="m_weight" id="m_weight"  />
            </td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>库位</td>
            <td><select id="stockposition" name="stockposition">
                    <option value="">全部</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freightlot');
                    foreach($query->result_array() as $row){?>
                        <option><?php echo $row['GOODSSITE_NO'];?></option>
                    <?php }?>
                </select> </td>
            <td class="tableleft"><s style="color:red;">*</s>客户</td>
             <td><select id="customer_name" name="customer_name">
				<option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
						 foreach($query->result_array() as $row){
                        if($row['CUSTOMER_CODE']){?>
                            <option value="<?php echo $row['CUSTOMER_CODE'];?>"><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php } }?>
                </select> </td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>物流企业海关备案编号</td>
            <td><input type="text" name="goodsno" id="goodsno"  /></td>
            <td class="tableleft"><s style="color:red;">*</s>物流企业检验检疫备案编号CTQ</td>
            <td><input type="text" name="transfercompanyciq" id="transfercompanyciq" /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color:red;">*</s>电商企业名称</td>
            <td><input type="text" name="e_business" id="e_business" /></td>
            <td class="tableleft">维护人</td>
            <td><input readonly type="text" name="add_who" id="add_who" value="<?php echo $_SESSION['LOGIN_NO'];?>" /></td>
        </tr>
        <tr>
            <td class="tableleft">维护日期</td>
            <td colspan="3"><input readonly type="text" name="add_date" id="add_date" value="<?php echo date('Y-m-d h:i:s',time());?>" /></td>
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
