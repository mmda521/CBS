<?php
/**
 *库位操作
 *
 *
 **/
class Batch extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        $this->load->model('batch_model'); 
        $this->load->model('waybill_model');		
        $this->load->library('session');    
    }

	
	
    /**
    *index页面
    *
    *
    * */
     public function index()
    {
         $this->load->view('CBS/batch_search', '');
		
    }
	
	
	/*导出功能 */
	 public function ajax_data_export(){	  			
		
		 //获取检索号
        $GUID = $this->input->get_post("guid");
       $total = $this->batch_model->export_batch($GUID);  
	   $list3 = $this->waybill_model->get_operuser_id();
	    foreach($total as $k=>$v){
            $total[$k]['BATCHTYPE'] = ($v['BATCHTYPE'] == '0' )?"批次理货":"拆包理货";                    
        }
		 foreach($total as $k=>$v){
			if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '0' )  )   
			{$total[$k]['BATCHCONTROL']='不布控';}
		    else if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '1' ) )
            {$total[$k]['BATCHCONTROL']='布控';}
		    else if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '2' ) )
            {$total[$k]['BATCHCONTROL']='放行';}
        }
		 foreach($total as $k=>$v){
            $total[$k]['TALLY_STATUS'] = ($v['TALLY_STATUS'] == 'Y' )?"已理货":"未理货";                    
        }
		 foreach($list3 as $k3=>$v3){
			   foreach($total as $k=>$v){
               if($total[$k]['CREATE_USER'] == $list3[$k3]['USER_ID'])   
			    {
				$total[$k]['CREATE_USER'] = $list3[$k3]['USER_NAME'];}  
                }
              }
		//PC::debug($total);
		$savename = date("YmdHis"); 	  
	 $filename="FILE".$savename.".xlsx";
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("库位信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总单号')
            ->setCellValue('B1','批次号')
			->setCellValue('C1','创建时间')
            ->setCellValue('D1','创建人')
            ->setCellValue('E1','理货类型')
            ->setCellValue('F1','批次布控')
			->setCellValue('G1','理货状态');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['MBL'])    
                          ->setCellValue('B'.$num, $v['BATCHNO'])
						   ->setCellValue('C'.$num, $v['CREATE_DATE'])
						  ->setCellValue('D'.$num, $v['CREATE_USER'])  
                          ->setCellValue('E'.$num, $v['BATCHTYPE'])
						  ->setCellValue('F'.$num, $v['BATCHCONTROL'])    
                          ->setCellValue('G'.$num, $v['TALLY_STATUS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('批次信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:G1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);		
           $response = array(  
                'success' => true,  
                'url' => $this->saveExcelToLocalFile($objWriter,$filename)  
            );  
            echo result_to_towf_new2('1', 1, 'success', null, $response);
    }

