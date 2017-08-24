<?php
class Export extends CI_Controller {

    // public function index()
    // {
    //     echo 'Hello World!';
    // }

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('TDC_Model');
        $this->load->library('PHPExcel');
		$this->load->library('/PHPExcel/Writer/Excel2007');
    }

public function index(){
$datas = array(

    array('王城', '男', '18', '1997-03-13', '18948348924'),

    array('李飞虹', '男', '21', '1994-06-13', '159481838924'),

    array('王芸', '女', '18', '1997-03-13', '18648313924'),

    array('郭瑞', '男', '17', '1998-04-13', '15543248924'),

    array('李晓霞', '女', '19', '1996-06-13', '18748348924'),

);




//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的

// 创建一个excel

$objPHPExcel = new PHPExcel();

 

// Set document properties

$objPHPExcel->getProperties()->setCreator("Phpmarker")->setLastModifiedBy("Phpmarker")->setTitle("Phpmarker")->setSubject("Phpmarker")->setDescription("Phpmarker")->setKeywords("Phpmarker")->setCategory("Phpmarker");

 

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', iconv('gbk', 'utf-8', '名字'))->setCellValue('B1', '性别')->setCellValue('C1', '年龄')->setCellValue('D1', '出生日期')->setCellValue('E1', '电话号码');

         

// Rename worksheet

$objPHPExcel->getActiveSheet()->setTitle('Phpmarker-' . date('Y-m-d'));

         

// Set active sheet index to the first sheet, so Excel opens this as the first sheet

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

$objPHPExcel->getActiveSheet()->freezePane('A2');

$i = 2;

foreach($datas as $data){

    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $data[0])->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data[1]);

    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data[2]);

 

    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'. $i, $data[3],PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getNumberFormat()->setFormatCode("@");

     

    // 设置文本格式

    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E'. $i, $data[4],PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setWrapText(true);

    $i ++;

}

 

$objActSheet = $objPHPExcel->getActiveSheet();

                 

// 设置CELL填充颜色

$cell_fill = array(

        'A1',

        'B1',

        'C1',

        'D1',

        'E1',

);

foreach($cell_fill as $cell_fill_val){

    $cellstyle = $objActSheet->getStyle($cell_fill_val);

    // background

    // $cellstyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('fafa00');

    // set align

    $cellstyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    // font

    $cellstyle->getFont()->setSize(12)->setBold(true);

    // border

    $cellstyle->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');

    $cellstyle->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');

    $cellstyle->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');

    $cellstyle->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');

}

     

$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

     

$objActSheet->getColumnDimension('A')->setWidth(18.5);

$objActSheet->getColumnDimension('B')->setWidth(23.5);

$objActSheet->getColumnDimension('C')->setWidth(12);

$objActSheet->getColumnDimension('D')->setWidth(12);

$objActSheet->getColumnDimension('E')->setWidth(12);

 

 

$filename = '2015030423';

ob_end_clean();//清除缓冲区,避免乱码 

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="'.$filename.'.xls"');

header('Cache-Control: max-age=0');

// If you're serving to IE 9, then the following may be needed

header('Cache-Control: max-age=1');

 

// If you're serving to IE over SSL, then the following may be needed

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified

header('Cache-Control: cache, must-revalidate'); // HTTP/1.1

header('Pragma: public'); // HTTP/1.0

 

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

$objWriter->save('php://output');
}
}
?>
