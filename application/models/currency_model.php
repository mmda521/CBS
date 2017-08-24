<?php
/**
 *币值模型
 *
 *
 **/

class Currency_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		/**
		 *总行数
		 *
		 *
		 * */
		public function count_num($where = ''){
       		$query = $this->db->select('count(*)')->from('kjw_currtype')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}
		
		
		/**
		 *获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('kjw_currtype')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
            return $list;
    	}

	
	/**
		 *插入数据
		 *
		 *
		 * */
		public function insert($data = ''){
        	$this->db->insert('kjw_currtype', $data);	
    		
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
        	$this->db->update('kjw_currtype', $data);	 
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
            $this->db->where_in('GUID',$GUID)->delete('kjw_currtype');    		
    		return 'ok';
		}	

}

