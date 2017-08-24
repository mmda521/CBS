<?php
/**
 *样例
 *
 *
 **/

class Sample_model extends CI_Model {

		public function __construct(){
			$this->load->database();

		}

		/**
		 *查询数据
		 *
		 *
		 * */
		public function get($condition = '',$limit = '',$offset = ''){
			//$limit = 8; //每页的数量
			//$offset = 0; //从第几条记录开始查
			$query = $this->db->get_where('CON_FREIGHTLOT',$condition,$limit,$offset);

			//$query = $this->db->get('CON_FREIGHTLOT');//此处是数据库表的名字
			return $query->result_array();
		}

		/**
		 *插入数据
		 *
		 *
		 * */
		public function insert(){
			
		}

		/**
		 *更新数据
		 *
		 *
		 * */
		public function update(){
			
		}

		/**
		 *删除数据
		 *
		 *
		 * */
		public function delete(){
			
		}

}

