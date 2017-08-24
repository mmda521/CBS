<?php
/*
 *common model 文件
 *
 */
class M_common extends CI_Model {
	public $db ;
	public $type ; 
	function M_common($params = array() ){
		$type = '' ;
		$type =( isset($params['type']) && $params['type'] )? $params['type'] : 'real_data' ;
		parent::__construct();
		$this->db = $this->load->database($type,true);
	}
	
	//插入一条数据
	function insert_one($table,$data){
		$this->db->insert($table,$data) ;
		return array(
			'affect_num'=>$this->db->affected_rows() ,
			'insert_id'=>$this->db->insert_id(),
			'sql'=>$this->db->last_query()
		);
	}
	//查询1条数据，返回结果
	function query_one($sql){		
		return $this->db->query($sql)->row_array();
	}
	//查询list data
	function querylist($where){
        $sql = $this->db->select('id,name,pid as parentid,url,status,addtime,disorder ,url_type,collapsed,closeable')->from('eci_menu')->where_in('id',$where)->order_by('id','asc')->get();
		$result =array();
		if($sql){
			foreach($sql->result_array() as $row){
	    		$result[] = $row ;				
	    	}		
		}
    	return $result ;
	}
    public function get_list($where = ''){
        $query = $this->db->select('PROGRAM_ID')->from('eci_role_function')->where($where)->get();
        if($query){
            foreach($query->result_array() as $k=>$row){
                $list = $row['PROGRAM_ID'] ;
		//PC::debug($list);
            }
        }
        return $list;
    }
	//查询返回的结果
	function query_count($sql){
		$query = $this->db->query($sql);
		$num_array = $query->result_array();
		$num = 0 ;
		if(isset($num_array[0]) && !empty($num_array[0])){
			foreach ($num_array[0] as $k=>$v){
				$num = $v ;
				break ;
			}
		}	
		return $num ;
		
	}
	//删除数据
	function del_data($sql){
	
		$query = $this->db->query($sql);
		return $this->db->affected_rows(); //返回影响的行数
		
	}
	//修改数据
	function update_data($sql){
	
		$query = $this->db->query($sql);
		return $this->db->affected_rows(); //返回影响的行数
	}

	

}