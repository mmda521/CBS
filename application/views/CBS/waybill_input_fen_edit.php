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
 <form action="#"  name="edit_form" id="edit_form"  method="post" style="height:280px ; overflow:auto">
   <table class="table table-bordered table-hover m10">
           
			<tr>
			      <td class="tableleft"><span>*</span>分运单号</td>
                  <td><input type="text" name="HBL" id="HBL" value="<?php if(isset($info[0]['HBL'])) echo $info[0]['HBL']; ?>"/></td>
				  
			      <td class="tableleft">英文货物名称</td>
                  <td><input type="text" name="GOODS_NAME_EN" id="GOODS_NAME_EN" value="<?php if(isset($info[0]['GOODS_NAME_EN'])) echo $info[0]['GOODS_NAME_EN']; ?>"/></td>				 
				 
		   </tr>
		   <tr>
			     <td class="tableleft"><span>*</span>主要货物名称</td>
                  <td><input type="text" name="GOODS_NAME_IMPORT" id="GOODS_NAME_IMPORT" value="<?php if(isset($info[0]['GOODS_NAME_IMPORT'])) echo $info[0]['GOODS_NAME_IMPORT']; ?>"/></td>		
			      <td class="tableleft"><span>*</span>件数</td>
                  <td><input type="text" name="NUM" id="NUM" value="<?php if(isset($info[0]['NUM'])) echo $info[0]['NUM']; ?>"/></td>
                 
		   </tr>
           <tr>
		          <td class="tableleft"><span>*</span>重量（公斤）</td>
                  <td><input type="text" name="WEIGHT" id="WEIGHT" value="<?php if(isset($info[0]['WEIGHT'])) echo $info[0]['WEIGHT']; ?>"/></td>
                  <td class="tableleft">价值</td>
                  <td><input type="text" name="PRICE" id="PRICE" value="<?php if(isset($info[0]['PRICE'])) echo $info[0]['PRICE']; ?>"/></td>  
		          
				  
		   </tr>	
            <tr>
			       <td class="tableleft">币制</td>
					 <td><select id="CURRENCY" name="CURRENCY">
					 <option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  kjw_currtype');
						 foreach($query->result_array() as $row){
                        if($info[0]['CURRENCY']==$row['CURRTYPECODE']){?>
                            <option selected="selected" value="<?php echo $row['CURRTYPECODE'];?>"><?php echo $row['CURRTYPENAME'];?></option>
                        <?php }else{?>						    
                            <option value="<?php echo $row['CURRTYPECODE'];?>"><?php echo $row['CURRTYPENAME'];?></option>
                        <?php } }?>
                </select> </td>
			      <td class="tableleft"><span>*</span>申报时间</td>
                  <td><input readonly type="text" name="APP_DATE" id="APP_DATE" class="calendar" value="<?php if(isset($info[0]['APP_DATE'])) echo $info[0]['APP_DATE']; ?>"/></td>
                 
                
		   </tr>
			 <tr>	
			      <td class="tableleft">收件人</td>
                  <td><input type="text" name="RECV_USER" id="RECV_USER" value="<?php if(isset($info[0]['RECV_USER'])) echo $info[0]['RECV_USER']; ?>"/></td>
                 			 
			      <td class="tableleft">发件人</td>
                  <td><input type="text" name="SEND_USER" id="SEND_USER" value="<?php if(isset($info[0]['SEND_USER'])) echo $info[0]['SEND_USER']; ?>"/></td>
				 
			 
			 </tr>	
                <input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/>			 
             <tr>
			   <td class="tableleft"><span>*</span>监管场所海关备案编码</td>
                  <td><input type="text" name="APPLIEDCOMPANY" id="APPLIEDCOMPANY" value="<?php if(isset($info[0]['APPLIEDCOMPANY'])) echo $info[0]['APPLIEDCOMPANY']; ?>"/></td>
				   <td class="tableleft"><span>*</span>物流企业检验检疫备案编号CIQ</td>
                  <td><input type="text" name="TRANSFERCOMPANYCIQ" id="TRANSFERCOMPANYCIQ" value="<?php if(isset($info[0]['TRANSFERCOMPANYCIQ'])) echo $info[0]['TRANSFERCOMPANYCIQ']; ?>"/></td>	
			   </tr>
			 <tr>
			  <td class="tableleft"><span>*</span>客户</td>                 
				  <td><select id="CUSTOMER_CODE" name="CUSTOMER_CODE">
				  <option value="">请选择</option>
                    <?php
                    $query = $this->db->query('SELECT * FROM  con_freight_agent');
						 foreach($query->result_array() as $row){
                        if($info[0]['CUSTOMER_CODE']==$row['CUSTOMER_CODE']){?>
                            <option selected="selected" value="<?php echo $row['CUSTOMER_CODE'];?>"><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php }else{?>
						    
                            <option value="<?php echo $row['CUSTOMER_CODE'];?>"><?php echo $row['CUSTOMER_NAME'];?></option>
                        <?php } }?>
                </select> </td>
				  
			  <td class="tableleft"><span>*</span>物流企业海关备案编号</td>
                  <td><input type="text" name="GOODSNO" id="GOODSNO" value="<?php if(isset($info[0]['GOODSNO'])) echo $info[0]['GOODSNO']; ?>"/></td>
				  
			 </tr>
			 <tr>
			  <td class="tableleft"><span>*</span>电商企业名称</td>
                  <td colspan="3"><input type="text" name="E_BUSINESS" id="E_BUSINESS" value="<?php if(isset($info[0]['E_BUSINESS'])) echo $info[0]['E_BUSINESS']; ?>"/></td>
			
			 </tr>
			   <input type="hidden" name="GUID" id="GUID" value="<?php if(isset($info[0]['GUID'])) echo $info[0]['GUID']; ?>"/>
			 <!-- <a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/waybill_input_add");?>">新增明细<span class="glyphicon glyphicon-plus"></span></a> &nbsp;&nbsp;         
              <a class="btn btn-success" id="addnew" href="<?php echo site_url("waybill/waybill_input_add");?>">复制<span class="glyphicon glyphicon-plus"></span></a>     -->             
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
