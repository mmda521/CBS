<?php
/**
 *指令
 *
 *
 **/
class Order extends MY_Controller {

   public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('order_model');      
        
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
    *
    *海关指令
    *
    * */
     public function order_cus()
    {

        
         $this->load->view('CBS/order_cus','');
    }
	
	 /**
    *
    *国检指令
    *
    * */
     public function order_insp()
    {

        
         $this->load->view('CBS/order_insp','');
    }
	 /**
    *ajax获取海关数据
    *
    *
    * */
    public function ajax_data_cus(){
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
        $BATCHNO = $this->input->get_post("BATCHNO");
        if(!empty($BATCHNO)){
            $condition['BATCHNO'] = $BATCHNO;
        }
	  //获取分运单号
        $HBL = $this->input->get_post("HBL");
        if(!empty($HBL)){
            $condition['HBL'] = $HBL;
			
        }
		
		 //获取状态
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取状态
        $DISCHARGED_TYPE = $this->input->get_post("DISCHARGED_TYPE");
        if(!empty($DISCHARGED_TYPE)){
            $condition['DISCHARGED_TYPE'] = $DISCHARGED_TYPE;
        }
		
        //获取时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['DISCHARGED_DATE>'] = $STA_DATE;
        }
		
		 //获取时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['DISCHARGED_DATE<'] = $END_DATE;
        }

		$condition['PASS_TYPE'] = 'A';
       
        
        $total = $this->order_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->order_model->get_list($condition,$limit,$offset);
		//PC::debug($list);
        foreach($list as $k=>$v){
            $list[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'A' )?"海关":'<font color="red">国检</font>';          
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
            
        }
		 foreach($list as $k=>$v){                
            if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '3' )  )   
			{$list[$k]['DISCHARGED_TYPE']='放行';}
		    else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '4' ) )
            {$list[$k]['DISCHARGED_TYPE']='查验';}
		    else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '5' ) )
            {$list[$k]['DISCHARGED_TYPE']='机检';}          
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
   

   /*导出功能 */
	 public function ajax_data_cus_export(){	  			
	 $condition = array();
		
		 //获取总运单号
        $BATCHNO = $this->input->get_post("BATCHNO");
        if(!empty($BATCHNO)){
            $condition['BATCHNO'] = $BATCHNO;
        }
	  //获取分运单号
        $HBL = $this->input->get_post("HBL");
        if(!empty($HBL)){
            $condition['HBL'] = $HBL;
			
        }
		
		 //获取状态
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取状态
        $DISCHARGED_TYPE = $this->input->get_post("DISCHARGED_TYPE");
        if(!empty($DISCHARGED_TYPE)){
            $condition['DISCHARGED_TYPE'] = $DISCHARGED_TYPE;
        }
		
        //获取时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['DISCHARGED_DATE>'] = $STA_DATE;
        }
		
		 //获取时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['DISCHARGED_DATE<'] = $END_DATE;
        }

		$condition['PASS_TYPE'] = 'A';
       
        
        $total = $this->order_model->export_cus_data($condition);      
	     foreach($total as $k=>$v){                
            if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '3' )  )   
			{$total[$k]['DISCHARGED_TYPE']='放行';}
		    else if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '4' ) )
            {$total[$k]['DISCHARGED_TYPE']='查验';}
		    else if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '5' ) )
            {$total[$k]['DISCHARGED_TYPE']='机检';}          
        }
		 foreach($total as $k=>$v){                
            if($total[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'A' )  )   
			{$total[$k]['PASS_TYPE']='海关';}
		    else if($total[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'B' ) )
            {$total[$k]['PASS_TYPE']='国检';}
		        
        }
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("海关信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','批次号')
            ->setCellValue('B1','分运单号')
            ->setCellValue('C1','物流企业代码')
            ->setCellValue('D1','状态')
			->setCellValue('E1','时间')
            ->setCellValue('F1','联检单位');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['BATCHNO'])    
                          ->setCellValue('B'.$num, " ".$v['HBL'])
                          ->setCellValue('C'.$num, $v['LOGISTICSCODE'])
						  ->setCellValue('D'.$num, $v['DISCHARGED_TYPE'])    
                          ->setCellValue('E'.$num, $v['DISCHARGED_DATE'])
                          ->setCellValue('F'.$num, $v['PASS_TYPE']);
            }			
		   $PHPExcel->getActiveSheet()->setTitle('海关信息导出-'.date('Y-m-d',time()));
		   $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
           $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		   $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
           $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		   $PHPExcel->getActiveSheet()->getStyle('A1:F1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		  
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }

   
    /**
    *ajax获取国检数据
    *
    *
    * */
    public function ajax_data_insp(){
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
        $BATCHNO = $this->input->get_post("BATCHNO");
        if(!empty($BATCHNO)){
            $condition['BATCHNO'] = $BATCHNO;
        }
	  //获取分运单号
        $HBL = $this->input->get_post("HBL");
        if(!empty($HBL)){
            $condition['HBL'] = $HBL;
			
        }
		
		 //获取状态
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取状态
        $DISCHARGED_TYPE = $this->input->get_post("DISCHARGED_TYPE");
        if(!empty($DISCHARGED_TYPE)){
            $condition['DISCHARGED_TYPE'] = $DISCHARGED_TYPE;
        }
		
        //获取时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['DISCHARGED_DATE>'] = $STA_DATE;
        }
		
		 //获取时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['DISCHARGED_DATE<'] = $END_DATE;
        }

		$condition['PASS_TYPE'] = 'B';
       
        
        $total = $this->order_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->order_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'B' )?"国检":'<font color="red">海关</font>';          
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
            
        }
		
		 foreach($list as $k=>$v){
            if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '4' )  )   
			{$list[$k]['DISCHARGED_TYPE']='检验人工审单';}
			else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '11' ) )
            {$list[$k]['DISCHARGED_TYPE']='检验重新申报';}
	        else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '1' ) )
            { $list[$k]['DISCHARGED_TYPE']='检验放行';}
		else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '10' ) )
            {$list[$k]['DISCHARGED_TYPE']='检验查验';}
	        else if($list[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '8' ) )
            { $list[$k]['DISCHARGED_TYPE']='检验禁止出境';}
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	

	 /*导出功能 */
	 public function ajax_data_insp_export(){	  			
	 $condition = array();
		
		 //获取总运单号
        $BATCHNO = $this->input->get_post("BATCHNO");
        if(!empty($BATCHNO)){
            $condition['BATCHNO'] = $BATCHNO;
        }
	  //获取分运单号
        $HBL = $this->input->get_post("HBL");
        if(!empty($HBL)){
            $condition['HBL'] = $HBL;
			
        }
		
		 //获取状态
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取状态
        $DISCHARGED_TYPE = $this->input->get_post("DISCHARGED_TYPE");
        if(!empty($DISCHARGED_TYPE)){
            $condition['DISCHARGED_TYPE'] = $DISCHARGED_TYPE;
        }
		
        //获取时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['DISCHARGED_DATE>'] = $STA_DATE;
        }
		
		 //获取时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['DISCHARGED_DATE<'] = $END_DATE;
        }

		$condition['PASS_TYPE'] = 'B';
        
        $total = $this->order_model->export_insp_data($condition);      
	     foreach($total as $k=>$v){                
            if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '3' )  )   
			{$total[$k]['DISCHARGED_TYPE']='放行';}
		    else if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '4' ) )
            {$total[$k]['DISCHARGED_TYPE']='查验';}
		    else if($total[$k]['DISCHARGED_TYPE'] = ($v['DISCHARGED_TYPE'] == '5' ) )
            {$total[$k]['DISCHARGED_TYPE']='机检';}          
        }
		 foreach($total as $k=>$v){                
            if($total[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'A' )  )   
			{$total[$k]['PASS_TYPE']='海关';}
		    else if($total[$k]['PASS_TYPE'] = ($v['PASS_TYPE'] == 'B' ) )
            {$total[$k]['PASS_TYPE']='国检';}
		        
        }
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("国检信息导出")->setDescription("备份数据");	
     $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(500);	  
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','批次号')
            ->setCellValue('B1','分运单号')
            ->setCellValue('C1','物流企业代码')
            ->setCellValue('D1','状态')
			->setCellValue('E1','时间')
            ->setCellValue('F1','联检单位');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['BATCHNO'])    
                          ->setCellValue('B'.$num, " ".$v['HBL'])
                          ->setCellValue('C'.$num, $v['LOGISTICSCODE'])
						  ->setCellValue('D'.$num, $v['DISCHARGED_TYPE'])    
                          ->setCellValue('E'.$num, $v['DISCHARGED_DATE'])
                          ->setCellValue('F'.$num, $v['PASS_TYPE']);
            }			
		   $PHPExcel->getActiveSheet()->setTitle('国检信息导出-'.date('Y-m-d',time()));
		   $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
           $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		   $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
           $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		   $PHPExcel->getActiveSheet()->getStyle('A1:F1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	
}
