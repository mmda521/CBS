
<!DOCTYPE html>
<html>
<head>
    <title>文章数据添加</title>
    <meta charset="UTF-8">

   <style type="text/css">
        body {
            padding-bottom: 0px;
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
<form action="#" method="post"  id="myform_add" style="overflow:auto;">
    <table class="table table-bordered table-hover ">
        <tr>
            <td class="tableleft"><s style="color: red">*</s>批次号</td>
            <td><input type="text"  name="batchno" id="batchno" required="true" /></td>
            <td class="tableleft"><s style="color: red">*</s>分运单号</td>
            <td><input type="text" name="hbl" id="hbl"  /></td>
            <td class="tableleft"><s style="color: red">*</s>主要货物名称</td>
            <td><input type="text"  name="goods_name_import" id="goods_name_import"  /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>件数</td>
            <td><input type="text" name="num" id="num"  /></td>
            <td class="tableleft" ><s style="color: red">*</s>重量(KG)</td>
            <td><input type="text" name="weight" id="weight"  /></td>
            <td class="tableleft" >价值</td>
            <td><input type="text" name="price" id="price"  /></td>
        </tr>
        <tr>
            <td class="tableleft">币值</td>
            <td>
                <input type="text" name="currency" id="currency"  />
            </td>
            <td class="tableleft"><s style="color: red">*</s>申报时间</td>
            <td>
                <input type="text" class="calendar" name="app_date" id="app_date" readonly/>
            </td>
            <td class="tableleft">收件人</td>
            <td><input type="text" name="recv_user" id="recv_user"  /></td>
        </tr>
        <tr>
            <td class="tableleft">发件人</td>
            <td><input type="text" name="send_user" id="send_user"  /></td>
            <td class="tableleft"><s style="color: red">*</s>监管场所海关备案编码</td>
            <td><input type="text" name="appliedcompany" id="appliedcompany"  /></td>
            <td class="tableleft"><s style="color: red">*</s>物流企业检验检疫备案编号CIQ</td>
            <td><input type="text" name="transfercompanyciq" id="transfercompanyciq"  /></td>
        </tr>
        <tr>
            <td class="tableleft"><s style="color: red">*</s>客户</td>
			 <td><select id="customer_code" name="customer_code">
				<option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
						 foreach($query->result_array() as $row){
                        if($row['CUSTOMER_CODE']){?>
                            <option value="<?php echo $row['CUSTOMER_CODE'];?>"><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php } }?>
                </select> </td>
            <td class="tableleft"><s style="color: red">*</s>物流企业海关备案编号</td>
            <td><input type="text" name="goodsno1" id="goodsno1"  /></td>
            <td class="tableleft"><s style="color: red">*</s>电商企业名称</td>
            <td><input type="text" name="e_business" id="e_business"  /></td>
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
