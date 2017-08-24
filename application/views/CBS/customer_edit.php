<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE HTML>
<html>
 <head>
  <title> 搜索表单</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<form  class="definewidth m2"  name="edit_form" id="edit_form" style="height:330px ; overflow:auto">
<input type="hidden" name="action" value="doadd">
<table class="table table-bordered table-hover m10">

    <tr>
        <td class="tableleft"><span>*</span>检索号</td>
        <td><input type="text" name="INDEX_NO" id="INDEX_NO" value="<?php if(isset($info[0]['INDEX_NO'])) echo $info[0]['INDEX_NO']; ?>"  /></td>
        <td class="tableleft"><span>*</span>客户编码</td>
		 <td><input type="text" name="CUSTOMER_CODE" id="CUSTOMER_CODE" value="<?php if(isset($info[0]['CUSTOMER_CODE'])) echo $info[0]['CUSTOMER_CODE']; ?>"  /></td>            
        <td class="tableleft"><span>*</span>客户名称</td>
		<td><input type="text" name="CUSTOMER_NAME" id="CUSTOMER_NAME" value="<?php if(isset($info[0]['CUSTOMER_NAME'])) echo $info[0]['CUSTOMER_NAME']; ?>"  /></td>            
   </tr>
    <tr>
        <td class="tableleft"><span>*</span>客户简称</td>
       <td><input type="text" name="CUSTOMER_SNAME" id="CUSTOMER_SNAME" value="<?php if(isset($info[0]['CUSTOMER_SNAME'])) echo $info[0]['CUSTOMER_SNAME']; ?>"/></td>         
		<td class="tableleft">英文名称</td>
        <td><input type="text" name="CUSTOMER_ENGLISH" id="CUSTOMER_ENGLISH" value="<?php if(isset($info[0]['CUSTOMER_ENGLISH'])) echo $info[0]['CUSTOMER_ENGLISH']; ?>" /></td>
    
       
       <input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/>
    
    
        <td class="tableleft"><span>*</span>客户类型</td>
        <td>
                <select  id="CUSTOMER_TYPE" name="CUSTOMER_TYPE">
                          <option value="">全部</option>
                          <option value="1" <?php $selected='selected=selected'; if(isset($info[0]['CUSTOMER_TYPE'])&&($info[0]['CUSTOMER_TYPE']=='1')) echo $selected;?>>快递公司</option>
                    </select>
        </td>
    </tr>   
 <tr>
        <td class="tableleft">发票抬头</td>
        <td><input type="text" name="INVOICE_NAME" id="INVOICE_NAME" value="<?php if(isset($info[0]['INVOICE_NAME'])) echo $info[0]['INVOICE_NAME']; ?>" /></td>
   
        <td class="tableleft">发票地址</td>
        <td><input type="text" name="INVOICE_ADDR" id="INVOICE_ADDR" value="<?php if(isset($info[0]['INVOICE_ADDR'])) echo $info[0]['INVOICE_ADDR']; ?>" /></td>
        <td class="tableleft">银行账号</td>
        <td><input type="text" name="BANK_ACCOUNT" id="BANK_ACCOUNT" value="<?php if(isset($info[0]['BANK_ACCOUNT'])) echo $info[0]['BANK_ACCOUNT']; ?>" /></td>
 </tr>
    <tr>
        <td class="tableleft">税务登记号</td>
        <td><input type="text" name="TAX_REGISTID" id="TAX_REGISTID" value="<?php if(isset($info[0]['TAX_REGISTID'])) echo $info[0]['TAX_REGISTID']; ?>"/></td>
        <td class="tableleft">业务单位</td>
        <td><input type="text" name="BUSINESS_ID" id="BUSINESS_ID" value="<?php if(isset($info[0]['BUSINESS_ID'])) echo $info[0]['BUSINESS_ID']; ?>" /></td>
   
        <td class="tableleft">注册名称</td>
        <td><input type="text" name="COMPANY_NAME" id="COMPANY_NAME" value="<?php if(isset($info[0]['COMPANY_NAME'])) echo $info[0]['COMPANY_NAME']; ?>" /></td>
    </tr>
 <tr>
        <td class="tableleft">注册地址</td>
        <td><input type="text" name="COMPANY_ADDR" id="COMPANY_ADDR" value="<?php if(isset($info[0]['COMPANY_ADDR'])) echo $info[0]['COMPANY_ADDR']; ?>" /></td>
   
        <td class="tableleft">邮政编码</td>
        <td><input type="text" name="POSTCODE" id="POSTCODE" value="<?php if(isset($info[0]['POSTCODE'])) echo $info[0]['POSTCODE']; ?>" /></td>
        <td class="tableleft">网站</td>
        <td><input type="text" name="URL" id="URL" value="<?php if(isset($info[0]['URL'])) echo $info[0]['URL']; ?>" /></td>
 </tr>
    <tr>
        <td class="tableleft">法人</td>
        <td><input type="text" name="LAWER" id="LAWER" value="<?php if(isset($info[0]['LAWER'])) echo $info[0]['LAWER']; ?>" /></td>
        <td class="tableleft">注册资金</td>
        <td><input type="text" name="REGISTERED_FUND" id="REGISTERED_FUND" value="<?php if(isset($info[0]['REGISTERED_FUND'])) echo $info[0]['REGISTERED_FUND']; ?>"/></td>
   
        <td class="tableleft">电话</td>
        <td><input type="text" name="TEL" id="TEL" value="<?php if(isset($info[0]['TEL'])) echo $info[0]['TEL']; ?>" /></td>
    </tr> 
	<tr>
        <td class="tableleft">传真</td>
        <td><input type="text" name="FAX" id="FAX" value="<?php if(isset($info[0]['FAX'])) echo $info[0]['FAX']; ?>" /></td>
   
        <td class="tableleft">状态</td>
        <td>
			 <select id="STATUS" name="STATUS">      
                   <option value="Y" <?php $selected='selected=selected'; if(isset($info[0]['STATUS'])&&($info[0]['STATUS']=='Y')) echo $selected;?>>启用</option>
                   <option value="N" <?php $selected='selected=selected'; if(isset($info[0]['STATUS'])&&($info[0]['STATUS']=='N')) echo $selected;?>>停用</option>
                   <option value="YN" <?php $selected='selected=selected'; if(isset($info[0]['STATUS'])&&($info[0]['STATUS']=='YN')) echo $selected;?>>忽略</option>             
			</select>
			
        </td>
        <td class="tableleft">业务负责人</td>
        <td><input type="text" name="BUSINESS_USER" id="BUSINESS_USER" value="<?php if(isset($info[0]['BUSINESS_USER'])) echo $info[0]['BUSINESS_USER']; ?>" /></td>
    </tr>
    <tr>
        <td class="tableleft">取货地址</td>
        <td><input type="text" name="PICKUP_ADDR" id="PICKUP_ADDR" value="<?php if(isset($info[0]['PICKUP_ADDR'])) echo $info[0]['PICKUP_ADDR']; ?>" /></td>

        <td class="tableleft">卸货地代码</td>
        <td><input type="text" name="DISCHARGE_PLACE" id="DISCHARGE_PLACE" value="<?php if(isset($info[0]['DISCHARGE_PLACE'])) echo $info[0]['DISCHARGE_PLACE']; ?>" /></td>
   
        <td class="tableleft"><span>*</span>企业海关备案编号</td>
        <td><input type="text" name="LINENOINDEX" id="LINENOINDEX" value="<?php if(isset($info[0]['LINENOINDEX'])) echo $info[0]['LINENOINDEX']; ?>" /></td>
    </tr>
    <tr>
        <td class="tableleft" >备注</td>
        <td><input type="text" name="REMARK1" id="REMARK1" style="width:200px; height:30px;" value="<?php if(isset($info[0]['REMARK1'])) echo $info[0]['REMARK1']; ?>"/></td>
    </tr>
</table>
</form>
</body>
</html>  


 