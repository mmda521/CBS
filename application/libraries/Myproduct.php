<?php
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Myproduct{
	public $type = '' ;
	public function __construct($params = '')
	{
		$this->type = (isset($params['type']))?$params['type']:'';
	}
	/**
	 * 格式化select
	 * @author 王建
	 * @param array $parent
	 * @deep int 层级关系 
	 * @return array
	 */
	function getChildren($parent,$deep=0) {
			foreach($parent as $row) {
				$data[] = array("id"=>isset($row['id'])?$row['id']:'', "name"=>isset($row['name'])?$row['name']:'',"pid"=>isset($row['pid'])?$row['pid']:'','deep'=>$deep);
				if (isset($row['children']) && !empty($row['children'])) {
					$data = array_merge($data, $this->getChildren($row['children'], $deep+1));
				}
			}
			return $data;
	}
}