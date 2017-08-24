<?php
/**
 *例子
 *
 *
 **/
class Sample2 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->library("common_page");  
        $this->load->model('M_common','',false , array('type'=>'real_data'));      
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
        //$this->load->model('sample2_model');//模型载入，根据需要修改模型的名称

        // $condition  = array();
        // if(isset($_GET['goodssite_no'])) {
        //     $condition['goodssite_no'] = $_GET['goodssite_no'];
        // }


         //$data['info'] = $this->sample_model->get($condition);//使用模型中的get()方法，根据需要修改模型的名称
        // $this->load->view('CBS/sample2', '');


        $action = $this->input->get_post("action");    
        $action_array = array("show","ajax_data");
        $action = !in_array($action,$action_array)?'show':$action ;
        if($action == 'show'){
            $this->load->view('CBS/sample2', '');
        }elseif($action == 'ajax_data'){
            $this->ajax_data();
        }
    }


    /**
    *ajax获取数据
    *
    *
    * */
    private function ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page"); 
        if($page <=0 ){
            $page = 1 ;
        }
        $per_page = 10;//每一页显示的数量
        $limit = ($page-1)*$per_page;
        $limit.=",{$per_page}";
        $where = ' where 1= 1 ';

        //获取username的值
        $username = $this->input->get_post("username");
        if(!empty($username)){
            $condition = intval($this->input->get_post("condition"));
            $condition  = in_array($condition,array(1,2))?$condition:1;
            $array_condition_search  = array(
                1=>" LIKE '%{$username}%'", //模糊搜索
                2=>"= '{$username}'"
            );
            $where.=" AND username {$array_condition_search[$condition]}";
        }
        $status = $this->input->get_post("status"); 
        if(in_array($status,array('1','0',true))){
            $where.=" AND `status` = '{$status}'"; 
        }
        $sql_count = "SELECT COUNT(*) AS tt FROM  common_user {$where}";
        $total  = $this->M_common->query_count($sql_count);
        $page_string = $this->common_page->page_string($total, $per_page, $page);
        $sql_role = "SELECT * FROM  common_user {$where} order by uid desc   limit  {$limit}";    
        $list = $this->M_common->querylist($sql_role);
        foreach($list as $k=>$v){
            $list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';          
            $list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
            $list[$k]['expire'] = ($v['expire'] == 0 )?'<font color="green">永不过期</font>':date("Y-m-d H:i:s",$v['expire']);
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
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
        $this->load->model('sample2_model');//模型载入，根据需要修改模型的名称
        $limit = $_GET["limit"]; //每页的数量
        //$limit = 4;
        $offset = 0; //从第几条记录开始查
        //查询条件
        $condition = array();
        if(isset($_GET["goodssite_no"])&&$_GET["goodssite_no"]!=null){
            $condition['goodssite_no'] = $_GET["goodssite_no"];
        }

        $data['info'] = $this->sample2_model->get($condition,$limit,$offset);//使用模型中的get()方法，根据需要修改模型的名称
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
   
}
