<?php
/**
 *例子
 *
 *
 **/
class Sample extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');        
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
        $this->load->model('sample_model');//模型载入，根据需要修改模型的名称

        // $condition  = array();
        // if(isset($_GET['goodssite_no'])) {
        //     $condition['goodssite_no'] = $_GET['goodssite_no'];
        // }


         //$data['info'] = $this->sample_model->get($condition);//使用模型中的get()方法，根据需要修改模型的名称
         $this->load->view('CBS/sample', '');
    }


    /**
    *打开编辑
    *
    *
    * */
     public function edit_open()
    {

         //$this->load->model('sample_model');//模型载入，根据需要修改模型的名称
         //$data['info'] = $this->sample_model->get();//使用模型中的get()方法，根据需要修改模型的名称
         $data = '';
         $this->load->view('CBS/sample_edit_open', $data);
    }


    /**
    *ceshi
    *
    *
    * */
     public function xianshi()
    {
        // $condition = array(
        //     //'goodssite_no'=>'C1'
        //     'goodssite_no'=> $goodssite_no
        //     );

        //载入模型
        $this->load->model('sample_model');//模型载入，根据需要修改模型的名称
        $limit = $_GET["limit"]; //每页的数量
        //$limit = 4;
        $offset = 0; //从第几条记录开始查
        //查询条件
        $condition = array();
        if(isset($_GET["goodssite_no"])&&$_GET["goodssite_no"]!=null){
            $condition['goodssite_no'] = $_GET["goodssite_no"];
        }

        $data['info'] = $this->sample_model->get($condition,$limit,$offset);//使用模型中的get()方法，根据需要修改模型的名称
        echo json_encode($data['info']);

    }

    /**
    *ceshi
    *
    *
    * */
     public function xianshi2()
    {

    }
    /**
    *ceshi
    *
    *
    * */
     public function student()
    {

         //$this->load->model('sample_model');//模型载入，根据需要修改模型的名称
         //$data['info'] = $this->sample_model->get();//使用模型中的get()方法，根据需要修改模型的名称
         //$data = '';
         //$this->load->view('CBS/student', $data);
        echo '{
"rows":[{"id":"123","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"124","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"125","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"126","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"127","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"128","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"129","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1210","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1211","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1212","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1213","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1214","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1215","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1216","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"},
    {"id":"1217","name":"张三","sex":"0","birthday":326044800000,"grade":"一年级四班","address":"湖北省武汉市 430017江岸区沿江大道159号"}],
"results": 40
}';
    }
}
