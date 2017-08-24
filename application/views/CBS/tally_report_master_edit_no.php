<?php
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
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
<form action="#" method="post" class="definewidth m20" id="myform_edit" style="height:330px ; overflow:auto">
    <input type="hidden" name="guid" id="guid"  value="<?php echo $info['GUID']; ?>"/>
    <input type="hidden" name="mbl" id="mbl"  value="<?php echo $info['MBL']; ?>"/>
    <table class="table table-bordered table-hover m10">
        <tr>
            <td class="tableleft"><s style="color: red">*</s>批次号</td>
            <td><input type="text" name="batchno" id="batchno" value="<?php echo $info['BATCHNO']; ?>"/></td>
            <td class="tableleft"><s style="color: red">*</s>分运单号</td>
            <td><input type="text" name="hbl" id="hbl" value="<?php echo $info['HBL']; ?>"/></td>
            <td class="tableleft">货物抵运日期</td>
            <td><input type="text" class=" calendar" name="tally_date" id="tally_date" value="<?php echo $info['TALLY_DATE']; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>进出口标识</td>
            <td>
                <input type="radio" name="i_e_type" value="I" <?php if($info['I_E_TYPE'] == 'I' ){echo "checked";}?>/> 进口
                <input type="radio" name="i_e_type" value="E" <?php if($info['I_E_TYPE'] == 'E' ){echo "checked";}?>/> 出口
            </td>
            <td class="tableleft">品名</td>
            <td><input type="text" name="goods_name" id="goods_name" value="<?php echo $info['GOODS_NAME']; ?>"/></td>

            <td class="tableleft" ><s style="color: red">*</s>件数</td>
            <td><input type="text" name="pieces" id="pieces" value="<?php echo $info['PIECES']; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft" ><s style="color: red">*</s>重量KG</td>
            <td><input type="text" name="weight" id="weight" value="<?php echo $info['WEIGHT']; ?>"/></td>
            <td class="tableleft"><s style="color: red">*</s>理货件数</td>
            <td>
                <input type="text" name="m_pieces" id="m_pieces" value="<?php echo $info['M_PIECES']; ?>"/>
            </td>
            <td class="tableleft"><s style="color: red">*</s>理货重量</td>
            <td>
                <input type="text" name="m_weight" id="m_weight" value="<?php echo $info['M_WEIGHT']; ?>"/>
            </td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>库位</td>
            <td><select id="stockposition" name="stockposition">
			<option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freightlot');
                    foreach($query->result_array() as $row){
                        if($info['STOCKPOSITION']==$row['GOODSSITE_NO']){?>
                            <option selected="selected"><?php echo $row['GOODSSITE_NO'];?></option>
                        <?php }else{?>
                            <option><?php echo $row['GOODSSITE_NO'];?></option>
                        <?php } }?>
                </select> </td>
            <td class="tableleft"><s style="color: red">*</s>客户</td>
            <td><input type="text" name="customer_code" id="customer_code" value="<?php echo $info['CUSTOMER_CODE']; ?>"/></td>
            <td class="tableleft"><s style="color: red">*</s>物流企业海关备案编号</td>
            <td><input type="text" name="goodsno1" id="goodsno1" value="<?php echo $info['GOODSNO']; ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>物流企业检验检疫备案编号CTQ</td>
            <td><input type="text" name="transfercompanyciq" id="transfercompanyciq" value="<?php echo $info['TRANSFERCOMPANYCIQ']; ?>"/></td>
            <td class="tableleft"><s style="color: red">*</s>电商企业名称</td>
            <td><input type="text" name="e_business" id="e_business" value="<?php echo $info['E_BUSINESS']; ?>"/></td>
            <td class="tableleft">维护人</td>
            <td><input type="text" name="add_who" id="add_who" value="<?php echo $info['ADD_WHO']; ?>" readonly/></td>
        </tr>
        <tr>
            <td class="tableleft">维护日期</td>
            <td><input type="text" name="add_date" id="add_date"  value="<?php echo date('Y-m-d h:i:s',time());?>"readonly/></td>
            <td class="tableleft"></td>
        </tr>
    </table>
</form>
</body>
</html>
