<?php
/**
 *出库操作
 *
 *
 **/
class Outwarehouse extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('outwarehouse_model');      
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {

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
        
		 //获取总运单号
        $MBL = $this->input->get_post("MBL");
        if(!empty($MBL)){
            $condition['MBL'] = $MBL;
        }
	  //获取分运单号
        $HBL = $this->input->get_post("HBL");
        if(!empty($HBL)){
            $condition['HBL'] = $HBL;
        }
		 //获取品名
        $GOODS_CODE = $this->input->get_post("GOODS_CODE");
        if(!empty($GOODS_CODE)){
            $condition['GOODS_CODE'] = $GOODS_CODE;
        }
		
		 //获取包装情况
        $PACKING_CONDITION = $this->input->get_post("PACKING_CONDITION");
        if(!empty($PACKING_CONDITION)){
            $condition['PACKING_CONDITION'] = $PACKING_CONDITION;
        }
        //获取出库时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['IN_DATE>'] = $STA_DATE;
        }
		
		 //获取出库时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['IN_DATE<'] = $END_DATE;
        }

		  //获取客户
        $TRANS_COMPANY = $this->input->get_post("TRANS_COMPANY");
        if(!empty($TRANS_COMPANY)){
            $condition['TRANS_COMPANY'] = $TRANS_COMPANY;
        }
       
          //获取电商企业名称
        $OPERCOM_ID = $this->input->get_post("OPERCOM_ID");
        if(!empty($OPERCOM_ID)){
            $condition['OPERCOM_ID'] = $OPERCOM_ID;
        }
        $total = $this->outwarehouse_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->outwarehouse_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            if($list[$k]['TRANS_COMPANY'] = ($v['TRANS_COMPANY'] == '4101985823' )  )   
			{$list[$k]['TRANS_COMPANY']='申通快递';}
			else if($list[$k]['TRANS_COMPANY'] = ($v['TRANS_COMPANY'] == '4101986185' ) )
            {$list[$k]['TRANS_COMPANY']='顺丰快递';}
	        else if($list[$k]['TRANS_COMPANY'] = ($v['TRANS_COMPANY'] == '410198Z062' ) )
            { $list[$k]['TRANS_COMPANY']='中国邮政速递';}
		    else if($list[$k]['TRANS_COMPANY'] = ($v['TRANS_COMPANY'] == '4101986180' ) )
            {$list[$k]['TRANS_COMPANY']='河南省圆通速递有限公司';}
	        else if ($list[$k]['TRANS_COMPANY'] = ($v['TRANS_COMPANY'] == '4101985807' ) )
            { $list[$k]['TRANS_COMPANY']='河南中通快递服务有限公司';}
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

	
    /**
    *出库查询
    *
    *
    * */
     public function outwarehouse_search()
    {
         $this->load->view('CBS/chuku_info', '');
    }


}
