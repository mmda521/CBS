<?php
/**
 *密码修改
 *
 *
 **/

class Password_change_model extends CI_Model {

    public function __construct(){
        $this->load->database();

    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->order_by('MBL','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('eci_user')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }

    /**
     *获取检索号
     *
     *
     * */
    public function get_mbl($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('MBL')->from('sts_tally_head_hu')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }
    /**
     *更新数据
     *
     *
     * */
    public function password_change_update($data='',$condition=''){

        $this->db->update('eci_user', $data, $condition);

        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }
}

