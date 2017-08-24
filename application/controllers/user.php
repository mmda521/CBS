<?php
/**
 *用户管理
 *
 *
 **/
class User extends MY_Controller {

    public function __construct()
    {
        $this->need_login = true;
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('common_function_helper');
        $this->load->helper('guid');
        $this->load->library("common_page");
        $this->load->model('user_model');
        $this->load->model('Password_change_model');
        $this->load->model('Limit_manage_model');
        $this->load->library('session');

    }

    /**
    *
    *用户管理
    *
    * */
    public function user_manage()
    {
        $this->load->view('CBS/user_manage', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function user_manage_ajax_data(){
            //获取分页第几页
            $page = $this->input->get_post("page");
            if($page <=0 ){
                $page = 1 ;
            }
            //数据分页
            $limit = 5;//每一页显示的数量
            $offset = ($page-1)*$limit;//偏移量

            $condition = array();

            //获取总运单号
            $login_no = $this->input->get_post("login_no");
            if(!empty($login_no)){
                $condition['LOGIN_NO'] = $login_no;
            }
            //获取客户
            $user_name = $this->input->get_post("user_name");
            if(!empty($user_name)){
            $condition['USER_NAME'] = $user_name;
        }
        $total = $this->user_model->count_num($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->user_model->get_list($condition,$limit,$offset);
        foreach($list as $k=>$v){
            $list[$k]['EP_ADMIN'] = ($v['EP_ADMIN'] == 'Y' )?"是":'<font color="red">否</font>';
            //$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);

        }
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
	
	
	 public function user_manage_export(){
           
            $condition = array();

            //获取总运单号
            $login_no = $this->input->get_post("login_no");
            if(!empty($login_no)){
                $condition['LOGIN_NO'] = $login_no;
            }
            //获取客户
            $user_name = $this->input->get_post("user_name");
            if(!empty($user_name)){
            $condition['USER_NAME'] = $user_name;
        }
        $total = $this->user_model->export_user_data($condition);
       
        foreach($total as $k=>$v){
            $total[$k]['EP_ADMIN'] = ($v['EP_ADMIN'] == 'Y' )?"是":"否";
         
        }
        $this->load->library("phpexcel");//ci框架中引入excel类
	     $PHPExcel = new PHPExcel();	  	 
         $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','公司')
            ->setCellValue('B1','登录账号')
            ->setCellValue('C1','用户名称')
            ->setCellValue('D1','创建日期')
			->setCellValue('E1','机构管理员')
            ->setCellValue('F1','操作点');			 
		   foreach($total as $k =>$v){
             $num=$k+2;
             $PHPExcel->setActiveSheetIndex(0)
                         //Excel的第A列，uid是你查出数组的键值，下面以此类推
                          ->setCellValue('A'.$num, $v['COMPANY_CODE'])    
                          ->setCellValue('B'.$num, $v['LOGIN_NO'])
                          ->setCellValue('C'.$num, $v['USER_NAME'])
						  ->setCellValue('D'.$num, $v['CREATE_DATE'])    
                          ->setCellValue('E'.$num, $v['EP_ADMIN'])
                          ->setCellValue('F'.$num, $v['UDF1']);
            }			
			 $PHPExcel->getActiveSheet()->setTitle('用户管理信息导出-'.date('Y-m-d',time()));
			 //设置宽度
			 $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
			 $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
             $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);			 
			
			//设置水平居中
			$PHPExcel->getActiveSheet()->getStyle('A1:F1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
           // $PHPExcel->setActiveSheetIndex(0);
			header('Pragma:public');
             header("Content-Type: application/vnd.ms-excel;charset=uft8");  
			  header("Content-Disposition:attachment; filename=FILE".date("YmdHis").".xlsx");  
			$objWriter = new PHPExcel_Writer_Excel2007($PHPExcel);	
            //$objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
            $objWriter->save('php://output');	
    }
	
	
    public function user_manage_add()
    {
        $this->load->view('CBS/user_manage_add', '');
    }
    public function user_manage_add_ajax_data(){
        $company_code       = $this->input->get_post("company_code");
        $login_no   = $this->input->get_post("login_no");
        $user_name = $this->input->get_post("user_name");
        $status    = $this->input->get_post("status");
        $ep_admin       = $this->input->get_post("ep_admin");
        $role= $this->input->get_post("role");
        $udf1   = $this->input->get_post("udf1");
        //查询检索号是否存在（假设检索号不能重复）
        $condition = array();
        $condition['login_no'] = $login_no;
        $info = $this->user_model->get_mbl($condition);
        if(!empty($info)){
            //showmessage("检索号{$index_no}已经存在","sample2/add",3,0);
            exit();
        }

        //插入数据
        $data = array(
            'COMPANY_CODE'          =>$company_code,
            'LOGIN_NO'      =>$login_no,
            'USER_NAME'      =>$user_name,
            'STATUS'  =>$status,
            'EP_ADMIN'=>$ep_admin,
            'ROLE_ID'=>$role,
            'UDF1'        =>$udf1,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->user_model->tally_batch_insert($data);
        //showmessage("添加库位成功","sample2/index",3,1);
        $this->load->view('CBS/user_manage', '');
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    //编辑理货信息
    public function user_manage_edit()
    {

        $user_id = $this->input->get_post("user_id");

        $condition = array();
        $condition['USER_ID'] = $user_id;
        $list['info'] = $this->user_model->get_list1($condition);
        $this->load->view('CBS/user_manage_edit', $list);
    }
    public function user_manage_edit_ajax_data(){
        $company_code       = $this->input->get_post("company_code");
        $login_no   = $this->input->get_post("login_no");
        $user_name = $this->input->get_post("user_name");
        $status    = $this->input->get_post("status");
        $ep_admin       = $this->input->get_post("ep_admin");
        $udf1   = $this->input->get_post("udf1");
        //编辑数据
        $user_id = $this->input->get_post("user_id");
        $condition = array();
        $condition['USER_ID'] = $user_id;
        $data = array(
            'COMPANY_CODE'          =>$company_code,
            'LOGIN_NO'      =>$login_no,
            'USER_NAME'      =>$user_name,
            'STATUS'  =>$status,
            'EP_ADMIN'=>$ep_admin,
            'UDF1'        =>$udf1,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->user_model->tally_batch_update($data,$condition);
        //showmessage("添加库位成功","sample2/index",3,1);
        $this->load->view('CBS/user_manage', '');
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }

    //删除理货信息
    public function user_manage_del_ajax_data()
    {
        $data = $this->input->get_post("user_id");
        if ($data) {
            $this->user_model->tally_batch_del($data);
            echo result_to_towf_new('1', 0, '删除成功', NULL) ;
        }
    }
    /**
    *
    *密码修改
    *
    * */
    public function password_change()
    {
        $login_no=$_SESSION['LOGIN_NO'];
        $condition = array();
        $condition['LOGIN_NO'] = $login_no;
        $data['info']=$this->Password_change_model->get_list1($condition);
        $this->load->view('CBS/pw_modify',$data);
    }
    //编辑密码信息
    public function password_change_edit()
    {
        $login_no = $this->input->get_post("login_no");
        $username = $this->input->get_post("username");
        $password= $this->input->get_post("password");
        $enpassword = $this->input->get_post("enpassword");
        //编辑数据
        $condition = array();
        $condition['LOGIN_NO'] = $login_no;
        $data = array(
            'LOGIN_NO'=>$login_no,
            'USER_NAME'      =>$username,
            'PASSWORD'      =>$password
        );

        //echo $status;
        //break;
        $this->Password_change_model->password_change_update($data,$condition);
        //showmessage("添加库位成功","sample2/index",3,1);
        $this->load->view('CBS/view_login','');
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    /**
    *
    *权限管理
    *
    * */
    public function limit_manage()
    {
        $this->load->view('CBS/limit_manage', '');
    }
    /**
     *ajax获取数据
     *
     *
     * */
    public function limit_manage_ajax_data(){
        //获取分页第几页
        $page = $this->input->get_post("page");
        if($page <=0 ){
            $page = 1 ;
        }
        //数据分页
        $limit = 5;//每一页显示的数量
        $offset = ($page-1)*$limit;//偏移量

        $condition = array();

        //获取总运单号
        $role_name = $this->input->get_post("role_name");
        if(!empty($role_name)){
            $condition['ROLE_NAME'] = $role_name;
        }
        //获取客户
        $role_desc = $this->input->get_post("role_desc");
        if(!empty($role_desc)){
            $condition['ROLE_DESC'] = $role_desc;
        }
        $total = $this->Limit_manage_model->count_num($condition);
        $page_string = $this->common_page->page_string($total, $limit, $page);

        $list = $this->Limit_manage_model->get_list($condition,$limit,$offset);
        echo result_to_towf_new($list, 1, '成功', $page_string) ;
    }
    public function limit_manage_add()
    {
        $this->load->view('CBS/limit_manage_add', '');
    }
    public function limit_manage_add_ajax_data(){
        $company_code       = $this->input->get_post("company_code");
        $role_name   = $this->input->get_post("role_name");
        $role_desc = $this->input->get_post("role_desc");
        //查询检索号是否存在（假设检索号不能重复）
        $condition = array();
        $condition['role_name'] = $role_name;
        $info = $this->Limit_manage_model->get_mbl($condition);
        if(!empty($info)){
            //showmessage("检索号{$index_no}已经存在","sample2/add",3,0);
            exit();
        }

        //插入数据
        $data = array(
            'COMPANY_CODE'          =>$company_code,
            'ROLE_NAME'      =>$role_name,
            'ROLE_DESC'      =>$role_desc,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->Limit_manage_model->tally_batch_insert($data);
        //showmessage("添加库位成功","sample2/index",3,1);
        $this->load->view('CBS/limit_manage', '');
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }
    }
    //编辑理货信息
    public function limit_manage_edit()
    {

        $role_id = $this->input->get_post("role_id");

        $condition = array();
        $condition['ROLE_ID'] = $role_id;
        $list['info'] = $this->Limit_manage_model->get_list1($condition);
        $this->load->view('CBS/limit_manage_edit', $list);
    }
    public function limit_manage_edit_ajax_data(){
        $role_id       = $this->input->get_post("role_id");
        $company_code       = $this->input->get_post("company_code");
        $role_name   = $this->input->get_post("role_name");
        $role_desc = $this->input->get_post("role_desc");
        $condition = array();
        $condition['role_id'] = $role_id;
        //编辑数据
        $data = array(
            'ROLE_ID' =>$role_id,
            'COMPANY_CODE'   =>$company_code,
            'ROLE_NAME'      =>$role_name,
            'ROLE_DESC'      =>$role_desc,
            'CREATE_DATE'=>date('Y-m-d h:i:s',time())
        );

        //echo $status;
        //break;
        $this->Limit_manage_model->tally_batch_update($data,$condition);
        //showmessage("添加库位成功","sample2/index",3,1);
        $this->load->view('CBS/limit_manage', '');
        // 日志处理 （放到后期）
        // if($array['affect_num']>=1){
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
        //     header("Location:".site_url("user/index"));
        //     //showmessage("添加用户成功","user/index",3,1);
        //     //exit();
        // }else{
        //     write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
        //     showmessage("添加用户失败","user/add",3,0);
        //     exit();
        // }

    }

    //删除理货信息
    public function limit_manage_del_ajax_data()
    {
        $data = $this->input->get_post("role_id");
        if ($data) {
            $this->Limit_manage_model->tally_batch_del($data);
            echo result_to_towf_new('1', 0, '删除成功', NULL) ;
        }
    }
    public function limit_control()
    {
       $list=$this->user_model->get_list2();
        $result = array();
        if($list){
            foreach($list as $k=>$v){
                $result[$v['id']]  = $v ;
            }
        }
        $list['info'] = genTree9($result,'id','parentid','items');
        $this->load->view('CBS/limit_manage_control',$list);
    }
	 public function limit_control_ajax_data()
    {
        $role_id = $this->input->get_post("role_id");
        $role1 = $this->input->get_post("role");
        $role=implode(',',$role1);
        $condition = array();
        $condition['ROLE_ID'] = $role_id;
        $list=$this->Limit_manage_model->get_list3($condition);
        if($list){
            $data = array(
                'ROLE_ID'=>$role_id,
                'PROGRAM_ID' =>$role,
                'CREATE_DATE'=>date('Y-m-d h:i:s',time()),
                'ID'=>guid_create()
            );
            $this->Limit_manage_model->limit_control_update($data,$condition);
        }else{
            $data = array(
                'ROLE_ID'=>$role_id,
                'PROGRAM_ID' =>$role,
                'CREATE_DATE'=>date('Y-m-d h:i:s',time()),
                'ID'=>guid_create()
            );
            $this->Limit_manage_model->limit_control_insert($data);
        }
    }
	
}
