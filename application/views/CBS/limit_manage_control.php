<?php
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>角色</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/webroot/CBS_Platform/Css/style.css" />
    <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/Js/jquery-1.8.1.min.js"></script>


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
<form action="<?php echo site_url("user/limit_control_ajax_data");?>" method="post" name="">
    <input type="hidden" name="role_id" value="<?php echo $this->input->get_post("role_id");?>">
    <?php
    $list=array();
    $role_id=$this->input->get_post("role_id");
    $query = $this->db->query("SELECT * FROM  eci_role_function where ROLE_ID='$role_id'");
    foreach($query->result_array() as $row){
            $list = explode(',', $row['PROGRAM_ID']);
    }
    ?>
    <table class="table table-bordered table-hover definewidth m10">
        <?php
        if(isset($info) && $info){
            foreach($info as $k=>$v) {?>
                <tr><td><input type="checkbox" name="role[]" value="<?php echo $v['id'];?>"<?php if(in_array($v['id'],$list)){echo "checked";}?>> <?php echo $v['name'];?></td></tr>
                <?php foreach($v['items'] as $t_k=>$t_v) {?>
                <tr><td><input type="checkbox" name="role[]" value="<?php echo $t_v['id'];?>"<?php if(in_array($t_v['id'],$list)){echo "checked";}?>> <?php echo $t_v['name'];?></td>
                    <td><?php foreach($t_v['items'] as $three_key=>$three_val) {?>
                        <input type="checkbox" name="role[]" value="<?php echo $three_val['id'];?>"<?php if(in_array($three_val['id'],$list)){echo "checked";}?>> <?php echo $three_val['name'];?>
           <?php }?></td></tr>
               <?php }
            }
        }?>

        <tr >
            <td colspan="2">
                <input type="submit" value="提&nbsp;交" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
