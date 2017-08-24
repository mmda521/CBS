<?php
/**
 *出库操作
 *
 *
 **/
class Chuku extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('chuku_model');      
        
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
        $TOTALTRANSFERNO = $this->input->get_post("TOTALTRANSFERNO");
        if(!empty($TOTALTRANSFERNO)){
            $condition['TOTALTRANSFERNO'] = $TOTALTRANSFERNO;
        }
	  //获取分运单号
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取品名
        $STATUS = $this->input->get_post("STATUS");
        if(!empty($STATUS)){
            $condition['STATUS'] = $STATUS;
        }
		
		 //获取包装情况
        $CUSTOMSCODE = $this->input->get_post("CUSTOMSCODE");
        if(!empty($CUSTOMSCODE)){
            $condition['CUSTOMSCODE'] = $CUSTOMSCODE;
        }
        //获取出库时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['BIZTIME>'] = $STA_DATE;
        }
		 //获取出库时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['BIZTIME<'] = $END_DATE;
        }
        $total = $this->chuku_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->chuku_model->get_list($condition,$limit,$offset);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

	
	
	public function ajax_data_export(){
       
        $condition = array();
        
		 //获取总运单号
        $TOTALTRANSFERNO = $this->input->get_post("TOTALTRANSFERNO");
        if(!empty($TOTALTRANSFERNO)){
            $condition['TOTALTRANSFERNO'] = $TOTALTRANSFERNO;
        }
	  //获取分运单号
        $LOGISTICSCODE = $this->input->get_post("LOGISTICSCODE");
        if(!empty($LOGISTICSCODE)){
            $condition['LOGISTICSCODE'] = $LOGISTICSCODE;
        }
		 //获取品名
        $STATUS = $this->input->get_post("STATUS");
        if(!empty($STATUS)){
            $condition['STATUS'] = $STATUS;
        }
		
		 //获取包装情况
        $CUSTOMSCODE = $this->input->get_post("CUSTOMSCODE");
        if(!empty($CUSTOMSCODE)){
            $condition['CUSTOMSCODE'] = $CUSTOMSCODE;
        }
        //获取出库时间
        $STA_DATE = $this->input->get_post("STA_DATE");
        if(!empty($STA_DATE)){
            $condition['BIZTIME>'] = $STA_DATE;
        }
		 //获取出库时间
        $END_DATE = $this->input->get_post("END_DATE");
        if(!empty($END_DATE)){
            $condition['BIZTIME<'] = $END_DATE;
        }
        $total = $this->chuku_model->export_data($condition); 
		
        $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  //$PHPExcel->getProperties()->setTitle("库位信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','单证号')
            ->setCellValue('B1','物流企业备案编码')
            ->setCellValue('C1','审核状态')
            ->setCellValue('D1','海关编码')
			->setCellValue('E1','审核日期')
            ->setCellValue('F1','备注');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['TOTALTRANSFERNO'])    
                          ->setCellValue('B'.$num, $v['LOGISTICSCODE'])
                          ->setCellValue('C'.$num, $v['STATUS'])
						  ->setCellValue('D'.$num, $v['CUSTOMSCODE'])    
                          ->setCellValue('E'.$num, $v['BIZTIME'])
                          ->setCellValue('F'.$num, $v['COMMENTS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('出库查询信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			//设置水平居中
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
    *出库查询
    *
    *
    * */
     public function chuku_search()
    {
         $this->load->view('CBS/chuku_search', '');
    }


}
