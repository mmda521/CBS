<?php
/**
 *用户管理
 *
 *
 **/

class User_model extends CI_Model {

    public function __construct(){
        $this->load->database();

    }
    /**
     *用户管理
     *总行数
     *
     *
     * */
    public function count_num($where = ''){
        $query = $this->db->select('count(*)')->from('eci_user')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }
	
	 /**
		 *导出的数据
		 *
		 *
		 * */
		 public function export_user_data($where = ''){
        $query = $this->db->select('*')->from('eci_user')->where($where)->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('eci_user')->where($where)->order_by('USER_ID','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('eci_user')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function get_list2(){
        $query = $this->db->select('id,name,pid as parentid,url,status,addtime,disorder ,url_type,collapsed,closeable')->from('eci_menu')->order_by('id','asc')->get();
        $list =array();
        if($query){
            foreach($query->result_array() as $row){
                $list[] = $row ;
            }
        }

        return $list;
    }
    /**
     *获取检索号
     *
     *
     * */
    public function get_mbl($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('LOGIN_NO')->from('eci_user')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function tally_batch_insert($data = ''){
        $this->db->insert('eci_user', $data);

        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }


    /**
     *更新数据
     *
     *
     * */
    public function tally_batch_update($data='',$condition=''){

        $this->db->update('eci_user', $data, $condition);

        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }

    /**
     *删除数据
     *
     *
     * */
    //删除理货信息
    public function tally_batch_del($data= ''){
        $this->db->where_in('USER_ID',$data)->delete('eci_user');
        return 'ok';
    }

}

