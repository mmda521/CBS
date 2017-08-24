<?php
/**
 *库位模型
 *
 *
 **/

class Location_model extends CI_Model {

		public function __construct(){
			$this->load->database();
		}
		
		
		/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_data($where = ''){
       		$query = $this->db->select('*')->from('con_freightlot')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

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
     *获取登录角色
     *
     *
     * */
    public function get_operuser_id(){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('*')->from('eci_user')->get();
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

		
		
		


		
		/**
		 *更新数据
		 *
		 *
		 * */
           public function update($data = '',$GUID){
			 $this->db->where('GUID', $GUID); 
        	$this->db->update('con_freightlot', $data);	 
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
            $this->db->where_in('GUID',$GUID)->delete('con_freightlot');    		
    		return 'ok';
		}

}

