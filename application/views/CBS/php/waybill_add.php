<!DOCTYPE HTML>
<html>
 <head>
  <title> 搜索表单</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
  
  <div class="container">
  <h2>运单信息-[新增]</h2>
    <div class="row">
      <form id="searchForm" class="form-horizontal span24">
        <input type="hidden" name="a" value="3">
       <div class="row">
		<div class="control-group span8">
            <label class="control-label"><s>*</s>总运单号</label>
            <div class="controls">
              <input type="text" class="control-text" name="id">
            </div>
          </div>
          <div class="control-group span8">
            <label class="control-label"><s>*</s>航次航班号</label>
            <div class="controls">
              <input type="text" class="control-text" name="id">
            </div>
          </div>
		   <div class="control-group span8">
            <label class="control-label"><s>*</s>进出口标志</label>
            <div class="controls" >
              <select name="" id="" name="sex">
                <option selected></option>
                <option value="1">出口</option>	
                <option value="2">进口</option>					
              </select>
            </div>
          </div>
		  </div>
		  <div class="row">
          <div class="control-group span8">
            <label class="control-label">中文运输工具</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		   <div class="control-group span8">
            <label class="control-label">英文运输工具</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>         
		  <div class="control-group span8">
            <label class="control-label">总件数</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  </div>
		  <div class="row">
		  <div class="control-group span8">
            <label class="control-label">总重量（公斤）</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		   <div class="control-group span8">
            <label class="control-label">运输方式</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>		   
          <div class="control-group span8 ">
            <label class="control-label"><s>*</s>进港日期</label>
            <div id="range" class="controls bui-form-group"  data-rules="{dateRange:true}">
              <input name="start" class="calendar"   data-rules="{required:true}"  type="text">
            </div>
          </div>   
          </div> 	
          <div class="row">		  
		  <div class="control-group span8">
            <label class="control-label"><s>*</s>进出口口岸</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  <div class="control-group span8">
            <label class="control-label">起运港/抵运地</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  <div class="control-group span8">
            <label class="control-label">分运单份数</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  </div>
		  <div class="row">
		  <div class="control-group span8">
            <label class="control-label">起运港/抵运地</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		   <div class="control-group span8">
            <label class="control-label">分运单份数</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  <div class="control-group span8">
            <label class="control-label"><s>*</s>申报时间</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  </div>
		  <div class="row">
		  <div class="control-group span8">
            <label class="control-label"><s>*</s>申报企业检验检疫备案编号CIQ</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		   <div class="control-group span8">
            <label class="control-label"><s>*</s>申报地检验检疫代码</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		    <div class="control-group span8">
            <label class="control-label">托运货物包装种类代码</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
		  </div>
		  <div class="row">
		   <div class="control-group span8">
            <label class="control-label"><s>*</s>托运货物包装种类代码CIQ</label>
            <div class="controls">
              <input type="text" class="control-text" name="stuName">
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="search-grid-container">
      <div id="grid"></div>
    </div>

  </div>
  <div id="content" class="hide">
      <form id="J_Form" class="form-horizontal" action="edit.php?a=1">
	  
      </form>
    </div>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/config-min.js"></script>
  <script type="text/javascript">
    BUI.use('common/page');
  </script>
  <!-- 仅仅为了显示代码使用，不要在项目中引入使用-->
  <script type="text/javascript" src="<?php echo base_url();?>/webroot/CBS_Platform/assets/js/prettify.js"></script>
  <script type="text/javascript">
  //alert('<?php echo base_url();?>application/views/student.json');
    $(function () {
      prettyPrint();
    });
  </script> 
