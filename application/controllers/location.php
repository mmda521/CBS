<?php
/**
 *库位操作
 *
 *
 **/
class Location extends MY_Controller {

    public function __construct()
    {
		$this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        $this->load->model('location_model');      
        $this->load->library('session');    
    }

	   public function welcome()
    {
         $this->load->view('CBS/welcome', '');
		
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
	
	
	/*下载模板 */
	 public function ajax_data_templet(){	  			
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("库位信息导出")->setDescription("备份数据");	
      //设置当前的sheet	  
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','检索号')
            ->setCellValue('B1','库位号')
            ->setCellValue('C1','库位说明')
            ->setCellValue('D1','操作人员')
			->setCellValue('E1','操作时间')
            ->setCellValue('F1','状态')			 
		  	 ->setCellValue('A2',1)
            ->setCellValue('B2','c1')
            ->setCellValue('C2',65)
            ->setCellValue('D2',23)
			->setCellValue('E2','2015-09-15 15:33:58')
            ->setCellValue('F2','启用');
			//设置单元格的字体颜色
            $PHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $PHPExcel->getActiveSheet()->getStyle( 'F1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			//$objActSheet->getColumnDimension( 'E')->setWidth(30);
			 $PHPExcel->getActiveSheet()->setTitle('库位信息导出模板-'.date('Y-m-d',time()));         
			 //创建第二个工作表
            $msgWorkSheet = new PHPExcel_Worksheet($PHPExcel, 'take_care'); //创建一个工作表
            $PHPExcel->addSheet($msgWorkSheet); //插入工作表
            $PHPExcel->setActiveSheetIndex(1); //切换到新创建的工作表
			$PHPExcel->getActiveSheet()->mergeCells('A2:C3');
			$PHPExcel->getActiveSheet()->mergeCells('A4:C5');
			$PHPExcel->getActiveSheet()->mergeCells('A6:C7');
			$PHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A2','红色标示的字段不可以为空')
            ->setCellValue('A4','重量和价值必须为正数')
            ->setCellValue('A6','件数必须为正整数');
			$PHPExcel->getActiveSheet()->setTitle('库位信息导出注意事项');
			 header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			 header("Content-Disposition:attachment; filename=库位信息下载模板.xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');
			// $objPHPExcel->disconnectWorksheets();
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
		 //PC::debug($status);
        if(in_array($status,array('Y','N','YN',true))){
            $condition['status'] = $status; 
        }
        
        $total = $this->location_model->count_num($condition);  
     
        $page_string = $this->common_page->page_string($total, $limit, $page);
     	  file_put_contents("D:/456.txt",var_export($page_string,true)."\r\n",FILE_APPEND);	
        $list = $this->location_model->get_list($condition,$limit,$offset);
		 file_put_contents("D:/456.txt",var_export($list,true)."\r\n",FILE_APPEND);	
		 $list1 = $this->location_model->get_operuser_id();
                   
        foreach($list as $k=>$v){
            if($list[$k]['STATUS'] = ($v['STATUS'] == 'Y' )  )   
			{$list[$k]['STATUS']='启用';}
			else if($list[$k]['STATUS'] = ($v['STATUS'] == 'N' ) )
            {$list[$k]['STATUS']='停用';}
	        else if($list[$k]['STATUS'] = ($v['STATUS'] == 'YN' ) )
            { $list[$k]['STATUS']='忽略';}				
        }
		  foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['OPERUSER_ID'] == $list1[$k1]['USER_ID'])   
			    {
				$list[$k]['OPERUSER_ID'] = $list1[$k1]['USER_NAME'];}  
                }
              }
		//PC::debug($list);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

	
		/*导出功能 */
	 public function ajax_data_export(){	  			
	 $condition = array();
		
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
		 //PC::debug($status);
        if(in_array($status,array('Y','N','YN',true))){
            $condition['status'] = $status; 
        }
        
        $total = $this->location_model->export_data($condition); 
        $total1 = $this->location_model->get_operuser_id();		
	    foreach($total as $k=>$v){
            if($total[$k]['STATUS'] = ($v['STATUS'] == 'Y' )  )   
			{$total[$k]['STATUS']='启用';}
			else if($total[$k]['STATUS'] = ($v['STATUS'] == 'N' ) )
            {$total[$k]['STATUS']='停用';}
	        else if($total[$k]['STATUS'] = ($v['STATUS'] == 'YN' ) )
            { $total[$k]['STATUS']='忽略';}				
        }
		 foreach($total1 as $k1=>$v1){
			   foreach($total as $k=>$v){
               if($total[$k]['OPERUSER_ID'] == $total1[$k1]['USER_ID'])   
			    {
				$total[$k]['OPERUSER_ID'] = $total1[$k1]['USER_NAME'];}  
                }
              }
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("库位信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','检索号')
            ->setCellValue('B1','库位号')
            ->setCellValue('C1','库位说明')
            ->setCellValue('D1','操作人员')
			->setCellValue('E1','操作时间')
            ->setCellValue('F1','状态');
//PC::debug($total);			
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
			 //设置宽度
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:F1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
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
			'operuser_id'   =>$_SESSION['USER_ID'],			
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
