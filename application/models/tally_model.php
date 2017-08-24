<?php
/**
 *理货模型（理货操作+理货报告）
 *
 *
 **/

class Tally_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}
		
		 /**
     *获取登录角色
     *
     *
     * */
    public function location(){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('*')->from('con_freightlot')->get();
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
     * 批次理货
     *总行数
     *
     *
     * */
    public function count_num($where = ''){
        $query = $this->db->select('count(*)')->from('sts_tally_head_hu')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
	
	
	   /**
		 *导出的数据
		 *
		 *
		 * */
	public function export_data($where = ''){
      $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->get();
      $total = $query->result_array();
      return $total;
		}

		  /**
		 *导出的数据
		 *
		 *
		 * */
	public function export_batch_data($where = ''){
      $query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->get();
      $total = $query->result_array();
      return $total;
		}
		
		 /**
		 *导出的数据
		 *
		 *
		 * */
		 public function export_ensure_data($where = ''){
        $query = $this->db->select('*')->from('kjw_mbl_ensure_yd')->where($where)->get();
        $list = $query->result_array();
        return $list;
    }
	
	 /**
		 *导出的数据
		 *
		 *
		 * */
		 public function export_master_data($where = ''){
        $query = $this->db->select('*')->from('kjw_mbl_yd')->where($where)->get();
        $list = $query->result_array();
        return $list;
    }
	
	
	 /**
		 *导出的数据
		 *
		 *
		 * */
		 public function export_pre_data($where = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->get();
        $list = $query->result_array();
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

            $this->db->update('sts_tally_head_hu', $data, $condition);

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
        $this->db->where_in('GUID',$data)->delete('sts_tally_head_hu');
        return 'ok';
    }
    /**
     * 拆包理货
     *总行数
     *
     *
     * */
    public function count_num_unpacking($where = ''){
        $query = $this->db->select('count(*)')->from('sts_tally_head_hu')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_unpacking($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1_unpacking($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }

    /**
     *获取检索号
     *
     *
     * */
    public function get_mbl_unpacking($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('MBL')->from('sts_tally_head_hu')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function tally_unpacking_insert($data = ''){
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
    public function tally_unpacking_update($data='',$condition=''){

        $this->db->update('sts_tally_head_hu', $data, $condition);

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
    public function tally_unpacking_del($data= ''){
        $this->db->where_in('GUID',$data)->delete('sts_tally_head_hu');
        return 'ok';
    }
    /**
     * 预报理货报告
     *总行数
     *
     *
     * */
    /**
     *总行数
     *
     *
     * */
    public function count_num_pre($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_mbl_pre_yd')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_pre($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->order_by('TOTALTRANSFERNO','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1_pre($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    /**
     *总行数
     *
     *
     * */
    public function count_num_pre1($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_hbl')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_pre1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_hbl')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list_pre2($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_hbl')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function get_list_pre3(){
        $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','ASC')->get();
        $list = $query->result_array();
        return $list;
    }
    //获取预报信息
    public function get_list_pre4($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->order_by('TOTALTRANSFERNO','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    //获取库位
    public function get_list_location(){
        $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','desc')->get();
        $list = $query->result_array();
        return $list;
    }
    /**
     *获取检索号
     *
     *
     * */
    public function get_report_pre($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('TOTALTRANSFERNO')->from('kjw_mbl_pre_yd')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入预报理货报告数据
     *
     *
     * */
    public function report_insert_pre($data = ''){
        $this->db->insert('kjw_mbl_pre_yd', $data);
        return 'ok';
    }

    public function report_insert_pre1($data = ''){
        $this->db->insert('kjw_hbl', $data);
        //$list = $query->result_array();
        //return $list;
        return 'ok';
    }
    /**
     *更新数据
     *
     *
     * */
    public function get_list1_pre1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function report_update_pre1($data='',$condition=''){

        $this->db->update('kjw_mbl_pre_yd', $data, $condition);
        return 'ok';
    }
    public function report_update_pre($data='',$condition=''){

        $this->db->update('kjw_hbl', $data, $condition);
        return 'ok';
    }

    /**
     *删除数据
     *
     *
     * */
    public function report_pre_del($data= ''){
        $this->db->where_in('GUID',$data)->delete('kjw_mbl_pre_yd');
        return 'ok';
    }
    //删除理货信息
    public function report_del_pre($data= ''){
        $this->db->where_in('GUID',$data)->delete('kjw_hbl');
        return 'ok';
    }
    /*拆包理货查询
     *总行数
     *
     *
     * */
    public function count_num_unpacking_search($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_tally_batch')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];

    }

    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_unpacking_search($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_tally_batch')->where($where)->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1_unpacking_search($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_tally_unpacking')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }

    /**
     *获取检索号
     *
     *
     * */
    public function get_mbl_unpacking_search($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('MBL')->from('sts_tally_head_hu')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }
/*  总单理货报告*/
    /**
     *总行数
     *
     *
     * */
    public function count_num_master($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_mbl_yd')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_master($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_yd')->where($where)->order_by('TOTALTRANSFERNO','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1_master($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    //获取总单理货报告信息
    public function get_list_master4($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_yd')->where($where)->order_by('TOTALTRANSFERNO','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    /**
     *总行数
     *
     *
     * */
    public function count_num_master1($where = ''){
        $query = $this->db->select('count(*)')->from('sts_tally_head_hu')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_master1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list_master2($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function get_list_master3(){
        $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','ASC')->get();
        $list = $query->result_array();
        return $list;
    }
/*    //获取库位
    public function get_list_location(){
        $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','desc')->get();
        $list = $query->result_array();
        return $list;
    }*/
    /**
     *获取检索号
     *
     *
     * */
    public function get_report_master($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('TOTALTRANSFERNO')->from('kjw_mbl_pre_yd')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function report_insert_master($data = ''){
        $this->db->insert('kjw_mbl_yd', $data);
        return 'ok';
    }

    public function report_insert_master1($data = ''){
        $this->db->insert('sts_tally_head_hu', $data);
        return 'ok';
    }
    /**
     *更新数据
     *
     *
     * */
    public function get_list1_master1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_pre_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function report_update_master($data='',$condition=''){
        $this->db->update('sts_tally_head_hu', $data, $condition);
        return 'ok';
    }
    public function report_update_master1($data='',$condition=''){

        $this->db->update('kjw_mbl_yd', $data, $condition);
        return 'ok';
    }
    /**
     *删除数据
     *
     *
     * */
    //删除理货信息
    public function report_del_master($data= ''){
        $this->db->where_in('GUID',$data)->delete('sts_tally_head_hu');
        return 'ok';
    }
    public function report_del_master1($data= ''){
        $this->db->where_in('GUID',$data)->delete('kjw_mbl_yd');
        return 'ok';
    }
    /*  确报理货报告*/
    /**
     *总行数
     *
     *
     * */
    public function count_num_ensure($where = ''){
        $query = $this->db->select('count(*)')->from('kjw_mbl_ensure_yd')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_ensure($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_ensure_yd')->where($where)->order_by('TOTALTRANSFERNO','desc')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list1_ensure($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_ensure_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    //获取总单理货报告信息
    public function get_list_ensure4($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_ensure_yd')->where($where)->order_by('TOTALTRANSFERNO','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    /**
     *总行数
     *
     *
     * */
    public function count_num_ensure1($where = ''){
        $query = $this->db->select('count(*)')->from('sts_tally_head_hu')->where($where)->get();
        $total = $query->row_array();
        return $total['count(*)'];
    }
    /**
     *获取数据列表
     *
     *
     * */
    public function get_list_ensure1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->result_array();
        return $list;
    }
    public function get_list_ensure2($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('sts_tally_head_hu')->where($where)->order_by('HBL','ASC')->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function get_list_ensure3(){
        $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','ASC')->get();
        $list = $query->result_array();
        return $list;
    }
    /*    //获取库位
        public function get_list_location(){
            $query = $this->db->select('*')->from('con_freightlot')->order_by('INDEX_NO','desc')->get();
            $list = $query->result_array();
            return $list;
        }*/
    /**
     *获取检索号
     *
     *
     * */
    public function get_report_ensure($where = '', $limit = '', $offset = ''){
        //SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1
        $query = $this->db->select('TOTALTRANSFERNO')->from('kjw_mbl_ensure_yd')->where($where)->limit('1')->get();
        $list = $query->result_array();
        return $list;
    }

    /**
     *插入数据
     *
     *
     * */
    public function report_insert_ensure($data = ''){
        $this->db->insert('kjw_mbl_ensure_yd', $data);
        return 'ok';
    }

    public function report_insert_ensure1($data = ''){
        $this->db->insert('sts_tally_head_hu', $data);
        return 'ok';
    }
    /**
     *更新数据
     *
     *
     * */
    public function get_list1_ensure1($where = '', $limit = '', $offset = ''){
        $query = $this->db->select('*')->from('kjw_mbl_ensure_yd')->where($where)->limit($limit,$offset)->get();
        $list = $query->row_array();
        return $list;
    }
    public function report_update_ensure($data='',$condition=''){
        $this->db->update('sts_tally_head_hu', $data, $condition);
        return 'ok';
    }
    public function report_update_ensure1($data='',$condition=''){

        $this->db->update('kjw_mbl_ensure_yd', $data, $condition);
        return 'ok';
    }
    /**
     *删除数据
     *
     *
     * */
    //删除理货信息
    public function report_del_ensure($data= ''){
        $this->db->where_in('GUID',$data)->delete('sts_tally_head_hu');
        return 'ok';
    }
    public function report_del_ensure1($data= ''){
        $this->db->where_in('GUID',$data)->delete('kjw_mbl_ensure_yd');
        return 'ok';
    }
}