<script type="text/javascript">
  BUI.use('common/search',function (Search) {
    
    var enumObj = {"1":"男","0":"女"},
      editing = new BUI.Grid.Plugins.DialogEditing({
        contentId : 'content', //设置隐藏的Dialog内容
        autoSave : true, //添加数据或者修改数据时，自动保存
        triggerCls : 'btn-edit'   //点击表格行时触发编辑的 css
      }),
      columns = [
          {title:'总运单号',dataIndex:'id',width:80,renderer:function(v){
            return Search.createLink({
              id : 'detail' + v,
              title : '运单信息',
              text : v,
              href : 'example.php'
            });
          }},
          {title:'航次航班号',dataIndex:'name',width:100},
          {title:'进出口标志',dataIndex:'birthday',width:100,renderer:BUI.Grid.Format.dateRenderer},
          {title:'中文运输工具',dataIndex:'sex',width:60,renderer:BUI.Grid.Format.enumRenderer(enumObj)},
          {title:'英文运输工具',dataIndex:'grade',width:100},
          {title:'总件数',dataIndex:'address',width:300},
		  {title:'总重量（公斤）',dataIndex:'name',width:100},
          {title:'运输方式',dataIndex:'birthday',width:100,renderer:BUI.Grid.Format.dateRenderer},
          {title:'进港日期',dataIndex:'sex',width:60,renderer:BUI.Grid.Format.enumRenderer(enumObj)},
          {title:'进出口口岸',dataIndex:'grade',width:100},
          {title:'起运港/抵运地',dataIndex:'address',width:300},
		  {title:'分运单份数',dataIndex:'name',width:100},
          {title:'申报时间',dataIndex:'birthday',width:100,renderer:BUI.Grid.Format.dateRenderer},
          {title:'创建人',dataIndex:'sex',width:60,renderer:BUI.Grid.Format.enumRenderer(enumObj)},
          {title:'创建时间',dataIndex:'grade',width:100},
          {title:'申报企业检验检疫备案编号CIQ',dataIndex:'address',width:300},
		  {title:'申报地检验检疫代码',dataIndex:'name',width:100},
          {title:'托运货物包装种类代码',dataIndex:'birthday',width:100,renderer:BUI.Grid.Format.dateRenderer},
          {title:'托运货物包装种类代码CIQ',dataIndex:'sex',width:60,renderer:BUI.Grid.Format.enumRenderer(enumObj)},        
         
        ],
      store = Search.createStore('../../data/student.json',{
        proxy : {
          save : { //也可以是一个字符串，那么增删改，都会往那么路径提交数据，同时附加参数saveType
            addUrl : '../data/add.json',
            updateUrl : '../data/edit.json',
            removeUrl : '../data/del.php'
          }/*,
          method : 'POST'*/
        },
        autoSync : true //保存数据后，自动更新
      }),
      gridCfg = Search.createGridCfg(columns,{
        tbar : {
          items : [
            {text : '<i class="icon-plus"></i>新增',btnCls : 'button button-small',handler:addFunction},
            {text : '<i class="icon-edit"></i>删除',btnCls : 'button button-small',handler:function(){alert('编辑');}},
            {text : '<i class="icon-remove"></i>导出',btnCls : 'button button-small',handler : delFunction}
          ]
        },
        plugins : [editing,BUI.Grid.Plugins.CheckSelection,BUI.Grid.Plugins.AutoFit] // 插件形式引入多选表格
      });

    var  search = new Search({
        store : store,
        gridCfg : gridCfg
      }),
      grid = search.get('grid');

    function addFunction(){
      var newData = {isNew : true}; //标志是新增加的记录
      editing.add(newData,'name'); //添加记录后，直接编辑
    }

    //删除操作
    function delFunction(){
      var selections = grid.getSelection();
      delItems(selections);
    }

    function delItems(items){
      var ids = [];
      BUI.each(items,function(item){
        ids.push(item.id);
      });

      if(ids.length){
        BUI.Message.Confirm('确认要删除选中的记录么？',function(){
          store.save('remove',{ids : ids});
        },'question');
      }
    }

    //监听事件，删除一条记录
    grid.on('cellclick',function(ev){
      var sender = $(ev.domTarget); //点击的Dom
      if(sender.hasClass('btn-del')){
        var record = ev.record;
        delItems([record]);
      }
    });
  });
</script>

<body>
</html>  
