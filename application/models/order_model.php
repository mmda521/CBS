<?php
/**
 *指令模型
 *
 *
 **/

class Order_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		/**
		 *总单号总行数
		 *
		 *
		 * */
		public function count_num($where = ''){
       		$query = $this->db->select('count(*)')->from('kjw_discharged')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}

			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_cus_data($where = ''){
       		$query = $this->db->select('*')->from('kjw_discharged')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

		}
		
		
			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_insp_data($where = ''){
       		$query = $this->db->select('*')->from('kjw_discharged')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

		}
		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('kjw_discharged')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
            return $list;
    	}
		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert(){
			
		}

		/**
		 *更新数据
		 *
		 *
		 * */
		public function update(){
			
		}

		/**
		 *删除数据
		 *
		 *
		 * */
		public function delete(){
			
		}

}

