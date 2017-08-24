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
  <div class="demo-content">
<style type="text/css">
  .btns{
    margin-top: 20px;
  }
  .button{
    margin-bottom: 10px;
  }
  .bui-select-list{
    overflow: auto;
  }
</style>
    <div class="row">
      <div id="list1" class="span5">
      </div>
      <div class="btns centered span2">
        <button  class="button button-small" type="button" id="J_BtnRight">>></button>
        <button  class="button button-small" type="button" id="J_BtnLeft"><<</button>
      </div>
      
      <div id="list2"  class="span5">
      </div>
    </div>



  <script src="http://g.tbcdn.cn/fi/bui/jquery-1.8.1.min.js"></script>
  <script src="http://g.alicdn.com/bui/seajs/2.3.0/sea.js"></script>
  <script src="http://g.alicdn.com/bui/bui/1.1.21/config.js"></script>

<!-- script start --> 
    <script type="text/javascript">
          BUI.use(['bui/list'],function(List){
      
      var items1 = [
          {text:'选项1',value:'a'},
          {text:'选项2',value:'b'},
          {text:'选项3',value:'c'},
          {text:"数字值",value:3}
        ],
          items2 = [
          // {text:'选项11',value:'aa'},
          // {text:'选项22',value:'bb'},
          // {text:'选项33',value:'cc'},
          // {text:"数字值1",value:33}
        ],
        list1 = new List.Listbox({
          elCls:'bui-select-list',//默认是'bui-simple-list'
          render : '#list1',
          items : items1,
          height : 150
        }),
        list2 = new List.Listbox({
          elCls:'bui-select-list',//默认是'bui-simple-list'
          render : '#list2',
          items : items2,
          height : 150
        });
      list1.render();
      list2.render();
      $('#J_BtnRight').on('click',function(){
        var selections1 = list1.getSelection();
        list1.removeItems(selections1);
        list2.addItems(selections1);
      });
      $('#J_BtnLeft').on('click',function(){
        var selections2 = list2.getSelection();
        list2.removeItems(selections2);
        list1.addItems(selections2);
      });
      // list1.on('dblclick',function(ev){
        // var element = $(ev.domTarget).closest('li'),
            // item = list1.getItemByElement(element);
            // list1.removeItem(item);
            // list2.addItem(item);
      // });
      // list2.on('dblclick',function(ev){
        // var element = $(ev.domTarget).closest('li'),
            // item = list2.getItemByElement(element);
            // list2.removeItem(item);
            // list1.addItem(item);
      // });
      
      });
      
    </script>
<!-- script end -->
  </div>
</body>
</html>
