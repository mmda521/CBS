<?php
/**
 *样例
 *
 *
 **/

class Sample2_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		/**
		 *总行数
		 *
		 *
		 * */
		public function count_num($where = ''){
       		$query = $this->db->select('count(*)')->from('con_freightlot')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}

		/**
		 *获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('con_freightlot')->where($where)->order_by('index_no','desc')->limit($limit,$offset)->get();
            $list = $query->result_array();
            return $list;
    	}

		/**
		 *获取检索号
		 *
		 *
		 * */
		public function get_index_no($where = '', $limit = '', $offset = ''){
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('index_no')->from('con_freightlot')->where($where)->limit('1')->get();
    		$list = $query->result_array();
    		return $list;
    	}

		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert($data = ''){
        	$this->db->insert('con_freightlot', $data);	
    		
    		//$list = $query->result_array();
    		//return $list;
    		return 'ok';
    	}

	

}

