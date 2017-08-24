<?php 
/*
 *后台控制器不需要进行权限控制
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Common extends MY_Controller{
	function Common(){
		parent::__construct();
        $this->load->model('M_common');
        $this->load->helper('common_function_helper');
        $this->load->helper('url');
	}
	function get_menu(){
            $isadmin = true ;

		$list = array() ;
        $list1 = array() ;
        $condition=array();
        $condition1=array();
        $condition1['ROLE_ID']=$_SESSION['ROLE_ID'];
        $list1 = $this->M_common->get_list($condition1);
        $list1=explode(',',$list1);
		
        $list = $this->M_common->querylist($list1);
		
		$result = array();
		if($list){
			foreach($list as $k=>$v){
				$result[$v['id']]  = $v ;
			}
		}
		
		$result = genTree9($result,'id','parentid','items');
		//PC::debug($result);
		$last_data = array();
		$top_array = array();
		$two = array();
		$three = array();
		$homePage = '';
		if($result){
			foreach($result as $k=>$v){
				$top_array[] = $v['name'];
				if(isset($v['items']) && $v['items']){
					foreach($v['items'] as $t_k=>$t_v){
						//二级的菜单
						if(isset($t_v['items']) && $t_v['items']){
							foreach($t_v['items'] as $three_key=>$three_val){
								//判断权限开始
								$three[] = array(
										'text'=>$three_val['name'],
										'href'=>($three_val['url_type'] == 1 )?site_url($three_val['url']):$three_val['url'],
										'id'=>$three_val['id'],
                                    'closeable'=>($three_val['closeable'] == 1)?true:false,
								);
							}
						}

						$two[] = array(
							'text'=> $t_v['name'] ,
							'items'=>isset($three)?$three:array(),
							'collapsed'=>($t_v['collapsed'] == 1) ?true:false ,//判断菜单是否是收缩
						);
						unset($three);
					}
				}
				if(isset($two) && !empty($two)){
					$last_data[] = array(
						'menu'=>isset($two)?$two:array() ,
						'homePage'=>isset($two[0]['items'][0]['id'])?$two[0]['items'][0]['id']:0,
						'id'=>isset($two[0]['items'][0]['id'])?$two[0]['items'][0]['id']:0,
						'collapsed'=>false,//默认是不是收缩的
					);
				}

				unset($two);
			}
		}
		//$last_data['top'] = $top_list ;
		echo json_encode($last_data);
		
	}
}