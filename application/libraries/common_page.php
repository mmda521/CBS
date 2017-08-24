<?php
/*
 *公共的分页方法
 *
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}

class Common_page{
	var $ci  ;
	function __construct() {
		
	}
	/*
	@params $total 总数
	@params $page_num 每一页显示的条数
	@params $page 当前第几页
	@params $ajax_function ajax方法名字
	*/
 	function page_string($total,$page_num,$page,$ajax_function = 'ajax_data'){
		$CI =& get_instance();
		$page_string = '' ;
		$CI->load->library('pagination');//加载分页类
		$CI->load->library('MY_Pagination');//加载分页类
		$config['total_rows'] = $total;
		$config['use_page_numbers'] =true; // 当前页结束样式
		$config['per_page'] = $page_num; // 每页显示数量，为了能有更好的显示效果，我将该数值设置得较小
		$config['full_tag_open'] = '<ul class="pagination">'; // 分页开始样式
		$config['full_tag_close'] = '</ul>'; // 分页结束样式
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示
		$config['cur_tag_open'] = ' <li><a class="disabled ">'; // 当前页开始样式
		$config['cur_tag_close'] = '</a></li>'; // 当前页结束样式
		$config['uri_segment'] = 6;
		$config['anchor_class']='class="ajax_page" ';
		$CI->pagination->cur_page = $page ;
		$CI->pagination->initialize($config); // 配置分页
		$page_string =  $CI->pagination->create_links(true,$ajax_function);
		return $page_string ;
	} 	
		
	
}
