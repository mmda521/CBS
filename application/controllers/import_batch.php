<?php
/**
 *库位操作
 *
 *
 **/
class Import_batch extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('import_model');      
        $this->load->helper('common_function');
        $this->load->helper('guid');
        $this->load->library("common_page");  
    }
	
	/**
    *生成guid
    *
    *
    * 
     public function create_guid()
    {
       
        $data = array(
		'guid'  =>guid_create()	          
        );
		
       $this->location_model->insert_batch($data);	   
    }*/
	
	function uuid() {
    if (function_exists ( 'com_create_guid' )) {
        return com_create_guid ();
    } else {
        mt_srand ( ( double ) microtime () * 10000 ); //optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
        $charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) ); //根据当前时间（微秒计）生成唯一id.
        $hyphen = chr ( 45 ); // "-"
        $uuid = '' . //chr(123)// "{"
substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 );
        //.chr(125);// "}"
        return $uuid;
    }
}
	
function shijian(){
	$date=date('Y-m-d H:i:s',time());
	//PC::debug($date);
	return $date;
	
}
	
    /**
    *运单批次导入页面
    *
    *
    * */
	
 public function import_batch(){
		
		 $this->load->view('CBS/waybill_input');
		 
	 }
   
   
    /**
    *运单批次导入页面
    *
    *
    * */
	

    public function excel_put_batch(){
		 
        //先做一个文件上传，保存文件
	    $path=$_FILES['file1'];	
	   if(empty($path["name"])) {
			  echo result_to_towf_new('1', 0, '导入文件不能为空', NULL);
			   exit();
		   }
      else{	   
        $filePath = "uploads/".$path["name"];
		$filePath1=iconv("UTF-8","GB2312",$filePath);
		//PC::debug($path);
        move_uploaded_file($path["tmp_name"],$filePath1);
        $data=array('A'=>'MBL','B'=>'BATCHNO','C'=>'BATCHTYPE','D'=>'BATCHCONTROL','E'=>'TALLY_STATUS');
        $tablename='kjw_tally_batch';//表名字
       $this->excel_fileput($filePath1,$data,$tablename);
	   echo result_to_towf_new('1', 1, 'success', null);
	   }	
	   
    }
	  public function excel_fileput($filePath1,$data,$tablename){
        $this->load->library("phpexcel");//ci框架中引入excel类
        $PHPExcel = new PHPExcel();
		/*默认用excel2007读取excel，若格式不对，则用之前的版本进行读取 */
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead($filePath1)){
            $PHPReader = new PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($filePath1)){
                echo 'no Excel';
                return ;
            }
        }
		
		 // 加载excel文件
        $PHPExcel = $PHPReader->load($filePath1);

        // 读取excel文件中的第一个工作表
        $currentSheet = $PHPExcel->getSheet(0);
        // 取得最大的列号
        $allColumn = $currentSheet->getHighestColumn();
        // 取得一共有多少行
        $allRow = $currentSheet->getHighestRow();
        // 从第二行开始输出，因为excel表中第一行为列名
		
        
        for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
            /**从第A列开始输出*/
            //echo $allColumn;

			 
			 for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
                $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue(); /**ord()将字符转为十进制数*/ 
               
               if($currentColumn <= $allColumn){
                    $data1[$currentColumn]=$val;
                }
				
            }
			
			
            foreach($data as $key=>$val){
               $data2[$currentRow][$val]=$data1[$key];
            }
			$data2[$currentRow]['GUID']=$this->uuid();
			$data2[$currentRow]['CREATE_DATE']=$this->shijian();
			$data2[$currentRow]['CREATE_USER']=$_SESSION['USER_ID'];
        }
		 for($currentRow = 2;$currentRow < $allRow;$currentRow++){
			 if($data2[$currentRow]['BATCHNO']==$data2[$currentRow+1]['BATCHNO'])
			 {
				//echo '批次号有重复，请纠正错误再正确导入'; 
				//$this->load->view('CBS/waybill_input'); 
				 echo result_to_towf_new('1', 0, '批次号有重复，请重新导入', NULL);
				//echo "<script>alert('批次号有重复，请纠正错误再正确导入');</script>";
				exit();
			 }
			 else{
				 continue;
			     }
			
		 }
		  for($currentRow = 2;$currentRow <= $allRow;$currentRow++)
		  {
		  $this->import_model->insert_batch($data2[$currentRow]);		  
		  }
		// echo "导入成功";
		//$this->import_model->insert_batch($data2);
		
        //echo "\n";
      //echo "导入成功";
	 //$this->load->view('CBS/waybill_input'); 
	// echo "<script>alert('导入成功');window.location.href='import_batch/import_batch';</script>";
  }
  
}