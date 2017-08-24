<?php
/**
 *用户管理
 *
 *
 **/

class Limit_manage_model extends CI_Model {

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
        $query = $this->db->select('count(*)')->from('eci_role')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('eci_role')->where($where)->order_by('ROLE_ID','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('eci_role')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function get_list3($where = ''){
        $query = $this->db->select('*')->from('eci_role_function')->where($where)->get();
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
        $query = $this->db->select('ROLE_NAME')->from('eci_role')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function tally_batch_insert($data = ''){
        $this->db->insert('eci_role', $data);

        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }
    public function limit_control_insert($data = ''){
        $this->db->insert('eci_role_function', $data);

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

        $this->db->update('eci_role', $data, $condition);

        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }
    public function limit_control_update($data='',$condition=''){

        $this->db->update('eci_role_function', $data, $condition);

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
        $this->db->where_in('ROLE_ID',$data)->delete('eci_role');
        return 'ok';
    }

}

