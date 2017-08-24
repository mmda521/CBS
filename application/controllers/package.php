<?php
/**
 *包裹分拣
 *
 *
 **/
class Package extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('Package_model');

    }
    /**
     *
     *批次理货
     *
     * */
    public function package_sort()
    {
        $this->load->view('CBS/package_sort', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function package_sort_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 10;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();

        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)){
            $condition['HBL'] = $hbl;
        }
        $pass_type = $this->input->get_post("pass_type");
        if(in_array($pass_type,array('A','B',true))){
            $condition['PASS_TYPE'] = $pass_type;
        }

        $total = $this->Package_model->count_num($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->Package_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'A' )?"海关":'<font color="red">国检</font>';
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);

        }
        foreach($list as $k=>$v){
            $list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '1')?"放行":'<font color="red">未放行</font>';
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);

        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }


}
