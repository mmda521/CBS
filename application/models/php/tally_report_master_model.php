<?php

class Tally_report_master_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}
    /**
     *总行数
     *
     *
     * */
    public function count_num($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_mbl_yd')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_yd')->where($where)->order_by('FLIGHTNO','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->limit($limit,$offset)->get();
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
        $query = $this->db->select('TOTALTRANSFERNO')->from('kjw_mbl_yd')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function tally_batch_insert($data = ''){
        $this->db->insert('sts_tally_head_hu', $data);
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

            $this->db->update('kjw_mbl_yd', $data, $condition);

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
        $this->db->where_in('GUID',$data)->delete('kjw_mbl_yd');
    }

}

