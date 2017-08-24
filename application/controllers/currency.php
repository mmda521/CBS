<?php
/**
 *币值操作
 *
 *
 **/
class Currency extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        $this->load->model('currency_model');  
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
        $this->load->view('CBS/currency', '');
    }


	 /**
    *ajax获取数据
	查看功能
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
        
		
		 //获取检索号
        $CURRTYPECODE = $this->input->get_post("CURRTYPECODE");
        if(!empty($CURRTYPECODE)){
            $condition['CURRTYPECODE'] = $CURRTYPECODE;
        }
		
        //获取库位号
        $CURRTYPENAME = $this->input->get_post("CURRTYPENAME");
        if(!empty($CURRTYPENAME)){
            $condition['CURRTYPENAME'] = $CURRTYPENAME;
        }

        //启用状态
         $STATUS = $this->input->get_post("STATUS");
        if(!empty($STATUS)){
            $condition['STATUS'] = $STATUS;
        }
        
        $total = $this->currency_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->currency_model->get_list($condition,$limit,$offset);
        
		 foreach($list as $k=>$v){                
            if($list[$k]['STATUS'] = ($v['STATUS'] == 'Y' )  )   
			{$list[$k]['STATUS']='启用';}
		    else if($list[$k]['STATUS'] = ($v['STATUS'] == 'N' ) )
            {$list[$k]['STATUS']='停用';}
		    else if($list[$k]['STATUS'] = ($v['STATUS'] == 'YN' ) )
            {$list[$k]['STATUS']='忽略';}          
        }
		//PC::debug($list);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

	
	
	
	 /**
    *新增库位页面
    *
    *
    * */
     public function add()
    {      
         $this->load->view('CBS/currency_add', '');
    }

	    /**
    *添加库位处理
    *
    *
    * */
    public function doadd(){
		$condition = array();
        $CURRTYPECODE       = $this->input->get_post("CURRTYPECODE");		
        $CURRTYPENAME   = $this->input->get_post("CURRTYPENAME");
        $STATUS         = $this->input->get_post("STATUS");		

        //插入数据
        $data = array(
            'guid'          =>guid_create(),
            'CURRTYPECODE'      =>$CURRTYPECODE,
            'CURRTYPENAME'  =>$CURRTYPENAME,
			'STATUS'   =>$STATUS
        );

        //echo $status;
        //break;
        $this->currency_model->insert($data);
        //showmessage("添加库位成功","sample2/index",3,1);
        echo result_to_towf_new('1', 1, 'success', null);
    }
	
	
	
	 /**
    *打开编辑
    *
    *
    * */
     public function edit()
    {
        $GUID = $this->input->get_post("GUID");		
		$condition = array();
        $condition['GUID'] = $GUID;
		//PC::debug($GUID);
		$list['info'] = $this->currency_model->get_list($condition);  
     // PC::debug($list);	
	    $this->load->view('CBS/currency_edit', $list);

    }
	
/**
    *处理编辑
    *
    *
    * */
     public function do_edit()
    {
		 $page = $this->input->get_post("page"); 
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量
        $GUID = $this->input->get_post("GUID");		
        $CURRTYPECODE = $this->input->get_post("CURRTYPECODE");
		$CURRTYPENAME   = $this->input->get_post("CURRTYPENAME");		
		$STATUS    = $this->input->get_post("STATUS");
       
         //编辑数据
        $data = array(  
            'GUID'      =>$GUID,		
            'CURRTYPECODE'      =>$CURRTYPECODE,
            'CURRTYPENAME'  =>$CURRTYPENAME,
			'STATUS'   =>$STATUS		
        );
		
       $this->currency_model->update($data,$GUID);
	    echo result_to_towf_new('1', 1, 'success', null);
    }
	
	 /**
    *删除库位信息
    *
    *
    * */
     public function delete()
    { 
         $GUID = $this->input->get_post("guid");
		 //PC::debug($GUID);
      if ($GUID) {
            $this->currency_model->delete($GUID);
           
        }
		echo result_to_towf_new('1', 1, 'success', null);
    }
}
