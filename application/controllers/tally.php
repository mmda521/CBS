<?php
class Tally extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");
        $this->load->library('session');
        //$this->load->model('M_common','',false , array('type'=>'real_data'));
        $this->load->model('tally_model');
    }
    /**
    *
    *批次理货
    *
    * */
    public function inser()
    {
        $this->load->view('CBS/view_in', '');
    }
     public function tally_batch()
    {
        $this->load->view('CBS/tally_batch', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function tally_batch_ajax_data(){
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
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取客户
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['CUSTOMER_CODE'] = $customer_name;
        }
        //进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(in_array($i_e_type,array('I','E',true))){
            $condition['I_E_TYPE'] = $i_e_type;
        }
        //获取起始日期
        $tally_sdate = $this->input->get_post("tally_sdate");
        if(!empty($tally_sdate)){
            $condition['TALLY_DATE >'] = $tally_sdate;
        }
        //获取结束日期
        $tally_edate = $this->input->get_post("tally_edate");
        if(!empty($tally_edate)){
            $condition['TALLY_DATE <'] = $tally_edate;
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)){
            $condition['E_BUSINESS'] = $e_business;
        }
        $condition['BATCHTYPE'] ='0';
        $total = $this->tally_model->count_num($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list($condition,$limit,$offset);
		$list1 = $this->tally_model->location();
		$list2 = $this->tally_model->customer();
        foreach($list as $k=>$v){
            $list[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I' )?"进口":"出口";          
        }
		 foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$list[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
			   foreach($list2 as $k2=>$v2){
			   foreach($list as $k=>$v){
               if($list[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$list[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
	//批次理货导出
	
	 public function tally_batch_ajax_data_export(){       
       
	   $condition = array();
        //获取总运单号
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取客户
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['CUSTOMER_CODE'] = $customer_name;
        }
        //进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(in_array($i_e_type,array('I','E',true))){
            $condition['I_E_TYPE'] = $i_e_type;
        }
        //获取起始日期
        $tally_sdate = $this->input->get_post("tally_sdate");
        if(!empty($tally_sdate)){
            $condition['TALLY_DATE >'] = $tally_sdate;
        }
        //获取结束日期
        $tally_edate = $this->input->get_post("tally_edate");
        if(!empty($tally_edate)){
            $condition['TALLY_DATE <'] = $tally_edate;
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)){
            $condition['E_BUSINESS'] = $e_business;
        }
        $condition['BATCHTYPE'] ='0';
        
       
        $total = $this->tally_model->export_data($condition);
		$list1 = $this->tally_model->location();
		$list2 = $this->tally_model->customer();
        foreach($total as $k=>$v){
            $total[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I' )?"进口":"出口";       
        }
		foreach($list1 as $k1=>$v1){
			   foreach($total as $k=>$v){
               if($total[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$total[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
			   foreach($list2 as $k2=>$v2){
			   foreach($total as $k=>$v){
               if($total[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$total[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
         $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次号')
            ->setCellValue('C1','分运单号')
            ->setCellValue('D1','品名')
			->setCellValue('E1','进出口标识')
            ->setCellValue('F1','货物抵运日期')
			->setCellValue('G1','件数')
            ->setCellValue('H1','重量KG')
            ->setCellValue('I1','理货件数')
            ->setCellValue('J1','理货重量')
			->setCellValue('K1','库位')
            ->setCellValue('L1','客户')
			->setCellValue('M1','物流企业海关备案编号')
            ->setCellValue('N1','电商企业名称')
            ->setCellValue('O1','物流企业检验检疫备案编号CTQ')
            ->setCellValue('P1','理货状态');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, " ".$v['MBL'])    
                          ->setCellValue('B'.$num, $v['BATCHNO'])
                          ->setCellValue('C'.$num, " ".$v['HBL'])
						  ->setCellValue('D'.$num, $v['GOODS_NAME'])    
                          ->setCellValue('E'.$num, $v['I_E_TYPE'])
                          ->setCellValue('F'.$num, $v['TALLY_DATE'])
						  ->setCellValue('G'.$num, $v['PIECES'])    
                          ->setCellValue('H'.$num, $v['WEIGHT'])
                          ->setCellValue('I'.$num, $v['M_PIECES'])
						  ->setCellValue('J'.$num, $v['M_WEIGHT'])    
                          ->setCellValue('K'.$num, $v['STOCKPOSITION'])
                          ->setCellValue('L'.$num, $v['CUSTOMER_CODE'])
						  ->setCellValue('M'.$num, $v['GOODSNO'])    
                          ->setCellValue('N'.$num, $v['E_BUSINESS'])
                          ->setCellValue('O'.$num, $v['TRANSFERCOMPANYCIQ'])
						  ->setCellValue('P'.$num, '批次理货');
            }			
			 $PHPExcel->getActiveSheet()->setTitle('批次理货信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			 $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(35);
			 $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:P1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	

 public function tally_batch_add()
    {
         $this->load->view('CBS/tally_batch_add', '');
    }
    public function tally_batch_add_ajax_data(){
        $mbl       = $this->input->get_post("mbl");
		 if(!empty($mbl)) {
            $condition['mbl'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总运单号不能为空', NULL);
            exit();
        }
        $batchno       = $this->input->get_post("batchno");
		 if(!empty($batchno)) {
            $condition['batchno'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        $hbl       = $this->input->get_post("hbl");
		 if(!empty($hbl)) {
            $condition['hbl'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
        $tally_date   = $this->input->get_post("tally_date");
        $i_e_type = $this->input->get_post("i_e_type");
		 if(!empty($i_e_type)) {
            $condition['i_e_type'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        $goods_name    = $this->input->get_post("goods_name");
        $pieces       = $this->input->get_post("pieces");
		 if(!empty($pieces)) {
            $condition['pieces'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $weight   = $this->input->get_post("weight");
		 if(!empty($weight)) {
            $condition['weight'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量（KG）不能为空', NULL);
            exit();
        }
        $m_pieces = $this->input->get_post("m_pieces");
		 if(!empty($m_pieces)) {
            $condition['m_pieces'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        $m_weight    = $this->input->get_post("m_weight");
		 if(!empty($m_weight)) {
            $condition['m_weight'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        $stockposition       = $this->input->get_post("stockposition");
		 if(!empty($stockposition)) {
            $condition['stockposition'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        $customer_name   = $this->input->get_post("customer_name");
		 if(!empty($customer_name)) {
            $condition['customer_name'] = $customer_name;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $goodsno = $this->input->get_post("goodsno");
		 if(!empty($goodsno)) {
            $condition['goodsno'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $transfercompanyciq    = $this->input->get_post("transfercompanyciq");
		 if(!empty($transfercompanyciq)) {
            $condition['transfercompanyciq'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CTQ不能为空', NULL);
            exit();
        }
        $e_business      = $this->input->get_post("e_business");
		 if(!empty($e_business)) {
            $condition['e_business'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        $add_who   = $this->input->get_post("add_who");
        $add_date = $this->input->get_post("add_date");
        //查询检索号是否存在（假设检索号不能重复）
        $condition = array();
        $condition['MBL'] = $mbl;
        $info = $this->tally_model->get_mbl($condition);
        if(!empty($info)){
            //showmessage("检索号{$index_no}已经存在","sample2/add",3,0);
            exit();
        }

        //插入数据
        $data = array(
            'GUID'          =>guid_create(),
            'MBL'      =>$mbl,
            'BATCHNO'=>$batchno,
            'HBL'=>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
             'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_name,
            'GOODSNO'      =>$goodsno,
           'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'      =>$e_business,
            'BATCHTYPE'=>'0',
            'ADD_WHO'  =>$add_who,
            'ADD_DATE'=>$add_date
        );
        $this->tally_model->tally_batch_insert($data);
        echo result_to_towf_new('1', 1, 'success', null);
		

    }
    //编辑理货信息
    public function tally_batch_edit()
    {

        $GUID = $this->input->get_post("GUID");

        $condition = array();
        $condition['GUID'] = $GUID;
		//PC::debug($condition);
        $list['info'] = $this->tally_model->get_list1($condition);
        $this->load->view('CBS/tally_batch_edit', $list);
    }
    public function tally_batch_edit_ajax_data(){
        $mbl       = $this->input->get_post("mbl");
       		 if(!empty($mbl)) {
            $condition['mbl'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总运单号不能为空', NULL);
            exit();
        }
        $batchno       = $this->input->get_post("batchno");
		 if(!empty($batchno)) {
            $condition['batchno'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        $hbl       = $this->input->get_post("hbl");
		 if(!empty($hbl)) {
            $condition['hbl'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
        $tally_date   = $this->input->get_post("tally_date");
        $i_e_type = $this->input->get_post("i_e_type");
		 if(!empty($i_e_type)) {
            $condition['i_e_type'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        $goods_name    = $this->input->get_post("goods_name");
        $pieces       = $this->input->get_post("pieces");
		 if(!empty($pieces)) {
            $condition['pieces'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $weight   = $this->input->get_post("weight");
		 if(!empty($weight)) {
            $condition['weight'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量（KG）不能为空', NULL);
            exit();
        }
        $m_pieces = $this->input->get_post("m_pieces");
		 if(!empty($m_pieces)) {
            $condition['m_pieces'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        $m_weight    = $this->input->get_post("m_weight");
		 if(!empty($m_weight)) {
            $condition['m_weight'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        $stockposition       = $this->input->get_post("stockposition");
		 if(!empty($stockposition)) {
            $condition['stockposition'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        $customer_name   = $this->input->get_post("customer_name");
		 if(!empty($customer_name)) {
            $condition['customer_name'] = $customer_name;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $goodsno = $this->input->get_post("goodsno");
		 if(!empty($goodsno)) {
            $condition['goodsno'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $transfercompanyciq    = $this->input->get_post("transfercompanyciq");
		 if(!empty($transfercompanyciq)) {
            $condition['transfercompanyciq'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CTQ不能为空', NULL);
            exit();
        }
        $e_business      = $this->input->get_post("e_business");
		 if(!empty($e_business)) {
            $condition['e_business'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        $add_who   = $this->input->get_post("add_who");
        $add_date = $this->input->get_post("add_date");
        //编辑数据
        $guid = $this->input->get_post("guid");
        $condition = array();
        $condition['GUID'] = $guid;
        $data = array(
            'GUID'=>$guid,
            'MBL'      =>$mbl,
            'BATCHNO'      =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAMe'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_name,
            'GOODSNO'      =>$goodsno,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'      =>$e_business,
            'ADD_WHO'  =>$add_who,
            'ADD_DATE'=>$add_date
        );
        $this->tally_model->tally_batch_update($data,$condition);
        echo result_to_towf_new('1', 1, 'success', null);
    }

    //删除理货信息
    public function tally_batch_del_ajax_data()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->tally_batch_del($data);
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }
    }
    /**
    *
    *拆包理货
    *
    * */
    public function tally_unpacking()
    {
        $this->load->view('CBS/tally_unpacking', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function tally_unpacking_ajax_data(){
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
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取客户
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['CUSTOMER_CODE'] = $customer_name;
        }
        //进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(in_array($i_e_type,array('I','E',true))){
            $condition['I_E_TYPE'] = $i_e_type;
        }
        //获取起始日期
        $tally_sdate = $this->input->get_post("tally_sdate");
        if(!empty($tally_sdate)){
            $condition['TALLY_DATE >'] = $tally_sdate;
        }
        //获取结束日期
        $tally_edate = $this->input->get_post("tally_edate");
        if(!empty($tally_edate)){
            $condition['TALLY_DATE <'] = $tally_edate;
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)){
            $condition['E_BUSINESS'] = $e_business;
        }
        $condition['BATCHTYPE'] ='1';
        $total = $this->tally_model->count_num_unpacking($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_unpacking($condition,$limit,$offset);
		$list1 = $this->tally_model->location();
		$list2 = $this->tally_model->customer();
        foreach($list as $k=>$v){
            $list[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I' )?"进口":"出口";
          
        }
		 foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$list[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
			   foreach($list2 as $k2=>$v2){
			   foreach($list as $k=>$v){
               if($list[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$list[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
		//拆包理货导出
	
	 public function tally_unpacking_ajax_data_export(){       
       
	   $condition = array();
        //获取总运单号
        $mbl = $this->input->get_post("mbl");
		//PC::debug($mbl);
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取客户
        $customer_name = $this->input->get_post("customer_name");
        if(!empty($customer_name)){
            $condition['CUSTOMER_CODE'] = $customer_name;
        }
        //进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(in_array($i_e_type,array('I','E',true))){
            $condition['I_E_TYPE'] = $i_e_type;
        }
        //获取起始日期
        $tally_sdate = $this->input->get_post("tally_sdate");
        if(!empty($tally_sdate)){
            $condition['TALLY_DATE >'] = $tally_sdate;
        }
        //获取结束日期
        $tally_edate = $this->input->get_post("tally_edate");
        if(!empty($tally_edate)){
            $condition['TALLY_DATE <'] = $tally_edate;
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)){
            $condition['E_BUSINESS'] = $e_business;
        }
        $condition['BATCHTYPE'] ='1';
        
        //PC::debug($condition);
        $total = $this->tally_model->export_data($condition);
		$list1 = $this->tally_model->location();
		$list2 = $this->tally_model->customer();
		//PC::debug($total);
        foreach($total as $k=>$v){
            $total[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I' )?"进口":"出口";       
        }
		foreach($list1 as $k1=>$v1){
			   foreach($total as $k=>$v){
               if($total[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$total[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
			   foreach($list2 as $k2=>$v2){
			   foreach($total as $k=>$v){
               if($total[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$total[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
         $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次号')
            ->setCellValue('C1','分运单号')
            ->setCellValue('D1','品名')
			->setCellValue('E1','进出口标识')
            ->setCellValue('F1','货物抵运日期')
			->setCellValue('G1','件数')
            ->setCellValue('H1','重量KG')
            ->setCellValue('I1','理货件数')
            ->setCellValue('J1','理货重量')
			->setCellValue('K1','库位')
            ->setCellValue('L1','客户')
			->setCellValue('M1','物流企业海关备案编号')
            ->setCellValue('N1','电商企业名称')
            ->setCellValue('O1','物流企业检验检疫备案编号CTQ')
            ->setCellValue('P1','理货状态');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, " ".$v['MBL'])    
                          ->setCellValue('B'.$num, $v['BATCHNO'])
                          ->setCellValue('C'.$num, " ".$v['HBL'])
						  ->setCellValue('D'.$num, $v['GOODS_NAME'])    
                          ->setCellValue('E'.$num, $v['I_E_TYPE'])
                          ->setCellValue('F'.$num, $v['TALLY_DATE'])
						  ->setCellValue('G'.$num, $v['PIECES'])    
                          ->setCellValue('H'.$num, $v['WEIGHT'])
                          ->setCellValue('I'.$num, $v['M_PIECES'])
						  ->setCellValue('J'.$num, $v['M_WEIGHT'])    
                          ->setCellValue('K'.$num, $v['STOCKPOSITION'])
                          ->setCellValue('L'.$num, $v['CUSTOMER_CODE'])
						  ->setCellValue('M'.$num, $v['GOODSNO'])    
                          ->setCellValue('N'.$num, $v['E_BUSINESS'])
                          ->setCellValue('O'.$num, $v['TRANSFERCOMPANYCIQ'])
						  ->setCellValue('P'.$num, '拆包理货');
            }			
			 $PHPExcel->getActiveSheet()->setTitle('拆包理货信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			 $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(35);
			 $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:P1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	
	
/*	
	//拆包理货导出
	
	 public function tally_unpacking_batch_export(){       
       
	   $condition = array();
        //获取总运单号
        $mbl = $this->input->get_post("mbl");
		//PC::debug($mbl);
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取客户
       $batchno = $this->input->get_post("batchno");
		//PC::debug($mbl);
        if(!empty($batchno)){
            $condition['BATCHNO'] = $batchno;
        }
        
        //PC::debug($condition);
        $total = $this->tally_model->export_batch_data($condition);
		//PC::debug($total);
        foreach($total as $k=>$v){
            $total[$k]['BATCHTYPE'] = ($v['BATCHTYPE'] == '0' )?"批次理货":"拆包理货";       
        }
		 foreach($total as $k=>$v){
           if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '0' )  )   
			{$total[$k]['BATCHCONTROL']='不布控';}
			else if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '1' ) )
            {$total[$k]['BATCHCONTROL']='布控';}
	        else if($total[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '2' ) )
            { $total[$k]['BATCHCONTROL']='放行';}		   
        }
				
		 foreach($total as $k=>$v){
            $total[$k]['TALLY_STATUS'] = ($v['TALLY_STATUS'] == 'Y' )?"已理货":"未理货";       
        }
         $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','总运单号')
            ->setCellValue('B1','批次号')
            ->setCellValue('C1','理货类型')
            ->setCellValue('D1','布控状态')
			->setCellValue('E1','理货状态');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, " ".$v['MBL'])    
                          ->setCellValue('B'.$num, $v['BATCHNO'])
                          ->setCellValue('C'.$num, $v['BATCHTYPE'])
						  ->setCellValue('D'.$num, $v['BATCHCONTROL'])    
                          ->setCellValue('E'.$num, $v['TALLY_STATUS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('拆包理货查询信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);				 
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:E1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	
*/
    public function tally_unpacking_add()
    {
        $this->load->view('CBS/tally_unpacking_add', '');
    }
    public function tally_unpacking_add_ajax_data(){
        $mbl       = $this->input->get_post("mbl");
        if(!empty($mbl)) {
            $condition['mbl'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总运单号不能为空', NULL);
            exit();
        }
        $batchno       = $this->input->get_post("batchno");
		 if(!empty($batchno)) {
            $condition['batchno'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        $hbl       = $this->input->get_post("hbl");
		 if(!empty($hbl)) {
            $condition['hbl'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
        $tally_date   = $this->input->get_post("tally_date");
        $i_e_type = $this->input->get_post("i_e_type");
		 if(!empty($i_e_type)) {
            $condition['i_e_type'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        $goods_name    = $this->input->get_post("goods_name");
        $pieces       = $this->input->get_post("pieces");
		 if(!empty($pieces)) {
            $condition['pieces'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $weight   = $this->input->get_post("weight");
		 if(!empty($weight)) {
            $condition['weight'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量（KG）不能为空', NULL);
            exit();
        }
        $m_pieces = $this->input->get_post("m_pieces");
		 if(!empty($m_pieces)) {
            $condition['m_pieces'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        $m_weight    = $this->input->get_post("m_weight");
		 if(!empty($m_weight)) {
            $condition['m_weight'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        $stockposition       = $this->input->get_post("stockposition");
		 if(!empty($stockposition)) {
            $condition['stockposition'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        $customer_name   = $this->input->get_post("customer_name");
		 if(!empty($customer_name)) {
            $condition['customer_name'] = $customer_name;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $goodsno = $this->input->get_post("goodsno");
		 if(!empty($goodsno)) {
            $condition['goodsno'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $transfercompanyciq    = $this->input->get_post("transfercompanyciq");
		 if(!empty($transfercompanyciq)) {
            $condition['transfercompanyciq'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CTQ不能为空', NULL);
            exit();
        }
        $e_business      = $this->input->get_post("e_business");
		 if(!empty($e_business)) {
            $condition['e_business'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        $add_who   = $this->input->get_post("add_who");
        $add_date = $this->input->get_post("add_date");
        //查询检索号是否存在（假设检索号不能重复）
        $condition = array();
        $condition['MBL'] = $mbl;
        $info = $this->tally_model->get_mbl_unpacking($condition);
        if(!empty($info)){
            //showmessage("检索号{$index_no}已经存在","sample2/add",3,0);
            exit();
        }

        //插入数据
        $data = array(
            'GUID'          =>guid_create(),
            'MBL'      =>$mbl,
            'BATCHNO'=>$batchno,
            'HBL'=>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_name,
            'GOODSNO'      =>$goodsno,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'      =>$e_business,
            'BATCHTYPE'=>'1',
            'ADD_WHO'  =>$add_who,
            'ADD_DATE'=>$add_date
        );
        $this->tally_model->tally_unpacking_insert($data);
        echo result_to_towf_new('1', 1, 'success', NULL) ;

    }
    //编辑理货信息
    public function tally_unpacking_edit()
    {

        $GUID = $this->input->get_post("GUID");

        $condition = array();
        $condition['GUID'] = $GUID;
        $list['info'] = $this->tally_model->get_list1_unpacking($condition);
        $this->load->view('CBS/tally_unpacking_edit', $list);
    }
    public function tally_unpacking_edit_ajax_data(){
        $mbl       = $this->input->get_post("mbl");
         if(!empty($mbl)) {
            $condition['mbl'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总运单号不能为空', NULL);
            exit();
        }
        $batchno       = $this->input->get_post("batchno");
		 if(!empty($batchno)) {
            $condition['batchno'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        $hbl       = $this->input->get_post("hbl");
		 if(!empty($hbl)) {
            $condition['hbl'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分运单号不能为空', NULL);
            exit();
        }
        $tally_date   = $this->input->get_post("tally_date");
        $i_e_type = $this->input->get_post("i_e_type");
		 if(!empty($i_e_type)) {
            $condition['i_e_type'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        $goods_name    = $this->input->get_post("goods_name");
        $pieces       = $this->input->get_post("pieces");
		 if(!empty($pieces)) {
            $condition['pieces'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        $weight   = $this->input->get_post("weight");
		 if(!empty($weight)) {
            $condition['weight'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量（KG）不能为空', NULL);
            exit();
        }
        $m_pieces = $this->input->get_post("m_pieces");
		 if(!empty($m_pieces)) {
            $condition['m_pieces'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        $m_weight    = $this->input->get_post("m_weight");
		 if(!empty($m_weight)) {
            $condition['m_weight'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        $stockposition       = $this->input->get_post("stockposition");
		 if(!empty($stockposition)) {
            $condition['stockposition'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        $customer_name   = $this->input->get_post("customer_name");
		 if(!empty($customer_name)) {
            $condition['customer_name'] = $customer_name;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        $goodsno = $this->input->get_post("goodsno");
		 if(!empty($goodsno)) {
            $condition['goodsno'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        $transfercompanyciq    = $this->input->get_post("transfercompanyciq");
		 if(!empty($transfercompanyciq)) {
            $condition['transfercompanyciq'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CTQ不能为空', NULL);
            exit();
        }
        $e_business      = $this->input->get_post("e_business");
		 if(!empty($e_business)) {
            $condition['e_business'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        $add_who   = $this->input->get_post("add_who");
        $add_date = $this->input->get_post("add_date");
        //编辑数据
        $guid = $this->input->get_post("guid");
        $condition = array();
        $condition['GUID'] = $guid;
        $data = array(
            'GUID'=>$guid,
            'MBL'      =>$mbl,
            'BATCHNO'      =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAMe'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_name,
            'GOODSNO'      =>$goodsno,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'      =>$e_business,
            'ADD_WHO'  =>$add_who,
            'ADD_DATE'=>$add_date
        );
        $this->tally_model->tally_unpacking_update($data,$condition);
        echo result_to_towf_new('1', 1, 'success', NULL) ;
    }

    //删除理货信息
    public function tally_unpacking_del_ajax_data()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->tally_unpacking_del($data);
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }
    }
    /**
    *
    *拆包理货查询
    *
    * */
    public function tally_unpacking_search()
    {
        $this->load->view('CBS/tally_unpacking_search', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function tally_unpacking_search_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();
        //获取总单号
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)){
            $condition['MBL'] = $mbl;
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)){
            $condition['BATCHNO'] = $batchno;
        }
        $total = $this->tally_model->count_num_unpacking_search($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_unpacking_search($condition,$limit,$offset);
        foreach($list as $k=>$v) {
            $list[$k]['BATCHTYPE'] = ($v['BATCHTYPE'] == '0') ? "批次理货" : '<font color="red">拆包理货</font>';;
        }
        foreach($list as $k=>$v) {
            $list[$k]['BATCHCONTROL'] = ($v['BATCHCONTROL'] == '0') ? "未布控" : '<font color="red">布控</font>';;
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
    /**
    *
    *预报理货报告
    *
    * */
    public function report_pre_send(){
        $totaltransferno = $this->input->get_post("totaltransferno");
       $condition=array('totalno'=>$totaltransferno);

        header("Content-type: text/html; charset=utf-8");
        ini_set('soap.wsdl_cache_enabled', "0"); //关闭wsdl缓存

        $soap = new SoapClient('http://192.168.17.99:8077/pre_yd.asmx?wsdl');
//获取配置扫描类型
        $return = $soap->CreateXmlFile($condition);
        echo result_to_towf_new('1', 1, $return, null) ;
    }
    public function report_pre()
    {
        $this->load->view('CBS/report_pre', '');
    }
    public function report_pre_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 10;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();

        //获取总运单号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
        $total = $this->tally_model->count_num_pre($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_pre($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":'<font color="red">出口</font>';
            //$list[$k]['PRE_RECEIPT_STATUS'] = ($v['PRE_RECEIPT_STATUS'] == '0100A' )?"入库成功":'<font color="red">入库失败</font>';

            if($v['PRE_RECEIPT_STATUS'] == '0100A') {
                $list[$k]['PRE_RECEIPT_STATUS'] = "入库成功";
            }elseif ($v['PRE_RECEIPT_STATUS'] == '0000A'){
                $list[$k]['PRE_RECEIPT_STATUS'] = "入库失败";
            }
        }
		        
			 foreach($list as $k=>$v){
			if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$list[$k]['TRANSFERTYPE']='非保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$list[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$list[$k]['TRANSFERTYPE']='水路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$list[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$list[$k]['TRANSFERTYPE']='公路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$list[$k]['TRANSFERTYPE']='航空运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$list[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$list[$k]['TRANSFERTYPE']='保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$list[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$list[$k]['TRANSFERTYPE']='其它运输';}
		    else
            {$list[$k]['TRANSFERTYPE']='null';}
        }

        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
	
	 public function tally_report_pre_export(){
       
        $condition = array();

        //获取总运单号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
        $total = $this->tally_model->export_pre_data($condition);
      
        foreach($total as $k=>$v){
            $total[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":"出口";           
        }
		
         foreach($total as $k=>$v){
          if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$total[$k]['TRANSFERTYPE']='非保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$total[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$total[$k]['TRANSFERTYPE']='水路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$total[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$total[$k]['TRANSFERTYPE']='公路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$total[$k]['TRANSFERTYPE']='航空运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$total[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$total[$k]['TRANSFERTYPE']='保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$total[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$total[$k]['TRANSFERTYPE']='其它运输';}
		  
		}

        $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','航次航班号')
            ->setCellValue('B1','运输方式代码')
            ->setCellValue('C1','总提运单号')
            ->setCellValue('D1','托运货物件数')
			->setCellValue('E1','货物总毛重')
            ->setCellValue('F1','到达卸货地时间')
			->setCellValue('G1','进出口标记')
            ->setCellValue('H1','创建日期')
			->setCellValue('I1','回执信息');			 
		   foreach($total as $k =>$v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['FLIGHTNO'])    
                          ->setCellValue('B'.$num, $v['TRANSFERTYPE'])
                          ->setCellValue('C'.$num, " ".$v['TOTALTRANSFERNO'])
						  ->setCellValue('D'.$num, $v['GOODSAMMOUNT'])    
                          ->setCellValue('E'.$num, $v['TOTALWEIGTH'])
                          ->setCellValue('F'.$num, $v['ARRIVETIME'])
						  ->setCellValue('G'.$num, $v['IETYPE'])    
                          ->setCellValue('H'.$num, $v['ARRIVETIME'])
                          ->setCellValue('I'.$num, $v['PRE_RECEIPT_STATUS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('预报理货报告信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	 
			 $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:I1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
			
    }
	
	

    public function report_pre_add()
    {
        $list['info'] = $this->tally_model->get_list_pre3();
        $this->load->view('CBS/report_pre_add',$list);
    }
    public function report_pre_ajax_data1(){
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>guid_create(),
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_insert_pre($data);
            //返回插入成功
            echo result_to_towf_new('1', 1, 'success', NULL) ;
            exit();
        }
    }
    public function report_pre_edit()
    {
        //获取总运单号
        $guid = $this->input->get_post("guid");
        if(!empty($guid)){
            $condition['GUID']=$guid;
        }
        $list['info'] = $this->tally_model->get_list_pre4($condition);
        $this->load->view('CBS/report_pre_edit',$list);
    }
    public function report_pre_edit_ajax_data1(){
        //获取主键
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition1['GUID'] = $guid;
        }else {
            echo result_to_towf_new('1', 0, '主键不能为空', NULL);
            exit();
        }
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>$guid,
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_update_pre1($data,$condition1);
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }else{
            echo result_to_towf_new('1', 0, '更新失败', NULL) ;
        }
    }
    public function report_pre_del(){
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $this->tally_model->report_pre_del($guid);
            echo result_to_towf_new('1', 1, '删除成功', NULL);
        }
    }
    public function report_pre_add_no()
    {
        $list['info'] = $this->tally_model->get_list_pre3();
        $this->load->view('CBS/report_pre_add_no',$list);
    }
    public function report_pre_add_no_ajax_data(){
        //获取总单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['MBL'] = $totaltransferno;
        }else{
            echo result_to_towf_new('1', 0, '总单号不能为空', null);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition1['BATCHNO'] = $batchno;
        }else{
            echo result_to_towf_new('1', 0, '批次号不能为空', null);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition1['HBL'] = $hbl;
        }else{
            echo result_to_towf_new('1', 0, '分单号不能为空', null);
            exit();
        }
        //获取主要货物名称
        $goods_name_import= $this->input->get_post("goods_name_import");
        if(!empty($goods_name_import)) {
            $condition1['GOODS_NAME_IMPORT'] = $goods_name_import;
        }else{
            echo result_to_towf_new('1', 0, '主要货物名称不能为空', null);
            exit();
        }
        //获取件数
        $num = $this->input->get_post("num");
        if(!empty($num)) {
            $condition1['NUM'] = $num;
        }else{
            echo result_to_towf_new('1', 0, '件数不能为空', null);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition1['WEIGHT'] = $weight;
        }else{
            echo result_to_towf_new('1', 0, '重量不能为空', null);
            exit();
        }
        //获取价值
        $price = $this->input->get_post("price");
        //获取币值
        $currency = $this->input->get_post("currency");
        //获取申报时间
        $app_date = $this->input->get_post("app_date");
        if(!empty($app_date)) {
            $condition1['APP_DATE'] = $app_date;
        }else{
            echo result_to_towf_new('1', 0, '申报时间不能为空', null);
            exit();
        }
        //获取收件人
        $recv_user= $this->input->get_post("recv_user");
        //获取发件人
        $send_user        = $this->input->get_post("send_user");
        //获取监管场所海关备案编码
        $appliedcompany       = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition1['APPLIEDCOMPANY'] = $appliedcompany;
        }else{
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', null);
            exit();
        }
        //获取物流企业检验检疫备案编号CIQ
        $transfercompanyciq   = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition1['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else{
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', null);
            exit();
        }
        //获取客户
        $customer_code    = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition1['CUSTOMER_CODE'] = $customer_code;
        }else{
            echo result_to_towf_new('1', 0, '客户不能为空', null);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno1    = $this->input->get_post("goodsno1");
        if(!empty($goodsno1)) {
            $condition1['GOODSNO'] = $goodsno1;
        }else{
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', null);
            exit();
        }
        //获取电商企业名称
        $e_business  = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition1['E_BUSINESS'] = $e_business;
        }else{
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', null);
            exit();
        }
        //插入预报分单数据
        $data = array(
            'guid'          =>guid_create(),
            'MBL'      =>$totaltransferno,
            'BATCHNO'  =>$batchno,
            'HBL'   =>$hbl,
            'GOODS_NAME_IMPORT'=>$goods_name_import,
            'NUM'        =>$num,
            'WEIGHT'      =>$weight,
            'PRICE'  =>$price,
            'CURRENCY'   =>$currency,
            'APP_DATE'=>$app_date,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time()),
            'RECV_USER'        =>$recv_user,
            'SEND_USER'      =>$send_user,
            'APPLIEDCOMPANY'  =>$appliedcompany,
            'TRANSFERCOMPANYCIQ'   =>$transfercompanyciq,
            'CUSTOMER_CODE'=>$customer_code,
            'GOODSNO'        =>$goodsno1,
            'E_BUSINESS'      =>$e_business,
        );
        if($condition1) {
            $this->tally_model->report_insert_pre1($data);
           echo result_to_towf_new('1', 1, 'success', null);
        }
        //showmessage("添加库位成功","sample2/index",3,1);
        //exit();
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    public function report_pre_edit_no()
    {
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition = array();
            $condition['GUID'] = $guid;
        }
       $list['info'] = $this->tally_model->get_list_pre2($condition);
        $this->load->view('CBS/report_pre_edit_no',$list);
    }
    public function report_pre_edit_no_ajax_data(){
        //获取guid
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition = array();
            $condition['GUID'] = $guid;
        }else{
            echo result_to_towf_new('1', 0, '主键不能为空', null);
            exit();
        }
        //获取总单号
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)) {
            $condition1['MBL'] = $mbl;
        }else{
            echo result_to_towf_new('1', 0, '总单号不能为空', null);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition1['BATCHNO'] = $batchno;
        }else{
            echo result_to_towf_new('1', 0, '批次号不能为空', null);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition1['HBL'] = $hbl;
        }else{
            echo result_to_towf_new('1', 0, '分单号不能为空', null);
            exit();
        }
        //获取主要货物名称
        $goods_name_import= $this->input->get_post("goods_name_import");
        if(!empty($goods_name_import)) {
            $condition1['GOODS_NAME_IMPORT'] = $goods_name_import;
        }else{
            echo result_to_towf_new('1', 0, '主要货物名称不能为空', null);
            exit();
        }
        //获取件数
        $num = $this->input->get_post("num");
        if(!empty($num)) {
            $condition1['NUM'] = $num;
        }else{
            echo result_to_towf_new('1', 0, '件数不能为空', null);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition1['WEIGHT'] = $weight;
        }else{
            echo result_to_towf_new('1', 0, '重量不能为空', null);
            exit();
        }
        //获取价值
        $price = $this->input->get_post("price");
        //获取币值
        $currency = $this->input->get_post("currency");
        //获取申报时间
        $app_date = $this->input->get_post("app_date");
        if(!empty($app_date)) {
            $condition1['APP_DATE'] = $app_date;
        }else{
            echo result_to_towf_new('1', 0, '申报时间不能为空', null);
            exit();
        }
        //获取收件人
        $recv_user= $this->input->get_post("recv_user");
        //获取发件人
        $send_user        = $this->input->get_post("send_user");
        //获取监管场所海关备案编码
        $appliedcompany       = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition1['APPLIEDCOMPANY'] = $appliedcompany;
        }else{
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', null);
            exit();
        }
        //获取物流企业检验检疫备案编号CIQ
        $transfercompanyciq   = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition1['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else{
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', null);
            exit();
        }
        //获取客户
        $customer_code    = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition1['CUSTOMER_CODE'] = $customer_code;
        }else{
            echo result_to_towf_new('1', 0, '客户不能为空', null);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno1    = $this->input->get_post("goodsno1");
        if(!empty($goodsno1)) {
            $condition1['GOODSNO'] = $goodsno1;
        }else{
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', null);
            exit();
        }
        //获取电商企业名称
        $e_business  = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition1['E_BUSINESS'] = $e_business;
        }else{
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', null);
            exit();
        }
        //更新预报数据
        $data = array(
            'guid'          =>$guid,
           'MBL'      =>$mbl,
            'BATCHNO'  =>$batchno,
            'HBL'   =>$hbl,
            'GOODS_NAME_IMPORT'=>$goods_name_import,
            'NUM'        =>$num,
            'WEIGHT'      =>$weight,
            'PRICE'  =>$price,
            'CURRENCY'   =>$currency,
            'APP_DATE'=>$app_date,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time()),
            'RECV_USER'        =>$recv_user,
            'SEND_USER'      =>$send_user,
            'APPLIEDCOMPANY'  =>$appliedcompany,
            'TRANSFERCOMPANYCIQ'   =>$transfercompanyciq,
            'CUSTOMER_CODE'=>$customer_code,
            'GOODSNO'        =>$goodsno1,
            'E_BUSINESS'      =>$e_business,
        );
        if(!empty($condition)) {
            $this->tally_model->report_update_pre($data, $condition);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function report_pre_del_ajax_data()
    {

        $data = $this->input->get_post("guid");
        if (!empty($data)) {
            $this->tally_model->report_del_pre($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }else{
            echo result_to_towf_new('1', 0, '删除失败', null);
        }
    }
    public function report_pre_search_data(){
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
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['MBL'] = $totaltransferno;

        }
        //获取客户编号
        $batchno = $this->input->get_post("batchno");
        //获取客户名称
        $hbl = $this->input->get_post("hbl");
        //获取客户简称
        $goods_name_import= $this->input->get_post("goods_name_import");
        //获取客户类型
        $num = $this->input->get_post("num");
        //获取税务登记号
        $weight = $this->input->get_post("weight");
        //企业海关备案编号
        $price = $this->input->get_post("price");
        //获取税务登记号
        $currency = $this->input->get_post("currency");
        //企业海关备案编号
        $app_date = $this->input->get_post("app_date");
        $recv_user= $this->input->get_post("recv_user");
        $send_user        = $this->input->get_post("send_user");
        $appliedcompany       = $this->input->get_post("appliedcompany");
        $transfercompanyciq   = $this->input->get_post("transfercompanyciq");
        $customer_code    = $this->input->get_post("customer_code");
        $goodsno      = $this->input->get_post("goodsno");
        $e_business  = $this->input->get_post("e_business");
        $total = $this->tally_model->count_num_pre1($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_pre1($condition,$limit,$offset);
		$list2 = $this->tally_model->customer();
		 foreach($list2 as $k2=>$v2){
			   foreach($list as $k=>$v){
               if($list[$k]['CUSTOMER_CODE'] == $list2[$k2]['CUSTOMER_CODE'])   
			    {
				$list[$k]['CUSTOMER_CODE'] = $list2[$k2]['CUSTOMER_NAME'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
        //showmessage("添加库位成功","sample2/index",3,1);
        //exit();
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    /**
    *
    *总单理货报告
    *
    * */
    public function tally_report_master_send(){
        $totaltransferno = $this->input->get_post("totaltransferno");
        $condition=array('totalno'=>$totaltransferno);

        header("Content-type: text/html; charset=utf-8");
        ini_set('soap.wsdl_cache_enabled', "0"); //关闭wsdl缓存

        $soap = new SoapClient('http://192.168.17.99:8077/tally.asmx?wsdl');
//获取配置扫描类型
        $return = $soap->CreatelihuoXmlFile($condition);

        echo result_to_towf_new('1', 1, $return, null) ;
    }
    public function tally_report_master()
    {
        $this->load->view('CBS/tally_report_master', '');
    }
    public function tally_report_master_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 10;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();

        //获取总运单号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
        $total = $this->tally_model->count_num_master($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_master($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":'<font color="red">出口</font>';           
        }
		 foreach($list as $k=>$v){
			if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$list[$k]['TRANSFERTYPE']='非保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$list[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$list[$k]['TRANSFERTYPE']='水路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$list[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$list[$k]['TRANSFERTYPE']='公路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$list[$k]['TRANSFERTYPE']='航空运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$list[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$list[$k]['TRANSFERTYPE']='保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$list[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$list[$k]['TRANSFERTYPE']='其它运输';}
		    else
            {$list[$k]['TRANSFERTYPE']='null';}
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
	
    //导出数据
	 public function tally_report_master_export(){
       //PC::debug("123");
        $condition = array();
        //获取总运单号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
		//PC::debug($flightno);
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
        $total = $this->tally_model->export_master_data($condition);  
		//PC::debug($total);
        foreach($total as $k=>$v){
            $total[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":"出口";           
        }
		
         foreach($total as $k=>$v){
          if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$total[$k]['TRANSFERTYPE']='非保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$total[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$total[$k]['TRANSFERTYPE']='水路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$total[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$total[$k]['TRANSFERTYPE']='公路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$total[$k]['TRANSFERTYPE']='航空运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$total[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$total[$k]['TRANSFERTYPE']='保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$total[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$total[$k]['TRANSFERTYPE']='其它运输';}
		   
		}
		
         $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','航次航班号')
            ->setCellValue('B1','运输方式代码')
            ->setCellValue('C1','总提运单号')
            ->setCellValue('D1','托运货物件数')
			->setCellValue('E1','货物总毛重')
            ->setCellValue('F1','到达卸货地时间')
			->setCellValue('G1','进出口标记')
            ->setCellValue('H1','创建日期')
			->setCellValue('I1','回执信息');			 
		   foreach($total as $k =>$v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['FLIGHTNO'])    
                          ->setCellValue('B'.$num, $v['TRANSFERTYPE'])
                          ->setCellValue('C'.$num, " ".$v['TOTALTRANSFERNO'])
						  ->setCellValue('D'.$num, $v['GOODSAMMOUNT'])    
                          ->setCellValue('E'.$num, $v['TOTALWEIGTH'])
                          ->setCellValue('F'.$num, $v['ARRIVETIME'])
						  ->setCellValue('G'.$num, $v['IETYPE'])    
                          ->setCellValue('H'.$num, $v['ARRIVETIME'])
                          ->setCellValue('I'.$num, $v['MASTER_RECEIPT_STATUS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('总单理货报告信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	 
			 $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:I1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
			//$this->load->view('CBS/tally_report_master');
    }
	
	
    public function tally_report_master_add()
    {
        $list['info'] = $this->tally_model->get_list_master3();
        $this->load->view('CBS/tally_report_master_add',$list);
    }
    public function tally_report_master_ajax_data1(){
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>guid_create(),
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_insert_master($data);
            //返回插入成功
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }
    }

    public function tally_report_master_edit()
    {
        //获取总运单号
        $guid = $this->input->get_post("guid");
        if(!empty($guid)){
            $condition['GUID']=$guid;
        }
        $list['info'] = $this->tally_model->get_list_master4($condition);
        $this->load->view('CBS/tally_report_master_edit',$list);
    }
    public function tally_report_master_edit_ajax_data1(){
        //获取主键
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition1['GUID'] = $guid;
        }else {
            echo result_to_towf_new('1', 0, '主键不能为空', NULL);
            exit();
        }
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>$guid,
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_update_master1($data,$condition1);
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }else{
            echo result_to_towf_new('1', 0, '更新失败', NULL) ;
        }
    }
    public function tally_report_master_del()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->report_del_master1($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function tally_report_master_add_no()
    {
        $list['info'] = $this->tally_model->get_list_master3();
        $this->load->view('CBS/tally_report_master_add_no',$list);
    }
    public function tally_report_master_add_no_ajax_data(){
        //获取总运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition['BATCHNO'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition['HBL'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分单号不能为空', NULL);
            exit();
        }
        //获取货物抵运日期
        $tally_date = $this->input->get_post("tally_date");
        //获取进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(!empty($i_e_type)) {
            $condition['I_E_TYPE'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取品名
        $goods_name = $this->input->get_post("goods_name");
        //获取件数
        $pieces = $this->input->get_post("pieces");
        if(!empty($pieces)) {
            $condition['PIECES'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition['WEIGHT'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量不能为空', NULL);
            exit();
        }
        //获取理货件数
        $m_pieces = $this->input->get_post("m_pieces");
        if(!empty($m_pieces)) {
            $condition['M_PIECES'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        //获取理货重量
        $m_weight = $this->input->get_post("m_weight");
        if(!empty($m_weight)) {
            $condition['M_WEIGHT'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取客户
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition['CUSTOMER_CODE'] = $customer_code;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno = $this->input->get_post("goodsno");
        if(!empty($goodsno)) {
            $condition['GOODSNO'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        //物流企业检验检疫备案编号CIQ
        $transfercompanyciq = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition['E_BUSINESS'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //获取维护人
        $add_who = $this->input->get_post("add_who");
        //$condition['DESCRIPTION2'] = $description2;
        //获取维护日期
        $add_date = $this->input->get_post("add_date");
        //插入总单理货报告数据
        $data = array(
            'GUID'          =>guid_create(),
            'MBL'          =>$totaltransferno,
            'BATCHNO'          =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_code,
            'GOODSNO'      =>$goodsno,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'  =>$e_business,
            'ADD_WHO'=>$add_who,
            'ADD_DATE'=>$add_date
        );
      if(!empty($condition)) {
       $this->tally_model->report_insert_master1($data);
       echo result_to_towf_new('1', 1, 'success', null);
}
    }
    public function tally_report_master_edit_no()
    {
        $guid = $this->input->get_post("guid");
        $condition = array();
        $condition['GUID'] = $guid;
        $list['info'] = $this->tally_model->get_list_master2($condition);
        $this->load->view('CBS/tally_report_master_edit_no',$list);
    }
    public function tally_report_master_edit_no_ajax_data(){
        //获取主键
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition1['GUID'] = $guid;
        }else {
            echo result_to_towf_new('1', 0, '主键不能为空', NULL);
            exit();
        }
        //获取总运单号
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)) {
            $condition['MBL'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition['BATCHNO'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition['HBL'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分单号不能为空', NULL);
            exit();
        }
        //获取货物抵运日期
        $tally_date = $this->input->get_post("tally_date");
        //获取进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(!empty($i_e_type)) {
            $condition['I_E_TYPE'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取品名
        $goods_name = $this->input->get_post("goods_name");
        //获取件数
        $pieces = $this->input->get_post("pieces");
        if(!empty($pieces)) {
            $condition['PIECES'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition['WEIGHT'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量不能为空', NULL);
            exit();
        }
        //获取理货件数
        $m_pieces = $this->input->get_post("m_pieces");
        if(!empty($m_pieces)) {
            $condition['M_PIECES'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        //获取理货重量
        $m_weight = $this->input->get_post("m_weight");
        if(!empty($m_weight)) {
            $condition['M_WEIGHT'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取客户
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition['CUSTOMER_CODE'] = $customer_code;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno1 = $this->input->get_post("goodsno1");
        if(!empty($goodsno1)) {
            $condition['GOODSNO'] = $goodsno1;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        //物流企业检验检疫备案编号CIQ
        $transfercompanyciq = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition['E_BUSINESS'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //获取维护人
        $add_who = $this->input->get_post("add_who");
        //$condition['DESCRIPTION2'] = $description2;
        //获取维护日期
        $add_date = $this->input->get_post("add_date");
        //插入总单理货报告数据
        $data = array(
            'GUID'          =>$guid,
            'MBL'          =>$mbl,
            'BATCHNO'          =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_code,
            'GOODSNO'      =>$goodsno1,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'  =>$e_business,
            'ADD_WHO'=>$add_who,
            'ADD_DATE'=>$add_date
        );

        if(!empty($condition)) {
            $this->tally_model->report_update_master($data, $condition1);
            echo result_to_towf_new('1', 1, 'success', null);
            exit();
        }
    }
    public function tally_report_master_del_ajax_data()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->report_del_master($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function tally_report_master_search_data(){

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
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['MBL'] = $totaltransferno;
        }
        //获取客户编号
        $batchno = $this->input->get_post("batchno");
        //获取客户名称
        $hbl = $this->input->get_post("hbl");
        //获取客户简称
        $goods_name_import= $this->input->get_post("goods_name_import");
        //获取客户类型
        $num = $this->input->get_post("num");
        //获取税务登记号
        $weight = $this->input->get_post("weight");
        //企业海关备案编号
        $price = $this->input->get_post("price");
        //获取税务登记号
        $currency = $this->input->get_post("currency");
        //企业海关备案编号
        $app_date = $this->input->get_post("app_date");
        $recv_user= $this->input->get_post("recv_user");
        $send_user        = $this->input->get_post("send_user");
        $appliedcompany       = $this->input->get_post("appliedcompany");
        $transfercompanyciq   = $this->input->get_post("transfercompanyciq");
        $customer_code    = $this->input->get_post("customer_code");
        $goodsno      = $this->input->get_post("goodsno");
        $e_business  = $this->input->get_post("e_business");
        $total = $this->tally_model->count_num_master1($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_master1($condition,$limit,$offset);
		$list1 = $this->tally_model->location();
        foreach($list as $k=>$v) {
            $list[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I') ? "进口" : '<font color="red">出口</font>';
        }
		foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$list[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
        //showmessage("添加库位成功","sample2/index",3,1);
        //exit();
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    /**
    *
    *确报理货报告
    *
    * */
    public function tally_report_ensure_send(){
        $totaltransferno = $this->input->get_post("totaltransferno");
        $condition=array('totalno'=>$totaltransferno);

        header("Content-type: text/html; charset=utf-8");
        ini_set('soap.wsdl_cache_enabled', "0"); //关闭wsdl缓存

        $soap = new SoapClient('http://192.168.17.99:8077/ensure_yd.asmx?wsdl');
//获取配置扫描类型
        $return = $soap->CreateensureXmlFile($condition);

        echo result_to_towf_new('1', 1, $return, null) ;
    }
	
	
			//确报理货报告导出
	
	 public function tally_report_ensure_export(){       
       
	   $condition = array();
        //获取总运单号
        $flightno = $this->input->get_post("flightno");
		//PC::debug($mbl);
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
       
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
       
        
        //PC::debug($condition);
        $total = $this->tally_model->export_ensure_data($condition);
		//PC::debug($total);
        foreach($total as $k=>$v){
            $total[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":"出口";
		}
		 foreach($total as $k=>$v){
          if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$total[$k]['TRANSFERTYPE']='非保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$total[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$total[$k]['TRANSFERTYPE']='水路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$total[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$total[$k]['TRANSFERTYPE']='公路运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$total[$k]['TRANSFERTYPE']='航空运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$total[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$total[$k]['TRANSFERTYPE']='保税区';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$total[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($total[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$total[$k]['TRANSFERTYPE']='其它运输';}
		   
		}
         $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','航次航班号')
            ->setCellValue('B1','运输方式代码')
            ->setCellValue('C1','总提运单号')
            ->setCellValue('D1','托运货物件数')
			->setCellValue('E1','货物总毛重')
            ->setCellValue('F1','到达卸货地时间')
			->setCellValue('G1','进出口标记')
            ->setCellValue('H1','创建日期')
			->setCellValue('I1','回执信息');			 
		   foreach($total as $k => $v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['FLIGHTNO'])    
                          ->setCellValue('B'.$num, $v['TRANSFERTYPE'])
                          ->setCellValue('C'.$num, " ".$v['TOTALTRANSFERNO'])
						  ->setCellValue('D'.$num, $v['GOODSAMMOUNT'])    
                          ->setCellValue('E'.$num, $v['TOTALWEIGTH'])
                          ->setCellValue('F'.$num, $v['ARRIVETIME'])
						  ->setCellValue('G'.$num, $v['IETYPE'])    
                          ->setCellValue('H'.$num, $v['ARRIVETIME'])
                          ->setCellValue('I'.$num, $v['ENSURE_RECEIPT_STATUS']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('确报理货报告信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			  $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
			 $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);	
			 $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	 
			 $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			 $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:I1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	
	
	
    public function tally_report_ensure()
    {
        $this->load->view('CBS/tally_report_ensure', '');
    }
    public function tally_report_ensure_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 10;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();

        //获取总运单号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)){
            $condition['FLIGHTNO'] = $flightno;
        }
        //获取客户
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)){
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }
        //获取起始日期
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)){
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }
        $total = $this->tally_model->count_num_ensure($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_ensure($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['IETYPE'] = ($v['IETYPE'] == 'I' )?"进口":'<font color="red">出口</font>';          
        }
		 foreach($list as $k=>$v){
			if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '0' )  )   
			{$list[$k]['TRANSFERTYPE']='非保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '1' ) )
            {$list[$k]['TRANSFERTYPE']='监管仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '2' ) )
            {$list[$k]['TRANSFERTYPE']='水路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '3' ) )
            {$list[$k]['TRANSFERTYPE']='铁路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '4' ) )
            {$list[$k]['TRANSFERTYPE']='公路运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '5' ) )
            {$list[$k]['TRANSFERTYPE']='航空运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '6' ) )
            {$list[$k]['TRANSFERTYPE']='邮件运输';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '7' ) )
            {$list[$k]['TRANSFERTYPE']='保税区';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '8' ) )
            {$list[$k]['TRANSFERTYPE']='保税仓库';}
		    else if($list[$k]['TRANSFERTYPE'] = ($v['TRANSFERTYPE'] == '9' ) )
            {$list[$k]['TRANSFERTYPE']='其它运输';}
		    else
            {$list[$k]['TRANSFERTYPE']='null';}
        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }

    public function tally_report_ensure_add()
    {
        $list['info'] = $this->tally_model->get_list_ensure3();
        $this->load->view('CBS/tally_report_ensure_add',$list);
    }
    public function tally_report_ensure_ajax_data1(){
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>guid_create(),
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_insert_ensure($data);
            //返回插入成功
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }
    }

    public function tally_report_ensure_edit()
    {
        //获取总运单号
        $guid = $this->input->get_post("guid");
        if(!empty($guid)){
            $condition['GUID']=$guid;
        }
        $list['info'] = $this->tally_model->get_list_ensure4($condition);
        $this->load->view('CBS/tally_report_ensure_edit',$list);
    }
    public function tally_report_ensure_edit_ajax_data1(){
        //获取主键
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition1['GUID'] = $guid;
        }else {
            echo result_to_towf_new('1', 0, '主键不能为空', NULL);
            exit();
        }
        //获取航次航班号
        $flightno = $this->input->get_post("flightno");
        if(!empty($flightno)) {
            $condition['FLIGHTNO'] = $flightno;
        }else {
            echo result_to_towf_new('1', 0, '航次航班号不能为空', NULL);
            exit();
        }
        //获取运输方式代码
        $transfertype = $this->input->get_post("transfertype");
        if(!empty($transfertype)) {
            $condition['TRANSFERTYPE'] = $transfertype;
        }else {
            echo result_to_towf_new('1', 0, '运输方式代码不能为空', NULL);
            exit();
        }
        //获取运输工具代码
        $shipcode = $this->input->get_post("shipcode");
        if(!empty($shipcode)) {
            $condition['SHIPCODE'] = $shipcode;
        }else {
            echo result_to_towf_new('1', 0, '运输工具代码不能为空', NULL);
            exit();
        }
        //获取运输工具名称
        $shipname = $this->input->get_post("shipname");
        if(!empty($shipname)) {
            $condition['SHIPNAME'] = $shipname;
        }else {
            echo result_to_towf_new('1', 0, '运输工具名称不能为空', NULL);
            exit();
        }
        //获取集装箱(器)编号
        $boxno = $this->input->get_post("boxno");
        //$condition['BOXNO'] = $boxno;
        //获取集装箱(器)尺寸和类型
        $bosspec = $this->input->get_post("bosspec");
        //$condition['BOSSPEC'] = $bosspec;
        //获取重箱或者空箱标识代码
        $boxflag = $this->input->get_post("boxflag");
        //$condition['BOXFLAG'] = $boxflag;
        //获取封志号码，类型和施加封志人
        $flagno = $this->input->get_post("flagno");
        // $condition['FLAGNO'] = $flagno;
        //获取总提运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取分提运单号
        $tansferno = $this->input->get_post("tansferno");
        // $condition['TRANSFERNO'] = $transferno;
        //获取托运货物序号
        $goodsno = $this->input->get_post("goodsno");
        //$condition['GOODSNO'] = $goodsno;
        //获取托运货物包装种类
        $goodspacktype = $this->input->get_post("goodspacktype");
        if(!empty($goodspacktype)) {
            $condition['GOODSPACKTYPE'] = $goodspacktype;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装种类不能为空', NULL);
            exit();
        }
        //获取托运货物件数
        $goodsammount = $this->input->get_post("goodsammount");
        if(!empty($goodsammount)) {
            $condition['GOODSAMMOUNT'] = $goodsammount;
        }else {
            echo result_to_towf_new('1', 0, '托运货物件数不能为空', NULL);
            exit();
        }
        //获取货物简要概述
        $description = $this->input->get_post("description");
        //$condition['DESCRIPTION'] = $description;
        //获取货物描述补充信息
        $description2 = $this->input->get_post("description2");
        //$condition['DESCRIPTION2'] = $description2;
        //获取货物总毛重
        $totalweigth = $this->input->get_post("totalweigth");
        if(!empty($totalweigth)) {
            $condition['TOTALWEIGH'] = $totalweigth;
        }else {
            echo result_to_towf_new('1', 0, '货物总毛重不能为空', NULL);
            exit();
        }
        //获取卸货地代码
        $unloadingcode = $this->input->get_post("unloadingcode");
        if(!empty($unloadingcode)) {
            $condition['UPLOADINGCODE'] = $unloadingcode;
        }else {
            echo result_to_towf_new('1', 0, '卸货地代码不能为空', NULL);
            exit();
        }
        //获取到达卸货地时间
        $arrivetime = $this->input->get_post("arrivetime");
        if(!empty($arrivetime)) {
            $condition['ARRIVETIME'] = $arrivetime;
        }else {
            echo result_to_towf_new('1', 0, '到达卸货地时间不能为空', NULL);
            exit();
        }
        //获取申报地海关代码
        $appliedcustoms = $this->input->get_post("appliedcustoms");
        if(!empty($appliedcustoms)) {
            $condition['APPLIEDCUSTOMS'] = $appliedcustoms;
        }else {
            echo result_to_towf_new('1', 0, '申报地海关代码不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取监管场所海关备案编码
        $appliedcompany = $this->input->get_post("appliedcompany");
        if(!empty($appliedcompany)) {
            $condition['APPLIEDCOMPANY'] = $appliedcompany;
        }else {
            echo result_to_towf_new('1', 0, '监管场所海关备案编码不能为空', NULL);
            exit();
        }
        //获取备注
        $comments = $this->input->get_post("comments");
        //$condition['COMMENTS'] = $comments;
        //获取进出口标识
        $i_e_flag = $this->input->get_post("i_e_flag");
        if(!empty($i_e_flag)) {
            $condition['I_E_FLAG'] = $i_e_flag;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取申报企业检验检疫备案编号CIQ
        $appliedcompanyciq = $this->input->get_post("appliedcompanyciq");
        if(!empty($appliedcompanyciq)) {
            $condition['APPLIEDCOMPANYCIQ'] = $appliedcompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取申报企业检验检代码
        $appliedcustomsinsp = $this->input->get_post("appliedcustomsinsp");
        if(!empty($appliedcustomsinsp)) {
            $condition['APPLIEDCUSTOMSINSP'] = $appliedcustomsinsp;
        }else {
            echo result_to_towf_new('1', 0, '申报企业检验检代码不能为空', NULL);
            exit();
        }
        //获取托运货物包装类代码CIQ
        $goodspacktypeinsp = $this->input->get_post("goodspacktypeinsp");
        if(!empty($goodspacktypeinsp)) {
            $condition['GOODSPACKTYPEINSP'] = $goodspacktypeinsp;
        }else {
            echo result_to_towf_new('1', 0, '托运货物包装类代码CIQ不能为空', NULL);
            exit();
        }
        //插入预报理货报告数据
        $data = array(
            'GUID'          =>$guid,
            'FLIGHTNO'          =>$flightno,
            'TRANSFERTYPE'      =>$transfertype,
            'SHIPCODE'      =>$shipcode,
            'SHIPNAME'  =>$shipname,
            'BOXNO'=>$boxno,
            'BOSSPEC'        =>$bosspec,
            'BOXFLAG'          =>$boxflag,
            'FLAGNO'      =>$flagno,
            'TOTALTRANSFERNO'  =>$totaltransferno,
            'TANSFERNO'=>$tansferno,
            'GOODSNO'        =>$goodsno,
            'GOODSPACKTYPE'      =>$goodspacktype,
            'GOODSAMMOUNT'      =>$goodsammount,
            'DESCRIPTION'  =>$description,
            'DESCRIPTION2'=>$description2,
            'TOTALWEIGTH'=>$totalweigth,
            'UNLOADINGCODE' =>  $unloadingcode,
            'ARRIVETIME'      =>$arrivetime,
            'APPLIEDCUSTOMS'      =>$appliedcustoms,
            'STOCKPOSITION'  =>$stockposition,
            'APPLIEDCOMPANY'=>$appliedcompany,
            'COMMENTS'        =>$comments,
            'IETYPE'          =>$i_e_flag,
            'APPLIEDCOMPANYCIQ'      =>$appliedcompanyciq,
            'APPLIEDCUSTOMSINSP'  =>$appliedcustomsinsp,
            'GOODSPACKTYPEINSP'=>$goodspacktypeinsp
        );
        if(!empty($condition)) {
            $this->tally_model->report_update_ensure1($data,$condition1);
            echo result_to_towf_new('1', 1, 'success', NULL) ;
        }else{
            echo result_to_towf_new('1', 0, '更新失败', NULL) ;
        }
    }
    public function tally_report_ensure_del()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->report_del_ensure1($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function tally_report_ensure_add_no()
    {
        $list['info'] = $this->tally_model->get_list_ensure3();
        $this->load->view('CBS/tally_report_ensure_add_no',$list);
    }
    public function tally_report_ensure_add_no_ajax_data(){
        //获取总运单号
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['TOTALTRANSFERNO'] = $totaltransferno;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition['BATCHNO'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition['HBL'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分单号不能为空', NULL);
            exit();
        }
        //获取货物抵运日期
        $tally_date = $this->input->get_post("tally_date");
        //获取进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(!empty($i_e_type)) {
            $condition['I_E_TYPE'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取品名
        $goods_name = $this->input->get_post("goods_name");
        //获取件数
        $pieces = $this->input->get_post("pieces");
        if(!empty($pieces)) {
            $condition['PIECES'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition['WEIGHT'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量不能为空', NULL);
            exit();
        }
        //获取理货件数
        $m_pieces = $this->input->get_post("m_pieces");
        if(!empty($m_pieces)) {
            $condition['M_PIECES'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        //获取理货重量
        $m_weight = $this->input->get_post("m_weight");
        if(!empty($m_weight)) {
            $condition['M_WEIGHT'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取客户
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition['CUSTOMER_CODE'] = $customer_code;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno = $this->input->get_post("goodsno");
        if(!empty($goodsno)) {
            $condition['GOODSNO'] = $goodsno;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        //物流企业检验检疫备案编号CIQ
        $transfercompanyciq = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition['E_BUSINESS'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //获取维护人
        $add_who = $this->input->get_post("add_who");
        //$condition['DESCRIPTION2'] = $description2;
        //获取维护日期
        $add_date = $this->input->get_post("add_date");
        //插入总单理货报告数据
        $data = array(
            'GUID'          =>guid_create(),
            'MBL'          =>$totaltransferno,
            'BATCHNO'          =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_code,
            'GOODSNO'      =>$goodsno,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'  =>$e_business,
            'ADD_WHO'=>$add_who,
            'ADD_DATE'=>$add_date
        );
        if(!empty($condition)) {
            $this->tally_model->report_insert_ensure1($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function tally_report_ensure_edit_no()
    {
        $guid = $this->input->get_post("guid");
        $condition = array();
        $condition['GUID'] = $guid;
        $list['info'] = $this->tally_model->get_list_ensure2($condition);
        $this->load->view('CBS/tally_report_ensure_edit_no',$list);
    }
    public function tally_report_ensure_edit_no_ajax_data(){
        //获取主键
        $guid = $this->input->get_post("guid");
        if(!empty($guid)) {
            $condition1['GUID'] = $guid;
        }else {
            echo result_to_towf_new('1', 0, '主键不能为空', NULL);
            exit();
        }
        //获取总运单号
        $mbl = $this->input->get_post("mbl");
        if(!empty($mbl)) {
            $condition['MBL'] = $mbl;
        }else {
            echo result_to_towf_new('1', 0, '总提运单号不能为空', NULL);
            exit();
        }
        //获取批次号
        $batchno = $this->input->get_post("batchno");
        if(!empty($batchno)) {
            $condition['BATCHNO'] = $batchno;
        }else {
            echo result_to_towf_new('1', 0, '批次号不能为空', NULL);
            exit();
        }
        //获取分单号
        $hbl = $this->input->get_post("hbl");
        if(!empty($hbl)) {
            $condition['HBL'] = $hbl;
        }else {
            echo result_to_towf_new('1', 0, '分单号不能为空', NULL);
            exit();
        }
        //获取货物抵运日期
        $tally_date = $this->input->get_post("tally_date");
        //获取进出口标识
        $i_e_type = $this->input->get_post("i_e_type");
        if(!empty($i_e_type)) {
            $condition['I_E_TYPE'] = $i_e_type;
        }else {
            echo result_to_towf_new('1', 0, '进出口标识不能为空', NULL);
            exit();
        }
        //获取品名
        $goods_name = $this->input->get_post("goods_name");
        //获取件数
        $pieces = $this->input->get_post("pieces");
        if(!empty($pieces)) {
            $condition['PIECES'] = $pieces;
        }else {
            echo result_to_towf_new('1', 0, '件数不能为空', NULL);
            exit();
        }
        //获取重量
        $weight = $this->input->get_post("weight");
        if(!empty($weight)) {
            $condition['WEIGHT'] = $weight;
        }else {
            echo result_to_towf_new('1', 0, '重量不能为空', NULL);
            exit();
        }
        //获取理货件数
        $m_pieces = $this->input->get_post("m_pieces");
        if(!empty($m_pieces)) {
            $condition['M_PIECES'] = $m_pieces;
        }else {
            echo result_to_towf_new('1', 0, '理货件数不能为空', NULL);
            exit();
        }
        //获取理货重量
        $m_weight = $this->input->get_post("m_weight");
        if(!empty($m_weight)) {
            $condition['M_WEIGHT'] = $m_weight;
        }else {
            echo result_to_towf_new('1', 0, '理货重量不能为空', NULL);
            exit();
        }
        //获取库位
        $stockposition = $this->input->get_post("stockposition");
        if(!empty($stockposition)) {
            $condition['STOCKPOSITION'] = $stockposition;
        }else {
            echo result_to_towf_new('1', 0, '库位不能为空', NULL);
            exit();
        }
        //获取客户
        $customer_code = $this->input->get_post("customer_code");
        if(!empty($customer_code)) {
            $condition['CUSTOMER_CODE'] = $customer_code;
        }else {
            echo result_to_towf_new('1', 0, '客户不能为空', NULL);
            exit();
        }
        //获取物流企业海关备案编号
        $goodsno1 = $this->input->get_post("goodsno1");
        if(!empty($goodsno1)) {
            $condition['GOODSNO'] = $goodsno1;
        }else {
            echo result_to_towf_new('1', 0, '物流企业海关备案编号不能为空', NULL);
            exit();
        }
        //物流企业检验检疫备案编号CIQ
        $transfercompanyciq = $this->input->get_post("transfercompanyciq");
        if(!empty($transfercompanyciq)) {
            $condition['TRANSFERCOMPANYCIQ'] = $transfercompanyciq;
        }else {
            echo result_to_towf_new('1', 0, '物流企业检验检疫备案编号CIQ不能为空', NULL);
            exit();
        }
        //获取电商企业名称
        $e_business = $this->input->get_post("e_business");
        if(!empty($e_business)) {
            $condition['E_BUSINESS'] = $e_business;
        }else {
            echo result_to_towf_new('1', 0, '电商企业名称不能为空', NULL);
            exit();
        }
        //获取维护人
        $add_who = $this->input->get_post("add_who");
        //$condition['DESCRIPTION2'] = $description2;
        //获取维护日期
        $add_date = $this->input->get_post("add_date");
        //插入总单理货报告数据
        $data = array(
            'GUID'          =>$guid,
            'MBL'          =>$mbl,
            'BATCHNO'          =>$batchno,
            'HBL'      =>$hbl,
            'TALLY_DATE'      =>$tally_date,
            'I_E_TYPE'  =>$i_e_type,
            'GOODS_NAME'=>$goods_name,
            'PIECES'        =>$pieces,
            'WEIGHT'          =>$weight,
            'M_PIECES'      =>$m_pieces,
            'M_WEIGHT'  =>$m_weight,
            'STOCKPOSITION'=>$stockposition,
            'CUSTOMER_CODE'        =>$customer_code,
            'GOODSNO'      =>$goodsno1,
            'TRANSFERCOMPANYCIQ'      =>$transfercompanyciq,
            'E_BUSINESS'  =>$e_business,
            'ADD_WHO'=>$add_who,
            'ADD_DATE'=>$add_date
        );

        if(!empty($condition)) {
            $this->tally_model->report_update_ensure($data, $condition1);
            echo result_to_towf_new('1', 1, 'success', null);
            exit();
        }
    }
    public function tally_report_ensure_del_ajax_data()
    {
        $data = $this->input->get_post("guid");
        if ($data) {
            $this->tally_model->report_del_ensure($data);
            echo result_to_towf_new('1', 1, 'success', null);
        }
    }
    public function tally_report_ensure_search_data(){

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
        $totaltransferno = $this->input->get_post("totaltransferno");
        if(!empty($totaltransferno)) {
            $condition['MBL'] = $totaltransferno;
        }
        //获取客户编号
        $batchno = $this->input->get_post("batchno");
        //获取客户名称
        $hbl = $this->input->get_post("hbl");
        //获取客户简称
        $goods_name_import= $this->input->get_post("goods_name_import");
        //获取客户类型
        $num = $this->input->get_post("num");
        //获取税务登记号
        $weight = $this->input->get_post("weight");
        //企业海关备案编号
        $price = $this->input->get_post("price");
        //获取税务登记号
        $currency = $this->input->get_post("currency");
        //企业海关备案编号
        $app_date = $this->input->get_post("app_date");
        $recv_user= $this->input->get_post("recv_user");
        $send_user        = $this->input->get_post("send_user");
        $appliedcompany       = $this->input->get_post("appliedcompany");
        $transfercompanyciq   = $this->input->get_post("transfercompanyciq");
        $customer_code    = $this->input->get_post("customer_code");
        $goodsno      = $this->input->get_post("goodsno");
        $e_business  = $this->input->get_post("e_business");
        $total = $this->tally_model->count_num_ensure1($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);
        $list = $this->tally_model->get_list_ensure1($condition,$limit,$offset);
		$list1 = $this->tally_model->location();
        foreach($list as $k=>$v) {
            $list[$k]['I_E_TYPE'] = ($v['I_E_TYPE'] == 'I') ? "进口" : '<font color="red">出口</font>';
        }
		 foreach($list1 as $k1=>$v1){
			   foreach($list as $k=>$v){
               if($list[$k]['STOCKPOSITION'] == $list1[$k1]['GOODSSITE_NO'])   
			    {
				$list[$k]['STOCKPOSITION'] = $list1[$k1]['GOODSSITE_NO'];}  
                }
              }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
        //showmessage("添加库位成功","sample2/index",3,1);
        //exit();
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
}
