<!DOCTYPE html>
<html>
<head>
    <title>文章数据添加</title>
    <meta charset="UTF-8">

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
<form action="#" method="post" class="definewidth m20" id="myform_add" style="height:330px ; overflow:auto">
    <table class="table table-bordered table-hover m10">
        <tr>
            <td class="tableleft"><s style="color: red">*</s>批次号</td>
            <td><input type="text" name="batchno" id="batchno" /></td>
            <td class="tableleft"><s style="color: red">*</s>分运单号</td>
            <td><input type="text" name="hbl" id="hbl" /></td>
            <td class="tableleft">货物抵运日期</td>
            <td><input type="text" class=" calendar" name="tally_date" id="tally_date" readonly/></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>进出口标识</td>
            <td>
                <input type="radio" name="i_e_type" value="I" checked/> 进口
                <input type="radio" name="i_e_type" value="E"/> 出口
            </td>
            <td class="tableleft">品名</td>
            <td><input type="text" name="goods_name" id="goods_name" /></td>

            <td class="tableleft" ><s style="color: red">*</s>件数</td>
            <td><input type="text" name="pieces" id="pieces" /></td>
        </tr>
        <tr>
            <td class="tableleft" ><s style="color: red">*</s>重量KG</td>
            <td><input type="text" name="weight" id="weight" /></td>
            <td class="tableleft"><s style="color: red">*</s>理货件数</td>
            <td>
                <input type="text" name="m_pieces" id="m_pieces" />
            </td>
            <td class="tableleft"><s style="color: red">*</s>理货重量</td>
            <td>
                <input type="text" name="m_weight" id="m_weight" />
            </td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>库位</td>
            <td><select id="stockposition" name="stockposition">
                    <option value="">请选择</option>
                    <?php
                    foreach($info as $key=>$row){
                        ?>
                        <option value="<?php echo $info[$key]['GOODSSITE_NO'];?>"><?php echo $info[$key]['GOODSSITE_NO'];?></option>
                    <?php }?>
                </select> </td>
            <td class="tableleft"><s style="color: red">*</s>客户</td>
            <td><input type="text" name="customer_code" id="customer_code" /></td>
            <td class="tableleft"><s style="color: red">*</s>物流企业海关备案编号</td>
            <td><input type="text" name="goodsno" id="goodsno" /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>物流企业检验检疫备案编号CTQ</td>
            <td><input type="text" name="transfercompanyciq" id="transfercompanyciq" /></td>
            <td class="tableleft"><s style="color: red">*</s>电商企业名称</td>
            <td><input type="text" name="e_business" id="e_business"/></td>
            <td class="tableleft">维护人</td>
            <td><input type="text" name="add_who" id="add_who"value="<?php echo $_SESSION['LOGIN_NO']?>" readonly/></td>
       </tr>
        <tr>
            <td class="tableleft">维护日期</td>
            <td colspan="5"><input type="text" name="add_date" id="add_date"  value="<?php echo date('Y-m-d H:i:s',time());?>" readonly/></td>
            <td class="tableleft"></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    BUI.use('bui/calendar',function(Calendar){
        var datepicker = new Calendar.DatePicker({
            trigger:'.calendar',
            autoRender : true
        });
    });
</script>
</body>
</html>
