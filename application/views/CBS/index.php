<!DOCTYPE HTML>
<html>
 <head>
  <title>陆港跨境场站系统（出口）</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="<?php echo base_url();?>/webroot/CBS_Platform/assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>
  <div class="header">
    <!--
      <div class="dl-title">
        <a href="http://sc.chinaz.com" title="文档库地址" target="_blank"><!-- 仅仅为了提供文档的快速入口，项目中请删除链接 
          <span class="lp-title-port">陆港</span><span class="dl-title-text">跨境场站系统（出口）</span>
        </a>
      </div>
-->
    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo $_SESSION['LOGIN_NO']; ?></span><a href="<?php echo site_url("login/login_out");?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title">贴心小秘书<s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
          <?php
          $query = $this->db->query('SELECT id,name,pid as parentid,url,status,addtime,disorder ,url_type,collapsed,closeable from eci_menu where pid=0');
              foreach($query->result_array() as $l_k=>$l_v){
                  $selected= '' ;
                  if($l_k == 0){
                      $selected = 'dl-selected';
                  }

                  ?>
                  <li class="nav-item <?php echo $selected ;?>"><div class="nav-item-inner nav-home"><?php echo $l_v['name'];?></div></li>
                  <?php
              }

          ?>
       <!-- <li class="nav-item"><div class="nav-item-inner nav-order">表单页</div></li>
        <li class="nav-item"><div class="nav-item-inner nav-inventory">搜索页</div></li>
        <li class="nav-item"><div class="nav-item-inner nav-supplier">详情页</div></li> -->
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="<?php echo base_url();?>webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>webroot/CBS_Platform/assets/js/bui.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>webroot/CBS_Platform/assets/js/config.js"></script>
  <script>
      $(function(){
          nav();
      });

  </script>
  <script type="text/javascript" >
      function nav(){
          BUI.use('common/main',function(){
              // new PageUtil.MainPage({
              //modulesConfig : config
              //});
              //获取json
              $.getJSON('<?php echo site_url('common/get_menu');?>',function(config){
                  //console.dir(config);
                  new PageUtil.MainPage({
                      modulesConfig : config
                  });

              });
          });

      }
  </script>
</body>
</html>