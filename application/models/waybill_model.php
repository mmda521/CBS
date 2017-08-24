<?php
/**
 *运单模型
 *
 *
 **/

class Waybill_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}
		
		
		
		 /**
     *获取币制种类
     *
     *
     * */
    public function currtype(){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('*')->from('kjw_currtype')->get();
        $list = $query->result_array();
        return $list;
    }

	 /**
     *获取快递种类
     *
     *
     * */
    public function customer(){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('*')->from('con_freight_agent')->get();
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
		 *总单号总行数
		 *
		 *
		 * */
		public function count_num_mbl($where = ''){
       		$query = $this->db->select('count(*)')->from('kjw_mbl')->where($where)->get();
       		$total = $query->row_array();
       		return $total['count(*)'];

		}
		/**
		 *分单号总行数
		 *
		 *
		 * */
		public function count_num_hbl($where = ''){
			//PC::debug($where);
       		$query = $this->db->select('count(*)')->from('kjw_hbl')->where($where)->get();
			//PC::debug($query);
       		$total = $query->row_array();
       		return $total['count(*)'];

		}
		
		
			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_mbl_data($where = ''){
       		$query = $this->db->select('*')->from('kjw_mbl')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

		}
		
		
			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_hbl_data($where = ''){
       		$query = $this->db->select('*')->from('kjw_hbl')->where($where)->get();
       		$total = $query->result_array();
       		return $total;

		}
		
			/**
		 *导出的数据
		 *
		 *
		 * */
		public function export_hbl_data1($GUID){
       		$query = $this->db->select('*')->from('kjw_hbl')->where_in('GUID',$GUID)->get();
       		$total = $query->result_array();
       		return $total;

		}
		
		
		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_list($where = '', $limit = '', $offset = ''){
			
        	$query = $this->db->select('*')->from('kjw_mbl')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}

		/**
		 *总单号获取数据列表
		 *
		 *
		 * */
		public function get_list_mbl($where = '', $limit = '', $offset = ''){
        	$query = $this->db->select('*')->from('kjw_mbl')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
			//PC::debug($query);
            return $list;
    	}
		
		/**
		 *
		 获取数据列表
		 *
		 *
		 * */
		public function get_list_hbl($where ='', $limit ='', $offset =''){
        	$query = $this->db->select('*')->from('kjw_hbl')->where($where)->limit($limit,$offset)->get();
            $list = $query->result_array();
            return $list;
    	}
		/**
		 *获取主单号
		 *
		 *
		 * */
		public function get_index_no($where = ''){
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('MBL')->from('kjw_mbl')->where($where)->get();
    		$list = $query->row_array();
    		return $list;
    	}
		
		/**
		 *获取主单号
		 *
		 *
		 * */
		public function get_index_no_mbl($where = ''){
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('MBL')->from('kjw_mbl')->where('GUID',$where)->get();
    		$list = $query->row_array();
    		return $list;
    	}
		
		/**
		 *获取guid对应的一组数据
		 *
		 *
		 * */
		public function get_select($where = ''){
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('guid')->from('kjw_mbl')->where($where)->get();
    		$list = $query->row_array();
			
    		return $list;
    	}
		/**
		 *获取hbl对应的一组数据
		 *
		 *
		 * */
		public function get_select_mbl($where = ''){
			//PC::debug($where);
        	//SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 
        	$query = $this->db->select('MBL')->from('kjw_hbl')->where($where)->get();
			//PC::debug('12334');
    		$list = $query->row_array();
			//PC::debug($list);
    		return $list;
    	}

		/**
		 *获取hbl对应的一组数据
		 *
		 *
		 * */
		public function get_select_fen_guid($where = ''){
        	$query = $this->db->select('GUID')->from('kjw_hbl')->where($where)->get();
			//PC::debug($query);
    		$list = $query->result_array();
			PC::debug($list);
    		return $list;
    	}
		
		/**
		 *获取hbl对应的一组数据
		 *
		 *
		 * */
		public function get_select_batchno_guid($where = ''){ 
        	$query = $this->db->select('GUID')->from('kjw_tally_batch')->where($where)->get();
			
    		$list = $query->result_array();
			//PC::debug($list);
    		return $list;
    	}
		
		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert_mbl($data=''){
        	$this->db->insert('kjw_mbl',$data);	
			return 'ok';
    	}

		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert_hbl($data=''){
        	$this->db->insert('kjw_hbl',$data);	
			return 'ok';
    	}
		/**
		 *更新总单表数据
		 *
		 *
		 * */
		 public function update_mbl($data = '',$GUID){
			 $this->db->where('GUID', $GUID); 
        	$this->db->update('kjw_mbl', $data);	 
        	//$this->db->update('con_freightlot', $data,"GUID=$GUID");	    		
    		//$list = $query->result_array();
    		//return $list;
    		return 'ok';
    	}

		/**
		 *更新分单表数据
		 *
		 *
		 * */
		 public function update_hbl($data = '',$GUID){
			 $this->db->where('GUID', $GUID); 
        	$this->db->update('kjw_hbl',$data);	 
        	//$this->db->update('con_freightlot', $data,"GUID=$GUID");	    		
    		//$list = $query->result_array();
    		//return $list;
    		return 'ok';
    	}

		/**
		 *删除总单数据
		 *
		 *
		 * */
		public function delete_mbl($GUID){
            $this->db->where_in('GUID',$GUID)->delete('kjw_mbl');    		
    		return 'ok';
		}
		
				
		/**
		 *删除分单数据
		 *
		 *
		 * */
		public function delete_hbl($MBL){
            $this->db->where_in('MBL',$MBL)->delete('kjw_hbl');
			//$this->db->or_where($GUID)->delete('kjw_hbl');
   		
    		return 'ok';
		}
		
		
		
		/**
		 *删除分单数据
		 *
		 *
		 * */
		public function delete_hbl_GUID($GUID){
            $this->db->where_in('GUID',$GUID)->delete('kjw_hbl');
			//$this->db->or_where($GUID)->delete('kjw_hbl');
   		
    		return 'ok';
		}
		
		/**
		 *删除批次数据
		 *
		 *
		 * */
		public function delete_batch($MBL){
            $this->db->where_in('MBL',$MBL)->delete('kjw_tally_batch');    		
    		return 'ok';
		}

}

