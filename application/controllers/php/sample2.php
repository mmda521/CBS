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
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('sample2_model');      
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
        $this->load->view('CBS/sample2', '');
    }


    /**
    *ajax获取数据
    *
    *
    * */
    public function ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page"); 
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();
        
        //获取库位号
        $goodssite_no = $this->input->get_post("goodssite_no");
        if(!empty($goodssite_no)){
            $condition['goodssite_no'] = $goodssite_no;
        }

        //启用状态
        $status = $this->input->get_post("status"); 
        if(in_array($status,array('Y','N',true))){
            $condition['status'] = $status; 
        }
        
        $total = $this->sample2_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->sample2_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['STATUS'] = ($v['STATUS'] == 'Y' )?"开启":'<font color="red">停用</font>';          
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
            
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

    /**
    *添加库位页面
    *
    *
    * */
    public function add(){
        $this->load->view('CBS/sample2_add', '');
    }

    /**
    *添加库位处理
    *
    *
    * */
    public function doadd(){
        $index_no       = $this->input->get_post("index_no");
        $goodssite_no   = $this->input->get_post("goodssite_no");
        $goodssite_note = $this->input->get_post("goodssite_note");
        $status         = $this->input->get_post("status");

        //查询检索号是否存在（假设检索号不能重复）
        $condition = array();
        $condition['index_no'] = $index_no;
        $info = $this->sample2_model->get_index_no($condition);
        if(!empty($info)){
            //showmessage("检索号{$index_no}已经存在","sample2/add",3,0);
            exit();
        }

        //插入数据
        $data = array(
            'guid'          =>guid_create(),
            'index_no'      =>$index_no,
            'goodssite_no'  =>$goodssite_no,
            'goodssite_note'=>$goodssite_note,
            'status'        =>$status,
            'operdate'      =>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->sample2_model->insert($data);
        //showmessage("添加库位成功","sample2/index",3,1);
        exit();
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }

}
