<?php
/**
 *客户信息模型
 *
 *
 **/

class Customer_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		/**
		 *总行数
		 *
		 *
		 * */
		public function count_num($where = ''){
       		$query = $this->db->select('count(*)')->from('con_freight_agent')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}

			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_data($where = ''){
       		$query = $this->db->select('*')->from('con_freight_agent')->where($where)->get();
       		$total = $query->result_array();
       		return $total;
		}
		
			/**
		 *判断重复的数据
		 *
		 *
		 * */
		public function repeat1($where = ''){
       		$query = $this->db->select('*')->from('con_freight_agent')->where($where)->get();
       		$total = $query->result_array();
       		return $total;
		}
		
		public function repeat2($where = ''){
       		$query = $this->db->select('*')->from('con_freight_agent')->where($where)->get();
       		$total = $query->result_array();
       		return $total;
		}
		
		public function repeat3($where = ''){
       		$query = $this->db->select('*')->from('con_freight_agent')->where($where)->get();
       		$total = $query->result_array();
       		return $total;
		}
		/**
		 *获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('con_freight_agent')->where($where)->order_by('index_no','desc')->limit($limit,$offset)->get();
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
        	$query = $this->db->select('index_no')->from('con_freight_agent')->where($where)->limit('1')->get();
    		$list = $query->result_array();
    		return $list;
    	}

		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert($data = ''){
        	$this->db->insert('con_freight_agent', $data);	
    		
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
        	$this->db->update('con_freight_agent', $data);	 
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
		public function delete($data){
			//$this->db->where('GUID', $data);
            //$this->db->delete('con_freight_agent');
			//$this->db->delete('con_freightlot', $data,"index_no=$index_no");
              $this->db->where_in('GUID',$data)->delete('con_freight_agent');			
    		return 'ok';
		}

}

