<?php
/**
 *企业操作
 *
 *
 **/
class Customer extends MY_Controller {

     public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('customer_model');      
        
    }

    /**
    *index页面
    *
    *
    * */
     public function index()
    {
         $this->load->view('CBS/customer', '');
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
        
		 //获取检索号
        $index_no = $this->input->get_post("index_no");
        if(!empty($index_no)){
            $condition['index_no'] = $index_no;
        }
		
        //获取客户编号
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)){
            $condition['customer_code'] = $customer_code;
        }

		 //获取客户名称
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['customer_name'] = $customer_name;
        }
		 //获取客户简称
        $customer_sname = $this->input->get_post("customer_sname");
        if(!empty($customer_sname)){
            $condition['customer_sname'] = $customer_sname;
        }
		
		 //获取客户类型
		  $customer_type = $this->input->get_post("customer_type"); 
        if(in_array($customer_type,array('1',true))){
            $condition['customer_type'] = $customer_type; 
        }
       
		
		 //获取税务登记号
        $tax_registid = $this->input->get_post("tax_registid");
        if(!empty($tax_registid)){
            $condition['tax_registid'] = $tax_registid;
        }
		
        //企业海关备案编号
        $linenoindex = $this->input->get_post("linenoindex");
        if(!empty($linenoindex)){
            $condition['linenoindex'] = $linenoindex;
        }
        
        $total = $this->customer_model->count_num($condition);      
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->customer_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['CUSTOMER_TYPE'] = ($v['CUSTOMER_TYPE'] == '1' )?"快递公司":"其他";                      
        }
		 foreach($list as $k=>$v){
            if($list[$k]['STATUS'] = ($v['STATUS'] == 'Y' )  )   
			{$list[$k]['STATUS']='启用';}
			else if($list[$k]['STATUS'] = ($v['STATUS'] == 'N' ) )
            {$list[$k]['STATUS']='停用';}
	        else if($list[$k]['STATUS'] = ($v['STATUS'] == 'YN' ) )
            { $list[$k]['STATUS']='忽略';}		   
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	 public function ajax_data_export(){	  			
	 $condition = array();
		 //获取检索号
        $index_no = $this->input->get_post("index_no");
        if(!empty($index_no)){
            $condition['index_no'] = $index_no;
        }
		
        //获取客户编号
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)){
            $condition['customer_code'] = $customer_code;
        }

		 //获取客户名称
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['customer_name'] = $customer_name;
        }
		
		 //获取客户简称
        $customer_sname = $this->input->get_post("customer_sname");
        if(!empty($customer_sname)){
            $condition['customer_sname'] = $customer_sname;
        }
		
		 //获取客户类型
		  $customer_type = $this->input->get_post("customer_type"); 
        if(in_array($customer_type,array('1',true))){
            $condition['customer_type'] = $customer_type; 
        }
       
		
		 //获取税务登记号
        $tax_registid = $this->input->get_post("tax_registid");
        if(!empty($tax_registid)){
            $condition['tax_registid'] = $tax_registid;
        }
		
        //企业海关备案编号
        $linenoindex = $this->input->get_post("linenoindex");
        if(!empty($linenoindex)){
            $condition['linenoindex'] = $linenoindex;
        }
        
        $total = $this->customer_model->export_data($condition);      
	    foreach($total as $k=>$v){
            $total[$k]['CUSTOMER_TYPE'] = ($v['CUSTOMER_TYPE'] == '1' )?"快递公司":"其他";                      
        }
		 foreach($total as $k=>$v){
            if($total[$k]['STATUS'] = ($v['STATUS'] == 'Y' )  )   
			{$total[$k]['STATUS']='启用';}
			else if($total[$k]['STATUS'] = ($v['STATUS'] == 'N' ) )
            {$total[$k]['STATUS']='停用';}
	        else if($total[$k]['STATUS'] = ($v['STATUS'] == 'YN' ) )
            { $total[$k]['STATUS']='忽略';}		   
        }
      $this->load->library("phpexcel");//ci框架中引入excel类
	  $PHPExcel = new PHPExcel();	  
	 // $PHPExcel->getProperties()->setTitle("客户信息导出")->setDescription("备份数据");	 
      $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','检索号')
			 ->setCellValue('B1','客户编号')
            ->setCellValue('C1','客户名称')
			->setCellValue('D1','客户简称')
            ->setCellValue('E1','操作时间')
            ->setCellValue('F1','状态')
			->setCellValue('G1','企业海关备案编号');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['INDEX_NO'])    
                          ->setCellValue('B'.$num, $v['CUSTOMER_CODE'])
                          ->setCellValue('C'.$num, $v['CUSTOMER_NAME'])
						  ->setCellValue('D'.$num, $v['CUSTOMER_SNAME'])    
                          ->setCellValue('E'.$num, $v['OPERDATE'])
                          ->setCellValue('F'.$num, $v['STATUS'])						  
						  ->setCellValue('G'.$num, $v['LINENOINDEX']);
            }			
		   $PHPExcel->getActiveSheet()->setTitle('客户信息导出-'.date('Y-m-d',time()));
           $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
           $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
           $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		   $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		   $PHPExcel->getActiveSheet()->getStyle('A1:G1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		  // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }

 /**
    *customer_add页面
    *
    *
    * */
     public function add()
    {

         $this->load->view('CBS/customer_add', '');
    }
	
	
	 /**
    *添加库位处理
    *
    *
    * */
    public function doadd(){
        $index_no       = $this->input->get_post("index_no");
		 if(!empty($index_no)) {
            $condition['index_no'] = $index_no;
        }else {
            echo result_to_towf_new('1', 0, '检索号不能为空', NULL);
            exit();
        }
		
        $CUSTOMER_CODE   = $this->input->get_post("CUSTOMER_CODE");
		 if(!empty($CUSTOMER_CODE)) {
            $condition['CUSTOMER_CODE'] = $CUSTOMER_CODE;
        }else {
            echo result_to_towf_new('1', 0, '客户编号不能为空', NULL);
            exit();
        }
		$condition1 = array();
		$condition1['CUSTOMER_CODE'] = $CUSTOMER_CODE;
		 $data['info'] =  $this->customer_model->repeat1($condition1);
        if($data['info']){ 
            echo result_to_towf_new('1', 0, '客户编号不能重复输入，请重新输入！', NULL);
            exit();
        }
		$CUSTOMER_NAME    = $this->input->get_post("CUSTOMER_NAME");
		 if(!empty($CUSTOMER_NAME)) {
            $condition['CUSTOMER_NAME'] = $CUSTOMER_NAME;
        }else {
            echo result_to_towf_new('1', 0, '客户名称不能为空', NULL);
            exit();
        }
		$condition2 = array();
		$condition2['CUSTOMER_NAME'] = $CUSTOMER_NAME;
		 $data['info'] =  $this->customer_model->repeat2($condition2);
        if($data['info']){ 
            echo result_to_towf_new('1', 0, '客户名称不能重复输入，请重新输入！', NULL);
            exit();
        }
        $CUSTOMER_SNAME = $this->input->get_post("CUSTOMER_SNAME");
		 if(!empty($CUSTOMER_SNAME)) {
            $condition['CUSTOMER_SNAME'] = $CUSTOMER_SNAME;
        }else {
            echo result_to_towf_new('1', 0, '客户简称不能为空', NULL);
            exit();
        }
		$condition3 = array();
		$condition3['CUSTOMER_SNAME'] = $CUSTOMER_SNAME;
		 $data['info'] =  $this->customer_model->repeat3($condition3);
        if($data['info']){ 
            echo result_to_towf_new('1', 0, '客户简称不能重复输入，请重新输入！', NULL);
            exit();
        }
        $CUSTOMER_ENGLISH         = $this->input->get_post("CUSTOMER_ENGLISH");
        $CUSTOMER_TYPE   = $this->input->get_post("CUSTOMER_TYPE");
		 if(!empty($CUSTOMER_TYPE)) {
            $condition['CUSTOMER_TYPE'] = $CUSTOMER_TYPE;
        }else {
            echo result_to_towf_new('1', 0, '客户类型不能为空', NULL);
            exit();
        }
		$INVOICE_NAME    = $this->input->get_post("INVOICE_NAME");
        $INVOICE_ADDR = $this->input->get_post("INVOICE_ADDR");
        $BANK_ACCOUNT         = $this->input->get_post("BANK_ACCOUNT");
		$TAX_REGISTID   = $this->input->get_post("BUSINESS_ID");
		$COMPANY_NAME    = $this->input->get_post("COMPANY_NAME");
        $COMPANY_ADDR = $this->input->get_post("COMPANY_ADDR");      
	   $POSTCODE         = $this->input->get_post("POSTCODE");
		$URL   = $this->input->get_post("URL");
		$LAWER    = $this->input->get_post("LAWER");
        $REGISTERED_FUND = $this->input->get_post("REGISTERED_FUND");
        $COMPANY_ADDR         = $this->input->get_post("COMPANY_ADDR");
		$TEL   = $this->input->get_post("TEL");
		$FAX    = $this->input->get_post("FAX");
        $STATUS = $this->input->get_post("STATUS");
        $PICKUP_ADDR         = $this->input->get_post("PICKUP_ADDR");
		 $BUSINESS_USER         = $this->input->get_post("BUSINESS_USER");
		  $DISCHARGE_PLACE         = $this->input->get_post("DISCHARGE_PLACE");
		   $LINENOINDEX         = $this->input->get_post("LINENOINDEX");
		    if(!empty($LINENOINDEX)) {
            $condition['LINENOINDEX'] = $LINENOINDEX;
        }else {
            echo result_to_towf_new('1', 0, '企业海关备案编号不能为空', NULL);
            exit();
        }
		    $REMARK1         = $this->input->get_post("REMARK1");
       
        //插入数据
        $data = array(
            'guid'          =>guid_create(),
            'index_no'      =>$index_no,
            'CUSTOMER_CODE'  =>$CUSTOMER_CODE,
			'CUSTOMER_NAME'   =>$CUSTOMER_NAME,			
            'CUSTOMER_SNAME'=>$CUSTOMER_SNAME,
            'CUSTOMER_ENGLISH'        =>$CUSTOMER_ENGLISH,
            'CUSTOMER_TYPE'      =>$CUSTOMER_TYPE,
            'INVOICE_NAME'  =>$INVOICE_NAME,
			'INVOICE_ADDR'   =>$INVOICE_ADDR,			
            'BANK_ACCOUNT'=>$BANK_ACCOUNT,
            'TAX_REGISTID'        =>$TAX_REGISTID,
            'COMPANY_NAME'      =>$COMPANY_NAME,
            'COMPANY_ADDR'  =>$COMPANY_ADDR,
			'POSTCODE'   =>$POSTCODE,			
            'URL'=>$URL,
            'LAWER'        =>$LAWER,
            'REGISTERED_FUND'      =>$REGISTERED_FUND,
            'COMPANY_ADDR'  =>$COMPANY_ADDR,
			'TEL'   =>$TEL,			
            'FAX'=>$FAX,
            'STATUS'        =>$STATUS,
            'PICKUP_ADDR'      =>$PICKUP_ADDR,
            'BUSINESS_USER'  =>$BUSINESS_USER,
			'DISCHARGE_PLACE'   =>$DISCHARGE_PLACE,			
            'LINENOINDEX'=>$LINENOINDEX,
            'REMARK1'        =>$REMARK1,
            'operdate'      =>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->customer_model->insert($data);
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
		$list['info'] = $this->customer_model->get_list($condition);  
      //print_r($list);	
	    $this->load->view('CBS/customer_edit', $list);

    }
	
/**
    *处理编辑
    *
    *
    * */
     public function do_edit()
    {
        $GUID = $this->input->get_post("GUID");
        $INDEX_NO = $this->input->get_post("INDEX_NO");
		 if(!empty($INDEX_NO)) {
            $condition['INDEX_NO'] = $INDEX_NO;
        }else {
            echo result_to_towf_new('1', 0, '检索号不能为空', NULL);
            exit();
        }
		$CUSTOMER_CODE   = $this->input->get_post("CUSTOMER_CODE");
		 if(!empty($CUSTOMER_CODE)) {
            $condition['CUSTOMER_CODE'] = $CUSTOMER_CODE;
        }else {
            echo result_to_towf_new('1', 0, '客户编号不能为空', NULL);
            exit();
        }
		$CUSTOMER_NAME   = $this->input->get_post("CUSTOMER_NAME");	
       if(!empty($CUSTOMER_NAME)) {
            $condition['CUSTOMER_NAME'] = $CUSTOMER_NAME;
        }else {
            echo result_to_towf_new('1', 0, '客户名称不能为空', NULL);
            exit();
        }		
		$CUSTOMER_SNAME    = $this->input->get_post("CUSTOMER_SNAME");
		 if(!empty($CUSTOMER_SNAME)) {
            $condition['CUSTOMER_SNAME'] = $CUSTOMER_SNAME;
        }else {
            echo result_to_towf_new('1', 0, '客户简称不能为空', NULL);
            exit();
        }
        $CUSTOMER_ENGLISH         = $this->input->get_post("CUSTOMER_ENGLISH");
		$CUSTOMER_TYPE   = $this->input->get_post("CUSTOMER_TYPE");
		 if(!empty($CUSTOMER_TYPE)) {
            $condition['CUSTOMER_TYPE'] = $CUSTOMER_TYPE;
        }else {
            echo result_to_towf_new('1', 0, '客户类型不能为空', NULL);
            exit();
        }
		$INVOICE_NAME   = $this->input->get_post("INVOICE_NAME");		
		$INVOICE_ADDR    = $this->input->get_post("INVOICE_ADDR");
        $BANK_ACCOUNT         = $this->input->get_post("BANK_ACCOUNT");
		$TAX_REGISTID   = $this->input->get_post("TAX_REGISTID");
		$BUSINESS_ID   = $this->input->get_post("BUSINESS_ID");		
		$COMPANY_NAME    = $this->input->get_post("COMPANY_NAME");
       
	   $COMPANY_ADDR         = $this->input->get_post("COMPANY_ADDR");
		$POSTCODE   = $this->input->get_post("POSTCODE");
		$URL   = $this->input->get_post("URL");		
		$LAWER    = $this->input->get_post("LAWER");
        $REGISTERED_FUND         = $this->input->get_post("REGISTERED_FUND");
		$TEL   = $this->input->get_post("TEL");
		$FAX   = $this->input->get_post("FAX");		
		$STATUS    = $this->input->get_post("STATUS");
        $BUSINESS_USER         = $this->input->get_post("BUSINESS_USER");
		$PICKUP_ADDR   = $this->input->get_post("PICKUP_ADDR");
		$DISCHARGE_PLACE   = $this->input->get_post("DISCHARGE_PLACE");		
		$LINENOINDEX    = $this->input->get_post("LINENOINDEX");
          if(!empty($LINENOINDEX)) {
            $condition['LINENOINDEX'] = $LINENOINDEX;
        }else {
            echo result_to_towf_new('1', 0, '企业海关备案编号不能为空', NULL);
            exit();
        }
         //编辑数据
        $data = array(  
            'GUID'      =>$GUID,		
            'INDEX_NO'      =>$INDEX_NO,
            'CUSTOMER_CODE'  =>$CUSTOMER_CODE,
			'CUSTOMER_NAME'   =>$CUSTOMER_NAME,			
            'CUSTOMER_SNAME'=>$CUSTOMER_SNAME,
            'CUSTOMER_ENGLISH'        =>$CUSTOMER_ENGLISH,
			'CUSTOMER_TYPE'      =>$CUSTOMER_TYPE,
            'INVOICE_NAME'  =>$INVOICE_NAME,
			'INVOICE_ADDR'   =>$INVOICE_ADDR,			
            'BANK_ACCOUNT'=>$BANK_ACCOUNT,
            'TAX_REGISTID'        =>$TAX_REGISTID,
			'BUSINESS_ID'      =>$BUSINESS_ID,
            'COMPANY_NAME'  =>$COMPANY_NAME,
			'COMPANY_ADDR'   =>$COMPANY_ADDR,			
            'POSTCODE'=>$POSTCODE,
            'URL'        =>$URL,
			'LAWER'      =>$LAWER,
            'REGISTERED_FUND'  =>$REGISTERED_FUND,
			'TEL'   =>$TEL,			
            'FAX'=>$FAX,
            'STATUS'        =>$STATUS,
			'BUSINESS_USER'      =>$BUSINESS_USER,
            'PICKUP_ADDR'  =>$PICKUP_ADDR,
			'DISCHARGE_PLACE'   =>$DISCHARGE_PLACE,			
            'LINENOINDEX'=>$LINENOINDEX,            
            'operdate'      =>date('Y-m-d h:i:s',time())
        );
		
       $this->customer_model->update($data,$GUID);
	    echo result_to_towf_new('1', 1, 'success', null);
    }
	
	 /**
    *删除客户信息
    *
    *
    * */
     public function delete()
    { 
         $data = $this->input->get_post("guid");
        if ($data) {		 
		$this->customer_model->delete($data);  
       
          }
		   echo result_to_towf_new('1', 1, 'success', null);
    }



}
