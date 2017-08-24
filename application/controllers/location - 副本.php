<?php
/**
 *库位操作
 *
 *
 **/
class Location extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('location_model');      
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
         $this->load->view('CBS/location', '');
		
    }
	
	
	
	 public function ajax_data_export(){	  			
	 $condition = array();
		 //获取库位说明
        $goodssite_note = $this->input->get_post("goodssite_note");
        if(!empty($goodssite_note)){
            $condition['goodssite_note'] = $goodssite_note;
        }
		 //获取检索号
        $index_no = $this->input->get_post("index_no");
        if(!empty($index_no)){
            $condition['index_no'] = $index_no;
        }
		
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
        
        $total = $this->location_model->export_data($condition);      
	    foreach($total as $k=>$v){
            $total[$k]['STATUS'] = ($v['STATUS'] == 'Y' )?"启用":"停用";          
        }
		  PC::debug($total);
		    
	 $file_type = "vnd.ms-excel";  
     $file_ending = "xlsx";	 
	  //$file_ending = "xls";
	  $savename = date("YmdHis"); 	  
	  $filename="FILE".$savename.".$file_ending";
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  $PHPExcel->getProperties()->setTitle("库位信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','检索号')
            ->setCellValue('B1','库位号')
            ->setCellValue('C1','库位说明')
            ->setCellValue('D1','操作人员')
			->setCellValue('E1','操作时间')
            ->setCellValue('F1','状态');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['INDEX_NO'])    
                          ->setCellValue('B'.$num, $v['GOODSSITE_NO'])
                          ->setCellValue('C'.$num, $v['GOODSSITE_NOTE'])
						  ->setCellValue('D'.$num, $v['OPERUSER_ID'])    
                          ->setCellValue('E'.$num, $v['OPERDATE'])
                          ->setCellValue('F'.$num, $v['STATUS']);
            }
			
			 $PHPExcel->getActiveSheet()->setTitle('库位信息导出-'.date('Y-m-d',time()));
            $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/$file_type;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".$savename.".$file_ending");  
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
			
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            //$objWriter->save('php://output');
			 $objWriter->save("downloads/".$filename);
			 // $objWriter->save('php://output');
			 //PC::debug('123');
           echo result_to_towf_new('1', 1, 'success', null);
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
        
		 //获取库位说明
        $goodssite_note = $this->input->get_post("goodssite_note");
        if(!empty($goodssite_note)){
            $condition['goodssite_note'] = $goodssite_note;
        }
		 //获取检索号
        $index_no = $this->input->get_post("index_no");
        if(!empty($index_no)){
            $condition['index_no'] = $index_no;
        }
		
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
        
        $total = $this->location_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->location_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['STATUS'] = ($v['STATUS'] == 'Y' )?"启用":'<font color="red">停用</font>';          
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
            
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
         $this->load->view('CBS/location_add', '');
    }

	    /**
    *添加库位处理
    *
    *
    * */
    public function doadd(){
		$condition = array();
        $index_no       = $this->input->get_post("index_no");
		 if(!empty($index_no)) {
            $condition['index_no'] = $index_no;
        }else {
            echo result_to_towf_new('1', 0, '检索号不能为空', NULL);
            exit();
        }
        $goodssite_no   = $this->input->get_post("goodssite_no");
		 if(!empty($goodssite_no)) {
            $condition['goodssite_no'] = $goodssite_no;
        }else {
            echo result_to_towf_new('1', 0, '库位号不能为空', NULL);
            exit();
        }
		$operuser_no    = $this->input->get_post("operuser_no");
        $goodssite_note = $this->input->get_post("goodssite_note");
        $status         = $this->input->get_post("status");
		 if(!empty($status)) {
            $condition['status'] = $status;
        }else {
            echo result_to_towf_new('1', 0, '启用状态不能为空', NULL);
            exit();
        }


        //插入数据
        $data = array(
            'guid'          =>guid_create(),
            'index_no'      =>$index_no,
            'goodssite_no'  =>$goodssite_no,
			'operuser_id'   =>$operuser_no,			
            'goodssite_note'=>$goodssite_note,
            'status'        =>$status,
            'operdate'      =>date('Y-m-d H:i:s',time())
        );

        //echo $status;
        //break;
        $this->location_model->insert($data);
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
		$list['info'] = $this->location_model->get_list($condition);  
     // PC::debug($list);	
	    $this->load->view('CBS/location_edit', $list);

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
		
        $index_no = $this->input->get_post("index_no");
		 if(!empty($index_no)) {
            $condition['index_no'] = $index_no;
        }else {
            echo result_to_towf_new('1', 0, '检索号不能为空', NULL);
            exit();
        }
		$goodssite_no   = $this->input->get_post("goodssite_no");
		 if(!empty($goodssite_no)) {
            $condition['goodssite_no'] = $goodssite_no;
        }else {
            echo result_to_towf_new('1', 0, '库位号不能为空', NULL);
            exit();
        }
		$goodssite_note   = $this->input->get_post("goodssite_note");		
		$OPERUSER_ID    = $this->input->get_post("operuser_no");
        $status         = $this->input->get_post("status");
		 if(!empty($status)) {
            $condition['status'] = $status;
        }else {
            echo result_to_towf_new('1', 0, '启用状态不能为空', NULL);
            exit();
        }
         //编辑数据
        $data = array(  
            'GUID'      =>$GUID,		
            'index_no'      =>$index_no,
            'goodssite_no'  =>$goodssite_no,
			'operuser_id'   =>$OPERUSER_ID,			
            'goodssite_note'=>$goodssite_note,
            'status'        =>$status,
            'operdate'      =>date('Y-m-d H:i:s',time())
        );
		
       $this->location_model->update($data,$GUID);
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
            $this->location_model->delete($GUID);
           
        }
		echo result_to_towf_new('1', 1, 'success', null);
    }

   
}
