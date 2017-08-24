<?php 
$this->load->model('location_model');  
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
		 //PC::debug($status);
        if(in_array($status,array('Y','N',true))){
            $condition['status'] = $status; 
        }
        
        $total = $this->location_model->export_data($condition);      
	    foreach($total as $k=>$v){
            $total[$k]['STATUS'] = ($v['STATUS'] == 'Y' )?"启用":"停用";          
        }
		 // PC::debug($total);

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
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
            header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            //echo result_to_towf_new('1', 1, 'success', null);
			$objWriter->save('php://output');
			sleep(5);
			PC::debug('jij');
			// $objWriter->save("downloads/".$filename);
			 //PC::debug('123');










?>