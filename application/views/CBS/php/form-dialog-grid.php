<!DOCTYPE HTML>
<html>
 <head>
  <title> 表格跟弹出框联动</title>
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
     <form id ="J_Form" class="form-horizontal" method="post">
      <!--    -->
      <h3>基本信息</h3>
      <div class="row">
        <div class="control-group span12">
          <label class="control-label"><s>*</s>学生姓名：</label>
          <div class="controls">
            <input name="sname" type="text" class="control-text" data-rules="{required:true}">
          </div>
        </div>
        <div class="control-group span12">
          <label class="control-label"><s>*</s>学生编号：</label>
          <div class="controls">
            <input name="sid" type="text" class="control-text" data-rules="{required:true}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="control-group span12">
          <label class="control-label">性别：</label>
          <div class="controls">
            <select name="sex">
              <option value="0">男</option>
              <option value="1">女</option>
            </select>
          </div>
        </div>
        <div class="control-group12 span12">
          <label class="control-label"><s>*</s>出生日期：</label>
          <div class="controls">
            <input name="birthday" type="text" class="calendar" data-rules="{required:true}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="control-group span12">
          <label class="control-label"><s>*</s>家庭住址：</label>
          <div class="controls">
            <input name="address" type="text" class="span8 span-width control-text"  data-rules="{required:true}">
          </div>
        </div>
      </div>
      <hr/>
      <h3>学校信息</h3>
      <div class="row">
        <div class="control-group span12">
          <label class="control-label"><s>*</s>学校名称：</label>
          <div class="controls">
            <input name="" type="text" class=" control-text  span8 span-width" data-rules="{required:true}">
          </div>
        </div>
        <div class="control-group span12">
          <label class="control-label"><s>*</s>入学日期：</label>
          <div class="controls bui-form-group" data-rules="{dateRange:true}" >
            <input name="start" type="text" class="calendar" data-rules="{required:true}"><span> - </span><input name="end" type="text" class="calendar" data-rules="{required:true}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="control-group span24">
          <label class="control-label"><s>*</s>学校地址：</label>
          <div class="controls">
            <input type="text" class="control-text span8 span-width"  data-rules="{required:true}">
          </div>
        </div>
        
      </div>
      <div class="row">
        <div class="control-group span24">
          <label class="control-label">备注：</label>
          <div class="controls control-row4">
            <textarea name="" id="" class="span8 span-width"></textarea>
          </div>
        </div>
      </div>
      <hr/>

      <h3>教育经历</h3>
      <div class="row">
        <div class="span21 offset3 control-row-auto">
          <div id="grid"></div>
          <input type="hidden" name="eduation">
        </div>
      </div>
      
      <div class="row">
        <div class="form-actions offset3">
          <button type="submit" class="button button-primary">保存</button>
          <button type="reset" class="button">重置</button>
        </div>
      </div>
    </form>
    <div id="content" class="hide">
      <form id="J_Form" class="form-horizontal">
        <div class="row">
          <div class="control-group span8">
            <label class="control-label"><s>*</s>学校名称：</label>
            <div class="controls">
              <input name="school" type="text" data-rules="{required:true}" class="input-normal control-text">
            </div>
          </div>
          <div class="control-group span8">
            <label class="control-label"><s>*</s>学生类型：</label>
            <div class="controls">
              <select  data-rules="{required:true}"  name="type" class="input-normal"> 
                <option value="">请选择</option>
                <option value="zou">走读</option>
                <option value="zhu">住校</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="control-group span15 ">
            <label class="control-label">在校日期：</label>
            <div id="range" class="controls bui-form-group" data-rules="{dateRange : true}">
              <input name="enter" class="calendar" type="text"><label>&nbsp;-&nbsp;</label><input name="outter" class="calendar" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="control-group span15">
            <label class="control-label">备注：</label>
            <div class="controls control-row4">
              <textarea name="memo" class="input-large" type="text"></textarea>
            </div>
          </div>
        </div>
      </form>
    </div>
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
    $(function () {
      prettyPrint();
    });
  </script> 
<script type="text/javascript">
  BUI.use(['bui/grid','bui/data','bui/form'],function (Grid,Data,Form) {

    var columns = [{title : '学校名称',dataIndex :'school'},
            {title : '入学日期',dataIndex :'enter'},
            {title : '毕业日期',dataIndex :'outter'},
            {title : '备注',dataIndex :'memo',width:200},
            {title : '操作',renderer : function(){
              return '<span class="grid-command btn-edit">编辑</span>';
            }}
          ],
      //默认的数据
      data = [
        {id:'1',school:'武汉第一初级中学',enter:'1999-09-01',type: 'zou',outter:'2002-07-01',memo:'表现优异，多次评为三好学生'},
        {id:'2',school:'武汉第一高级中学',enter:'2002-09-01',type: 'zou',outter:'2005-07-01',memo:'表现优异，多次评为三好学生'}
      ],
      store = new Data.Store({
        data:data
      }),
      editing = new Grid.Plugins.DialogEditing({
        contentId : 'content',
        triggerCls : 'btn-edit',
        eidtor : {
          focusable : false
        }
      }),
      grid = new Grid.Grid({
        render : '#grid',
        columns : columns,
        width : 700,
        forceFit : true,
        store : store,
        plugins : [Grid.Plugins.CheckSelection,editing],
        tbar:{
          items : [{
            btnCls : 'button button-small',
            text : '<i class="icon-plus"></i>添加',
            listeners : {
              'click' : addFunction
            }
          },
          {
            btnCls : 'button button-small',
            text : '<i class="icon-remove"></i>删除',
            listeners : {
              'click' : delFunction
            }
          }]
        }

      });
    grid.render();

    function addFunction(){
      var newData = {school :'请输入学校名称'};
      editing.add(newData); //添加记录后，直接编辑
    }

    function delFunction(){
      var selections = grid.getSelection();
      store.remove(selections);
    }
    var form = new Form.HForm({
      srcNode : '#J_Form'
    });
    form.render();
    var field = form.getField('eduation');
    form.on('beforesubmit',function(){
      var records = store.getResult();
      field.set('value',BUI.JSON.stringify(records));
    });
  });
</script>

<body>
</html> 