<?php
/*
 *公共的上传图片方法
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}

class Common_upload{
	var $ci  ;
	function __construct() {
		$this->ci =& get_instance();
	}
	/*	
	@params $upload_path 上传路径
	@params $name file表单的name值
	@params $allow_type 允许上传的文件格式
	@return string $filename ;
	*/	
	function upload_path( $upload_path = '' ,$name = 'image' , $allow_type = 'gif|jpg|png'  ){	
		$image = '' ;
		if(isset($_FILES[$name]) && $_FILES[$name] ){		
			if(!empty($_FILES[$name]['name'])){
				  $config['upload_path'] = $upload_path;
				  $config['allowed_types'] = $allow_type;
				 // $config['max_size'] = '100';
				  //$config['max_width']  = '1024';
				 // $config['max_height']  = '768';
				  $config['remove_spaces']  =true ;
				  $config['file_name']  =time().rand();
				  $this->ci->load->library('upload', $config);
				  if ( ! $this->ci->upload->do_upload($name)){
					exit("操作失败,{$this->ci->upload->display_errors()}");
				   } else{
						$data_ = array('upload_data' => $this->ci->upload->data());
						$image = $data_['upload_data']['orig_name'];
				  }
			}
		}
		return $image ; 
	}	
	
}
