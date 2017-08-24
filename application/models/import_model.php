<?php
/**
 *运单模型
 *
 *
 **/

class Import_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		
		
		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert_batch($data=''){
			
        	$this->db->insert('kjw_tally_batch',$data);	
    	}
		
			/**
		 *插入数据
		 *
		 *
		 * */
		public function insert_hbl($data=''){
			
        	$this->db->insert('kjw_hbl',$data);	
    	}
				
		
		/**
		 *批次号总行数
		 *
		 *
		 * */
		public function count_num_batch($where = ''){
			
       		$query = $this->db->select('count(*)')->from('kjw_tally_batch')->where('BATCHNO',$where)->get();
       		$total = $query->row_array();
			//PC::debug(query);
       		return $total['count(*)'];
		}
		
			/**
		 *获取数据
		 *
		 *
		 * */
		public function get_batch_data($where = ''){
       		$query = $this->db->select('MBL')->from('kjw_tally_batch')->where('BATCHNO',$where)->get();
       		$total = $query->row_array();
       		return $total;
		}
}

