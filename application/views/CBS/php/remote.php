<!DOCTYPE HTML>
<html>
 <head>
  <title> 表单远程调用</title>
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
    <div class="row">
      <div class="span8">
        <h2>简介</h2>
        <p>填写表单过程中，经常需要使用异步请求，有以下场景：</p>
        <ol>
          <li>异步验证：输入信息实时进行校验。</li>  
          <li>异步获取信息：当输入信息后，获取更多信息。</li>
        </ol>

      </div>
      <div class="span16">
        <h2>异步请求</h2>
        <p>表单的字段域都支持异步请求，异步请求有以下参数：</p>
        <ol>
          <li>remote: 异步请求的配置项，等同于<a href="http://api.jquery.com/jQuery.ajax/"> jQuery中ajax的配置项</a>。其中特别的是：
            <ol>
              <li><code>url</code>: 如果remote的配置项仅包含url时，直接使用字符串即可，即： {remote : 'a.php'}</li>
              <li><code>success</code>,<code>error</code>： 回调函数不要复写，需要写回调函数时使用：</li>
              <li><code>callback</code> : 回调函数，函数内部可以处理自己的逻辑，如果函数返回一个非空的字符串，则作为错误信息显示在表单中。</li>
              <li><code>dataType</code>: 默认为 'text',复杂的返回数据格式，请重置此属性。</li>
            </ol>
          </li>
          <li><code>remoteDaly</code>：输入文本时延迟一定的时间后发送请求，防止连续输入时，频繁验证.</li>
          <li><code>loadingTpl</code>: 显示加载状态的 html</li>
        </ol>
        <p>除了上面的配置项还支持以下事件：</p>
        <ol>
          <li><code>remotestart</code>: 异步请求开始发送，其中 <code>e.data</code>是发送的参数，可以修改此参数。</li>
          <li><code>remotecomplete</code>: 异步请求完成，其中<code>e.error</code>是验证错误信息，如果通过验证，值为空。</li>
        </ol>
        <p><span class="label label-warning">注意</span>：异步请求的返回值，默认是字符串，如果返回字符串为空，则认为验证成功，返回字符串非空，则作为错误信息显示在对应的字段后。</p>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>异步验证</h2>
        <p>异步验证的步骤如下：</p>
        <ol>
          <li>用户输入，按下按键</li>
          <li>表单字段进行基本的验证，如果验证失败，返回步骤1</li>
          <li>延迟一定时间，发送异步请求验证（默认 500ms)</li>
          <li>如果用户继续输入，终止上面发送的请求，返回步骤2</li>
          <li>验证结果返回，验证本次验证是否被取消，如果取消，终止</li>
          <li>未取消，显示错误信息</li>
        </ol>
      </div>
      <div class="span16">
        <h2>示例</h2>
        <p>这里只是提供一个示例，真正项目中基础验证即可。如果输入文本小于5，验证通过，否则，验证失败。</p>
        <form id="J_Form" action="" class="row">
          <div class="span16">
            <div class="well">
              <label>异步验证：</label><input name="a" data-rules="{required:true}" data-remote="<?php echo base_url();?>/webroot/CBS_Platform/data/remote1.php" type="text">
            </div>
          </div>
        </form>
        <pre class="prettyprint linenums">
 &lt;label&gt;异步验证：&lt;/label&gt;&lt;input name="a" data-rules="{required:true}" data-remote="<?php echo base_url();?>/webroot/CBS_Platform/data/remote1.php" type="text"&gt;
        </pre>
      </div>
    </div>
    <div class="row">
      <div class="span8">
        <h2>异步请求</h2>
        <p>异步请求的执行步骤跟异步验证一致，此外将附加的数据显示出来。</p>
        <ol>
          <li>通过配置项中的 <code>callback</code>回调函数</li>
          <li>如果返回数据类型是'json'，则修改<code>dataType:'json'</code></li>
        </ol>
      </div>
      <div class="span16">
        <h2>异步请求</h2>
        <p>输入学生编号，获取学生信息。</p>
         <form id="J_Form1" action="" class="row">
          <div class="span16">
            <div class="well">
              <label>学生编号：</label><input name="a" data-rules="{required:true,length:5}" type="text">
            </div>
            <div id="info" class="well"></div>
          </div>
        </form>
        <h3>html</h3>
        <pre class="prettyprint linenums">
&lt;form id="J_Form1" action="" class="row"&gt;
  &lt;div class="span16"&gt;
    &lt;div class="well"&gt;
      &lt;label&gt;学生编号：&lt;/label&gt;&lt;input name="a" data-rules="{required:true,length:5}" type="text"&gt;
    &lt;/div&gt;
    &lt;div id="info" class="well"&gt;&lt;/div&gt;
  &lt;/div&gt;
&lt;/form&gt;
        </pre>
        <h3>js</h3>
        <pre class="prettyprint linenums">
var f1 = new Form.Form({
  srcNode : '#J_Form1'
}).render();

//根据name获取字段
var field = f1.getField('a');
//设置异步请求配置项
field.set('remote',{
  url : '<?php echo base_url();?>/webroot/CBS_Platform/data/student.php',
  dataType : 'json',
  callback : function (data) {
    //处理数据，此处也可以根据结果显示请求数据的验证结果，
    // return errorMsg; 即可
    $('#info').text(BUI.JSON.stringify(data));
  }
});
        </pre>
      </div>
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
  BUI.use('bui/form',function (Form) {
    new Form.Form({
      srcNode : '#J_Form'
    }).render();

    var f1 = new Form.Form({
      srcNode : '#J_Form1'
    }).render();

    var field = f1.getField('a');
    field.set('remote',{
      url : '<?php echo base_url();?>/webroot/CBS_Platform/data/student.php',
      dataType : 'json',
      callback : function (data) {
        $('#info').text(BUI.JSON.stringify(data));
      }
    });
  });
</script>

<body>
</html>  
