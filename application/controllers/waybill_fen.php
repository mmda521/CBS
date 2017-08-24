<?php
/**
 *运单操作
 *
 *
 **/
class Waybill_fen extends MY_Controller {

  public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        $this->load->model('waybill_model');
        $this->load->model('batch_model');		
        
    }  
	
	
		/*导出功能 */
	 public function ajax_data_export(){	  			
		
		 //获取检索号
        $GUID = $this->input->get_post("guid");
        $total = $this->waybill_model->export_hbl_data1($GUID); 
 		// PC::debug($total);
        $list1 = $this->waybill_model->currtype();
		 $list2 = $this->waybill_model->customer();
         $list3 = $this->waybill_model->get_operuser_id();
       
		 foreach($list1 as $k1=>$v1){
			   foreach($total as $k=>$v){
               if($total[$k]['CURRENCY'] == $list1[$k1]['CURRTYPECODE'])   
			    {
				$total[$k]['CURRENCY'] = $list1[$k1]['CURRTYPENAME'];}  
                }
              }
		
		 foreach($list2 as $k2=>$v2){
			   foreach($total as $k=>$v){
               if($total[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$total[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
			    foreach($list3 as $k3=>$v3){
			   foreach($total as $k=>$v){
               if($total[$k]['CREATE_USER'] == $list3[$k3]['USER_ID'])   
			    {
				$total[$k]['CREATE_USER'] = $list3[$k3]['USER_NAME'];}  
                }
              }
		$savename = date("YmdHis"); 	  
	 $filename="FILE".$savename.".xlsx";	  
	  $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	  $PHPExcel->getProperties()->setTitle("分运单信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次号')
            ->setCellValue('C1','分运单号')
            ->setCellValue('D1','英文货物名称')
			->setCellValue('E1','主要货物名称')
            ->setCellValue('F1','件数')
			->setCellValue('G1','重量（公斤）')
            ->setCellValue('H1','价值')
            ->setCellValue('I1','币制')
            ->setCellValue('J1','申报时间')
			->setCellValue('K1','创建时间')
            ->setCellValue('L1','创建人')
			->setCellValue('M1','收件人')
            ->setCellValue('N1','发件人')
            ->setCellValue('O1','监管场所海关备案编码')
            ->setCellValue('P1','物流企业检验检疫备案编号CIQ')
			->setCellValue('Q1','客户')
            ->setCellValue('R1','物流企业海关备案编号')
			->setCellValue('S1','电商企业名称');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['MBL'])    
                          ->setCellValue('B'.$num, $v['BATCHNO'])
                          ->setCellValue('C'.$num, " ".$v['HBL'])
						  ->setCellValue('D'.$num, $v['GOODS_NAME_EN'])    
                          ->setCellValue('E'.$num, $v['GOODS_NAME_IMPORT'])
                          ->setCellValue('F'.$num, $v['NUM'])
						   ->setCellValue('G'.$num, $v['WEIGHT'])    
                          ->setCellValue('H'.$num, $v['PRICE'])
                          ->setCellValue('I'.$num, $v['CURRENCY'])
						  ->setCellValue('J'.$num, $v['APP_DATE'])    
                          ->setCellValue('K'.$num, $v['CREATE_DATE'])
                          ->setCellValue('L'.$num, $v['CREATE_USER'])
						   ->setCellValue('M'.$num, $v['RECV_USER'])    
                          ->setCellValue('N'.$num, $v['SEND_USER'])
                          ->setCellValue('O'.$num, $v['APPLIEDCOMPANY'])
						  ->setCellValue('P'.$num, $v['TRANSFERCOMPANYCIQ'])    
                          ->setCellValue('Q'.$num, $v['CUSTOMER_CODE'])
                          ->setCellValue('R'.$num, $v['GOODSNO'])
						   ->setCellValue('S'.$num, $v['E_BUSINESS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('分单信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			  $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
			  $PHPExcel->getActiveSheet()->getStyle('E2:E1000')->getAlignment()->setWrapText(true);
			 $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			  $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			   $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
			  $PHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
			 $PHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
			  $PHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:S1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		   
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
    *ajax查看总单数据
    *
    *
    * */
     public function ajax_data_search(){
        //获取分页第几页
        $page = $this->input->get_post("page"); 
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition10 = array();
        
		 //获取进出口标志
        $MBL = $this->input->get_post("MBL");
       
		 if(!empty($MBL)) {
            $condition10['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总运单号信息为空', NULL);
            exit();
        }		
		 $BATCHNO = $this->input->get_post("BATCHNO");
        if(!empty($BATCHNO)){
            $condition10['BATCHNO'] = $BATCHNO;
        }else {
            echo result_to_towf_new('1', 0, '批次号信息为空', NULL);
            exit();
        }		
		 
         $total = $this->waybill_model->count_num_hbl($condition10);  
		 //PC::debug($total);
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->waybill_model->get_list_hbl($condition10,$limit,$offset);
		 $list1 = $this->waybill_model->currtype();
		 $list2 = $this->waybill_model->customer();
		  $list3 = $this->waybill_model->get_operuser_id();
        //PC::debug($list); 
       
		 foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['CURRENCY'] == $list1[$k1]['CURRTYPECODE'])   
			    {
				$list[$k]['CURRENCY'] = $list1[$k1]['CURRTYPENAME'];}  
                }
              }
		
		 foreach($list2 as $k2=>$v2){
			   foreach($list as $k=>$v){
               if($list[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$list[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
			  
			  foreach($list3 as $k3=>$v3){
			   foreach($list as $k=>$v){
               if($list[$k]['CREATE_USER'] == $list3[$k3]['USER_ID'])   
			    {
				$list[$k]['CREATE_USER'] = $list3[$k3]['USER_NAME'];}  
                }
              }
		
		//PC::debug($list);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
	 /**
    *分运单页面
    *
    *
    * */
	
 public function add_fen(){
		
		 $this->load->view('CBS/waybill_input_fen');
		 
	 }
	 /**
    *添加分运单信息
    *
    *
    * */
    public function doadd_fen(){
        $condition = array();		
		$MBL       = $this->input->get_post("MBL");	
        if(!empty($MBL)) {
            $condition['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总单号不能为空', NULL);
            exit();
        }
		$condition1 = array();
		$condition1['MBL'] = $MBL;
		 $data['info'] =  $this->batch_model->get_batch_mbl($MBL);
        if(!$data['info']){ 
            echo result_to_towf_new('1', 0, '请录入总单信息之后再来进行操作！', NULL);
            exit();
        }		
		$BATCHNO       = $this->input->get_post("BATCHNO");
		 if(!empty($BATCHNO)) {
            $condition['BATCHNO'] = $BATCHNO;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
		$condition1['BATCHNO'] = $BATCHNO;
		 $data1['info'] =  $this->batch_model->get_batch($condition1);
		// PC::debug($data);
        if(!$data1['info']){ 
            echo result_to_towf_new('1', 0, '请录入批次信息之后再来进行操作！', NULL);
            exit();
        }		
        $HBL       = $this->input->get_post("HBL");
		if(!empty($HBL)) {
            $condition['HBL'] = $HBL;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
		$condition8 = array();
		$condition8['HBL'] = $HBL;
		//PC::debug($condition7);
		 $data['info'] =  $this->waybill_model->get_list_hbl($condition8,'','');
		// PC::debug($data);
        if($data['info']){ 
            echo result_to_towf_new('1', 0, '分运单号不能重复输入，请重新输入！', NULL);
            exit();
        }
        $GOODS_NAME_EN   = $this->input->get_post("GOODS_NAME_EN");
		$GOODS_NAME_IMPORT    = $this->input->get_post("GOODS_NAME_IMPORT");
		//PC::debug($GOODS_NAME_IMPORT);
		if(!empty($GOODS_NAME_IMPORT)) {
            $condition['GOODS_NAME_IMPORT'] = $GOODS_NAME_IMPORT;
        }else {
            echo result_to_towf_new('1', 0, '主要货物名称不能为空', NULL);
            exit();
        }
        $NUM = $this->input->get_post("NUM");
		if(!empty($NUM)) {
            $condition['NUM'] = $NUM;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $WEIGHT         = $this->input->get_post("WEIGHT");
		if(!empty($WEIGHT)) {
            $condition['WEIGHT'] = $WEIGHT;
        }else {
            echo result_to_towf_new('1', 0, '重量（公斤）不能为空', NULL);
            exit();
        }
		$PRICE       = $this->input->get_post("PRICE");
        $CURRENCY   = $this->input->get_post("CURRENCY");
		$APP_DATE    = $this->input->get_post("APP_DATE");
		if(!empty($APP_DATE)) {
            $condition['APP_DATE'] = $APP_DATE;
        }else {
            echo result_to_towf_new('1', 0, '申报时间不能为空', NULL);
            exit();
        }
        $RECV_USER = $this->input->get_post("RECV_USER");
        $SEND_USER         = $this->input->get_post("SEND_USER");
		$APPLIEDCOMPANY       = $this->input->get_post("APPLIEDCOMPANY");
		if(!empty($APPLIEDCOMPANY)) {
            $condition['APPLIEDCOMPANY'] = $APPLIEDCOMPANY;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        $TRANSFERCOMPANYCIQ   = $this->input->get_post("TRANSFERCOMPANYCIQ");
		if(!empty($TRANSFERCOMPANYCIQ)) {
            $condition['TRANSFERCOMPANYCIQ'] = $TRANSFERCOMPANYCIQ;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
		$CUSTOMER_CODE    = $this->input->get_post("CUSTOMER_CODE");
		if(!empty($CUSTOMER_CODE)) {
            $condition['CUSTOMER_CODE'] = $CUSTOMER_CODE;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $GOODSNO = $this->input->get_post("GOODSNO");
		if(!empty($GOODSNO)) {
            $condition['GOODSNO'] = $GOODSNO;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $E_BUSINESS         = $this->input->get_post("E_BUSINESS");
		if(!empty($E_BUSINESS)) {
            $condition['E_BUSINESS'] = $E_BUSINESS;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //PC::debug($F_GUID);
      // print_r($F_GUID);

        //插入数据
        $data = array(
            'guid'          =>guid_create(),		
			'MBL'      =>$MBL,
			'BATCHNO'      =>$BATCHNO,
            'HBL'      =>$HBL,
            'GOODS_NAME_EN'  =>$GOODS_NAME_EN,
			'GOODS_NAME_IMPORT'   =>$GOODS_NAME_IMPORT,			
			'NUM'      =>$NUM,
            'WEIGHT'  =>$WEIGHT,
			'PRICE'   =>$PRICE,			
            'CURRENCY'=>$CURRENCY,
            'APP_DATE'        =>$APP_DATE,
            'CREATE_USER'   =>$_SESSION['USER_ID'],			
            'RECV_USER'=>$RECV_USER,
            'SEND_USER'        =>$SEND_USER,
			'APPLIEDCOMPANY'      =>$APPLIEDCOMPANY,
            'TRANSFERCOMPANYCIQ'  =>$TRANSFERCOMPANYCIQ,
			 'CUSTOMER_CODE'        =>$CUSTOMER_CODE,
			'GOODSNO'      =>$GOODSNO,
            'E_BUSINESS'  =>$E_BUSINESS,
			'CREATE_DATE'      =>date('Y-m-d H:i:s',time())
        );	
		//PC::debug($data);
        $this->waybill_model->insert_hbl($data);
		echo result_to_towf_new('1', 1, 'success', null);  
		
    }
	

 /**
    *删除分运单信息
    *
    *
    * */
     public function delete_hbl()
    { 
         $GUID = $this->input->get_post("guid");
		  //$GUID=$condition[0];
		   //$condition2 = array();
		// $condition2['GUID'] = $GUID;
		 
		 
		// $query=$this->waybill_model->get_select_mbl($condition2);
		 //PC::debug($condition);
        if ($GUID) 
		{
			//PC::debug('23');
            $this->waybill_model->delete_hbl_GUID($GUID);   
        }  	
     echo result_to_towf_new('1', 1, 'success', null); 
    }
	

	
    /**
    *运单分单信息编辑页面
    *
    *
    * */
     public function waybill_input_fen_edit()
	 {  
	 $GUID = $this->input->get_post("GUID");		
		$condition = array();
        $condition['GUID'] = $GUID;
		$list['info'] = $this->waybill_model->get_list_hbl($condition);      
       $this->load->view('CBS/waybill_input_fen_edit',$list);
    }
	
     public function do_waybill_input_fen_edit()
    {
       $condition = array();
		$GUID = $this->input->get_post("GUID");
		$MBL       = $this->input->get_post("MBL");	
        if(!empty($MBL)) {
            $condition['MBL'] = $MBL;
        }else {
            echo result_to_towf_new('1', 0, '总单号不能为空', NULL);
            exit();
        }
		$condition1 = array();
		$condition1['MBL'] = $MBL;
		 $data['info'] =  $this->batch_model->get_batch_mbl($MBL);
        if(!$data['info']){ 
            echo result_to_towf_new('1', 0, '请录入总单信息之后再来进行操作！', NULL);
            exit();
        }		
		$BATCHNO       = $this->input->get_post("BATCHNO");
		 if(!empty($BATCHNO)) {
            $condition['BATCHNO'] = $BATCHNO;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
		$condition1['BATCHNO'] = $BATCHNO;
		//PC::debug($condition7);
		 $data1['info'] =  $this->batch_model->get_batch($condition1);
        if(!$data1['info']){ 
            echo result_to_towf_new('1', 0, '请录入批次信息之后再来进行操作！', NULL);
            exit();
        }		
        $HBL       = $this->input->get_post("HBL");
		if(!empty($HBL)) {
            $condition['HBL'] = $HBL;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
		/*$condition8 = array();
		$condition8['HBL'] = $HBL;
		//PC::debug($condition7);
		 $data['info'] =  $this->waybill_model->get_list_hbl($condition8,'','');
		// PC::debug($data);
        if($data['info']){ 
            echo result_to_towf_new('1', 0, '分运单号不能重复输入，请重新输入！', NULL);
            exit();
        }*/
        $GOODS_NAME_EN   = $this->input->get_post("GOODS_NAME_EN");
	
		$GOODS_NAME_IMPORT    = $this->input->get_post("GOODS_NAME_IMPORT");
			if(!empty($GOODS_NAME_IMPORT)) {
            $condition['GOODS_NAME_IMPORT'] = $GOODS_NAME_IMPORT;
        }else {
            echo result_to_towf_new('1', 0, '主要货物名称不能为空', NULL);
            exit();
        }
        $NUM = $this->input->get_post("NUM");
		if(!empty($NUM)) {
            $condition['NUM'] = $NUM;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $WEIGHT         = $this->input->get_post("WEIGHT");
		if(!empty($WEIGHT)) {
            $condition['WEIGHT'] = $WEIGHT;
        }else {
            echo result_to_towf_new('1', 0, '重量（公斤）不能为空', NULL);
            exit();
        }
		$PRICE       = $this->input->get_post("PRICE");
        $CURRENCY   = $this->input->get_post("CURRENCY");
		$APP_DATE    = $this->input->get_post("APP_DATE");
		if(!empty($APP_DATE)) {
            $condition['APP_DATE'] = $APP_DATE;
        }else {
            echo result_to_towf_new('1', 0, '申报时间不能为空', NULL);
            exit();
        }
        $RECV_USER = $this->input->get_post("RECV_USER");
        $SEND_USER         = $this->input->get_post("SEND_USER");
		$APPLIEDCOMPANY       = $this->input->get_post("APPLIEDCOMPANY");
		if(!empty($APPLIEDCOMPANY)) {
            $condition['APPLIEDCOMPANY'] = $APPLIEDCOMPANY;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        $TRANSFERCOMPANYCIQ   = $this->input->get_post("TRANSFERCOMPANYCIQ");
		if(!empty($TRANSFERCOMPANYCIQ)) {
            $condition['TRANSFERCOMPANYCIQ'] = $TRANSFERCOMPANYCIQ;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
		$CUSTOMER_CODE    = $this->input->get_post("CUSTOMER_CODE");
		if(!empty($CUSTOMER_CODE)) {
            $condition['CUSTOMER_CODE'] = $CUSTOMER_CODE;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $GOODSNO = $this->input->get_post("GOODSNO");
		if(!empty($GOODSNO)) {
            $condition['GOODSNO'] = $GOODSNO;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $E_BUSINESS         = $this->input->get_post("E_BUSINESS");
		if(!empty($E_BUSINESS)) {
            $condition['E_BUSINESS'] = $E_BUSINESS;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //PC::debug($CUSTOMER_CODE);     

        //插入数据
        $data = array(  
            'GUID'      =>$GUID,		
			'MBL'      =>$MBL,
			'BATCHNO'      =>$BATCHNO,
            'HBL'      =>$HBL,
            'GOODS_NAME_EN'  =>$GOODS_NAME_EN,
			'GOODS_NAME_IMPORT'   =>$GOODS_NAME_IMPORT,			
			'NUM'      =>$NUM,
            'WEIGHT'  =>$WEIGHT,
			'PRICE'   =>$PRICE,			
            'CURRENCY'=>$CURRENCY,
            'APP_DATE'        =>$APP_DATE,			
            'RECV_USER'=>$RECV_USER,
            'SEND_USER'        =>$SEND_USER,
			'APPLIEDCOMPANY'      =>$APPLIEDCOMPANY,
            'TRANSFERCOMPANYCIQ'  =>$TRANSFERCOMPANYCIQ,
			 'CUSTOMER_CODE'        =>$CUSTOMER_CODE,
			'GOODSNO'      =>$GOODSNO,
            'E_BUSINESS'  =>$E_BUSINESS,
			'CREATE_DATE'      =>date('Y-m-d H:i:s',time())
        );	
		//PC::debug($data);
       $this->waybill_model->update_hbl($data,$GUID);
	    echo result_to_towf_new('1', 1, 'success', null);       
    }

	
	
	
	  /**
    *运单分单信息查看页面
    *
    *
    * */
     public function waybill_input_fen_search()
	 {  	      
       $this->load->view('CBS/waybill_input_fen_search','');
    }
	
	
	
	
	/*批次下载模板 */
	 public function ajax_data_batch_templet(){	  			
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
      //设置当前的sheet	  
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次')
            ->setCellValue('C1','理货类型')
            ->setCellValue('D1','批次布控')
			->setCellValue('E1','理货状态')          
			->setCellValue('A2','FRA00002185')
            ->setCellValue('B2','GDFN654343D')
            ->setCellValue('C2','0')
            ->setCellValue('D2','0')
			->setCellValue('E2',' ')
            ->setCellValue('A3','FRA00002185')
            ->setCellValue('B3','GDFN654343D')
            ->setCellValue('C3','0')
            ->setCellValue('D3','1')
			->setCellValue('E3',' ');		
			//设置单元格的字颜色
            $PHPExcel->getActiveSheet()->getStyle( 'A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $PHPExcel->getActiveSheet()->getStyle( 'C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getStyle('B10:D11')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('B10:D11')->getFont()->setBold(true);
			//$objActSheet->getColumnDimension( 'E')->setWidth(30);
			 $PHPExcel->getActiveSheet()->setTitle('批次信息下载模板-'.date('Y-m-d',time()));         
            $PHPExcel->setActiveSheetIndex(0); 
			$PHPExcel->getActiveSheet()->mergeCells('B10:D11');
			$PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B10','红色标示的字段不可以为空');		
			 header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			 header("Content-Disposition:attachment; filename=批次信息下载模板.xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');
			// $PHPExcel->disconnectWorksheets();
    }
	
	
	
		/*分单下载模板 */
	 public function ajax_data_hbl_templet(){	  			
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  	
      //设置当前的sheet	  
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次号')
            ->setCellValue('C1','分运单号')
            ->setCellValue('D1','英文货物名称')
			->setCellValue('E1','主要货物名称')
            ->setCellValue('F1','件数')
			->setCellValue('G1','重量（公斤）')
            ->setCellValue('H1','价值')
            ->setCellValue('I1','币制')
            ->setCellValue('J1','申报时间')
			->setCellValue('K1','收件人')
            ->setCellValue('L1','发件人')
            ->setCellValue('M1','申报企业海关备案编码')
			->setCellValue('N1','客户')
            ->setCellValue('O1','物流企业海关备案编号')
			->setCellValue('P1','电商企业名称')
            ->setCellValue('Q1','物流企业检验检疫备案编号CIQ')
			->setCellValue('A2','FRA00002185')
            ->setCellValue('B2','GDFN654343D')
            ->setCellValue('C2'," ".'967506523408')
            ->setCellValue('D2','1')
			->setCellValue('E2','海洋燕窝补水美白安瓶精华面膜(限购1件)')
            ->setCellValue('F2','1')
			->setCellValue('G2','6.5')
            ->setCellValue('H2','9.7')
            ->setCellValue('I2','CNY')
            ->setCellValue('J2','2015年7月2日')
			->setCellValue('K2','陈明霞')
            ->setCellValue('L2','SKY FAITH')
            ->setCellValue('M2','CNZGZ460034')
			->setCellValue('N2'," ".'4101985185')
            ->setCellValue('O2'," ".'4101985185')
			->setCellValue('P2','电商1')
            ->setCellValue('Q2'," ".'4100810004')
			->setCellValue('A3','FRA00002185')
            ->setCellValue('B3','GDFN654343D')
            ->setCellValue('C3'," ".'967506523408')
            ->setCellValue('D3','1')
			->setCellValue('E3','海洋燕窝补水美白安瓶精华面膜(限购1件)')
            ->setCellValue('F3','2')
			->setCellValue('G3','6')
            ->setCellValue('H3','9.7')
            ->setCellValue('I3','CNY')
            ->setCellValue('J3','2015年7月2日')
			->setCellValue('K3','陈明霞')
            ->setCellValue('L3','SKY FAITH')
            ->setCellValue('M3','CNZGZ460034')
			->setCellValue('N3'," ".'4101985185')
            ->setCellValue('O3'," ".'4101985185')
			->setCellValue('P2','电商1')
            ->setCellValue('Q3'," ".'4100810004');		
			//设置单元格的字颜色
            $PHPExcel->getActiveSheet()->getStyle( 'C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $PHPExcel->getActiveSheet()->getStyle( 'F1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'G1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'J1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $PHPExcel->getActiveSheet()->getStyle( 'M1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'N1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'O1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getStyle( 'P1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $PHPExcel->getActiveSheet()->getStyle( 'Q1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		    $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
		    $PHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
			$PHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
			$PHPExcel->getActiveSheet()->getStyle('E10:F15')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('E10:F15')->getFont()->setBold(true);
			//$objActSheet->getColumnDimension( 'E')->setWidth(30);
			 $PHPExcel->getActiveSheet()->setTitle('分单信息下载模板-'.date('Y-m-d',time()));         
            $PHPExcel->setActiveSheetIndex(0); 
			$PHPExcel->getActiveSheet()->mergeCells('E10:F11');
			$PHPExcel->getActiveSheet()->mergeCells('E12:F13');
			$PHPExcel->getActiveSheet()->mergeCells('E14:F15');
			$PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E10','红色标示的字段不可以为空')
            ->setCellValue('E12','重量和价值必须为正数')
            ->setCellValue('E14','件数必须为正整数');		
			 header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			 header("Content-Disposition:attachment; filename=分单信息下载模板.xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');
			// $PHPExcel->disconnectWorksheets();
    }
	
	
	 /**
    *ajax查看总单数据
    *
    *
    * */
     public function ajax_data_hbl(){
        //获取分页第几页
        $page = $this->input->get_post("page"); 
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition9 = array();
        
		 //获取进出口标志
        $MBL = $this->input->get_post("MBL");
        if(!empty($MBL)){
            $condition9['MBL'] = $MBL;
        }
		 //PC::debug($condition9);
		 
		// $query=$this->waybill_model->get_select_mbl($condition9);
		 //PC::debug($query);
         $total = $this->waybill_model->count_num_hbl($condition9);  
		// PC::debug($total);
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->waybill_model->get_list_hbl($condition9,$limit,$offset);
        //PC::debug($list); 
        $list1 = $this->waybill_model->currtype();
		 $list2 = $this->waybill_model->customer();
		  $list3 = $this->waybill_model->get_operuser_id();
        //PC::debug($list); 
       
		 foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['CURRENCY'] == $list1[$k1]['CURRTYPECODE'])   
			    {
				$list[$k]['CURRENCY'] = $list1[$k1]['CURRTYPENAME'];}  
                }
              }
		
		 foreach($list2 as $k2=>$v2){
			   foreach($list as $k=>$v){
               if($list[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$list[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
			    foreach($list3 as $k3=>$v3){
			   foreach($list as $k=>$v){
               if($list[$k]['CREATE_USER'] == $list3[$k3]['USER_ID'])   
			    {
				$list[$k]['CREATE_USER'] = $list3[$k3]['USER_NAME'];}  
                }
              }
		//PC::debug($list);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
}
