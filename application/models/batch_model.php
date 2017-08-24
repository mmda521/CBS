<?php
/**
 *库位模型
 *
 *
 **/

class Batch_model extends CI_Model {

		public function __construct(){
			$this->load->database();
		}
		
		
		
		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_list_mbl($where = ''){
        	$query = $this->db->select('*')->from('kjw_mbl')->where($where)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}
		
		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_batch_mbl($MBL){
        	$query = $this->db->select('*')->from('kjw_tally_batch')->where_in('MBL',$MBL)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}
		
		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_batch($where = ''){
        	$query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}
		
		
		/**
		 *删除数据
		 *
		 *
		 * */
		public function export_batch($GUID){
			$query = $this->db->select('*')->from('kjw_tally_batch')->where_in('GUID',$GUID)->get();
       		$total = $query->result_array();
       		return $total;          
		}
		
		/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_data($where = ''){
       		$query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

		}
		
		/**
		 *总行数
		 *
		 *
		 * */
		public function count_num($where = ''){
       		$query = $this->db->select('count(*)')->from('kjw_tally_batch')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}

		/**
		 *获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->order_by('BATCHNO','desc')->limit($limit,$offset)->get();
            $list = $query->result_array();
            return $list;
    	}

		
		
		/**
		 *批次号获取数据列表
		 *
		 *
		 * */
		public function get_list_batch($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}
		
		/**
		 *获取检索号
		 *
		 *
		 * */
		public function get_index_no($where = '', $limit = '', $offset = ''){
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('index_no')->from('kjw_tally_batch')->where($where)->limit('1')->get();
    		$list = $query->result_array();
    		return $list;
    	}

		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert($data = ''){
        	$this->db->insert('kjw_tally_batch', $data);	
    		
    		//$list = $query->result_array();
    		//return $list;
    		return 'ok';
    	}

		
		
		


		
		/**
		 *更新数据
		 *
		 *
		 * */
           public function update($data = '',$GUID){
			 $this->db->where('GUID', $GUID); 
        	$this->db->update('kjw_tally_batch', $data);	 
        	//$this->db->update('con_freightlot', $data,"GUID=$GUID");	    		
    		//$list = $query->result_array();
    		//return $list;
    		return 'ok';
    	}
		/**
		 *删除数据
		 *
		 *
		 * */
		public function delete($GUID){
			//$this->db->where('GUID', $GUID);
            //$this->db->delete('con_freightlot');
			//$this->db->delete('con_freightlot', $data,"index_no=$index_no");	
            $this->db->where_in('GUID',$GUID)->delete('kjw_tally_batch');    		
    		return 'ok';
		}

}