/*excel保存到本地*/
    public function saveExcelToLocalFile($objWriter,$filename){  
    // make sure you have permission to write to directory  
    $filePath = 'downloads/'.$filename; 
    $objWriter->save($filePath); 
    return $filePath; 
		
}  

	 /**
    *从总单表中输入的总单号来，显示批次表中的批次信息
    *
    *
    * */
    public function ajax_data_batch(){
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
        $MBL = $this->input->get_post("MBL");
       
		 if(!empty($MBL)) {
            $condition['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总运单号信息为空', NULL);
            exit();
        }		
              
        $total = $this->batch_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->batch_model->get_list($condition,$limit,$offset);
		$list3 = $this->waybill_model->get_operuser_id();
        foreach($list as $k=>$v){
            $list[$k]['BATCHTYPE'] = ($v['BATCHTYPE'] == '0' )?"批次理货":"拆包理货";                    
        }
		 foreach($list as $k=>$v){
			if($list[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '0' )  )   
			{$list[$k]['BATCHCONTROL']='不布控';}
		    else if($list[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '1' ) )
            {$list[$k]['BATCHCONTROL']='布控';}
		    else if($list[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '2' ) )
            {$list[$k]['BATCHCONTROL']='放行';}
        }
		 foreach($list as $k=>$v){
            $list[$k]['TALLY_STATUS'] = ($v['TALLY_STATUS'] == 'Y' )?"已理货":"未理货";                    
        }
		 foreach($list3 as $k3=>$v3){
			   foreach($list as $k=>$v){
               if($list[$k]['CREATE_USER'] == $list3[$k3]['USER_ID'])   
			    {
				$list[$k]['CREATE_USER'] = $list3[$k3]['USER_NAME'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

	
	
	 /**
    *新增批次页面
    *
    *
    * */
     public function add()
    {      
         $this->load->view('CBS/batch_add', '');
    }

	    /**
    *添加批次处理
    *
    *
    * */
    public function doadd(){
		$condition = array();
        $MBL   = $this->input->get_post("MBL");
		 if(!empty($MBL)) {
            $condition['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总单号不能为空', NULL);
            exit();
        }
		$condition1 = array();
		$condition1['MBL'] = $MBL;
		 $data['info'] =  $this->batch_model->get_list_mbl($condition1);
        if(!$data['info']){ 
            echo result_to_towf_new('1', 0, '请录入总单信息之后再来进行操作！', NULL);
            exit();
        }		
        $BATCHNO   = $this->input->get_post("BATCHNO");
		 if(!empty($BATCHNO)) {
            $condition['BATCHNO'] = $BATCHNO;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }		
		$condition2 = array();
		$condition2['BATCHNO'] = $BATCHNO;
		//PC::debug($condition7);
		 $data1['info'] =  $this->batch_model->get_list_batch($condition2,'','');
		// PC::debug($data);
        if($data1['info']){ 
            echo result_to_towf_new('1', 0, '批次号不能重复输入，请重新输入！', NULL);
            exit();
        }
		
        //插入数据
        $data = array(
            'guid'          =>guid_create(),
            'MBL'      =>$MBL,
            'BATCHNO'  =>$BATCHNO,	
           'CREATE_USER'   =>$_SESSION['USER_ID'],	
            'CREATE_DATE' =>date('Y-m-d H:i:s',time())			
        );

        $this->batch_model->insert($data);
        //showmessage("添加库位成功","sample2/index",3,1);
        echo result_to_towf_new('1', 1, 'success', null);
    }
	
	
	
	 /**
    *删除批次信息
    *
    *
    * */
     public function delete()
    { 
         $GUID = $this->input->get_post("guid");
      if ($GUID) {
           $this->batch_model->delete($GUID);           
        }
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
		$list['info'] = $this->batch_model->get_list($condition);  
     // PC::debug($list);	
	    $this->load->view('CBS/batch_edit', $list);

    }
	
/**
    *处理编辑
    *
    *
    * */
     public function do_edit()
    {
        $GUID = $this->input->get_post("GUID");
		$condition = array();
        $MBL = $this->input->get_post("MBL");
		 if(!empty($MBL)) {
            $condition['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总单号不能为空', NULL);
            exit();
        }
		$condition1 = array();
		$condition1['MBL'] = $MBL;
		 $data['info'] =  $this->batch_model->get_list_mbl($condition1);
        if(!$data['info']){ 
            echo result_to_towf_new('1', 0, '请录入总单信息之后再来进行操作！', NULL);
            exit();
        }		
		$BATCHNO   = $this->input->get_post("BATCHNO");
		 if(!empty($BATCHNO)) {
            $condition['BATCHNO'] = $BATCHNO;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
		/*$condition2 = array();
		$condition2['BATCHNO'] = $BATCHNO;
		$data1['info'] =  $this->batch_model->get_list_batch($condition2,'','');
        if($data1['info']){ 
            echo result_to_towf_new('1', 0, '批次号不能重复输入，请重新输入！', NULL);
            exit();
        }		
		*/
		
		
         //编辑数据
        $data = array(  
            'GUID'      =>$GUID,		
            'MBL'      =>$MBL,
            'BATCHNO'  =>$BATCHNO			
        );
		
       $this->batch_model->update($data,$GUID);
	    echo result_to_towf_new('1', 1, 'success', null);
    }
}
